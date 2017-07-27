<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Collective\Html\Eloquent\FormAccessible;

class Book extends Model
{
    use FormAccessible;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];
    
    /**
     * Cover image storage path.
     *
     * @var array
     */
    protected $covers = 'public/covers';
    
    /**
     * Supported cover image types.
     *
     * @var array
     */
    protected $coverExts = 
        [
            'gif',
            'jpg',
            'jpeg',
            'png'
        ];

	/**
	 * Get book owner.
	 * 
	 * @return User
	 */
	public function user()
    {
		return $this->belongsTo('App\User');
	}

    /**
     * Get the book's publication date for forms.
     *
     * @param  string  $value
     * @return string
     */
    public function formPublicationDateAttribute($value)
    {
        return !empty($value) ? Carbon::parse($value)->format('Y-m-d') : null;
    }

	/**
	 * Repair the order column.
	 * 
	 * @return void
	 */
	protected function resort()
    {
        $user = $this->user;
        
        $books = $user->books()->orderBy('position')->get();
        foreach ($books as $key=>$book) {
            if ($book->position != $key) {
                $book->position = $key;
                $book->save();
            }
        }
	}

	/**
	 * Delete the model.
	 * 
	 * @return void
	 */
	public function delete()
    {
        # WE DO NOT DELETE THE IMAGE BECAUSE BOOKS ARE SET TO SOFT DELETE
        parent::delete();
        
        $this->resort();
	}

	/**
	 * Move book up in list.
	 * 
	 * @return void
	 */
	public function moveUp()
    {
        $this->resort();
        
        $user = $this->user;
        $position = $this->position;
        
        $book2 = $user->books()->where('position', '<', $this->position)->orderBy('position', 'desc')->first();
        if ($book2) {
            DB::beginTransaction();
            $this->position = $book2->position;
            $this->save();
            $book2->position = $position;
            $book2->save();
            DB::commit();
        }
	}

	/**
	 * Move book up in list.
	 * 
	 * @return void
	 */
	public function moveDown()
    {
        $this->resort();
        
        $user = $this->user;
        $position = $this->position;
        
        $book2 = $user->books()->where('position', '>', $this->position)->orderBy('position', 'asc')->first();
        if ($book2) {
            DB::beginTransaction();
            $this->position = $book2->position;
            $this->save();
            $book2->position = $position;
            $book2->save();
            DB::commit();
        }
	}

	/**
	 * Get cover image path.
	 * 
	 * @return string|bool
	 */
	public function getCoverPath()
    {
        $ext = $this->hasCover();
        if ($ext) {
            return \Storage::url($this->covers . '/' . $this->id . '.' . $ext);
        }
        
        return false;
	}

	/**
	 * Check if book has a cover image stored and return the extension.
	 * 
	 * @return string|bool
	 */
	public function hasCover()
    {
        foreach ($this->coverExts as $ext) {
            if (\Storage::disk('local')->exists($this->covers . '/' . $this->id . '.' . $ext)) {
                return $ext;
            }
        }
        
        return false;
	}

	/**
	 * Delete cover image.
	 * 
	 * @return bool
	 */
	public function deleteCover()
    {
        $ext = $this->hasCover();
        if ($ext) {
            return \Storage::delete($this->covers . '/' . $this->id . '.' . $ext);
        }
        
        return true;
	}

	/**
	 * Store cover image from form.
	 * 
     * @param  string  $file
	 * @return string|bool
	 */
	public function storeFormCover(UploadedFile $file)
    {
        if (!in_array($file->extension(), $this->coverExts)) { # INVALID EXTENSION
            return false;
        }
        $this->deleteCover();
        return $file->storeAs($this->covers, $this->id . '.' . $file->extension());
	}
}
