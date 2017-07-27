<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Collective\Html\Eloquent\FormAccessible;
use App\Scopes\UserScope;
use Storage;

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
     * @static string
     */
    public static $covers = 'public/covers';
    
    /**
     * Supported cover image types.
     *
     * @static array
     */
    public static $coverExts = 
        [
            'gif',
            'jpg',
            'jpeg',
            'png'
        ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope(new UserScope); # ONLY LOAD CURRENT USER'S BOOKS
    }

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
     * Set the book's publication date.
     *
     * @param  string  $value
     * @return void
     */
    public function setPublicationDateAttribute($value)
    {
        $this->attributes['publication_date'] = $value ?: null; # REPLACE EMPTY WITH NULL
    }

	/**
	 * Repair the order column.
	 * 
	 * @return void
	 */
	protected function resort()
    {
        $books = self::orderBy('position')->get();
        
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
        $this->deleteCover();
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
        
        $position = $this->position;
        
        $book2 = self::where('position', '<', $position)->orderBy('position', 'desc')->first();
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
        
        $position = $this->position;
        
        $book2 = self::where('position', '>', $position)->orderBy('position', 'asc')->first();
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
            return Storage::url(self::$covers . '/' . $this->id . '.' . $ext);
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
        foreach (self::$coverExts as $ext) {
            if (Storage::exists(self::$covers . '/' . $this->id . '.' . $ext)) {
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
            return Storage::delete(self::$covers . '/' . $this->id . '.' . $ext);
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
        if (!in_array($file->extension(), self::$coverExts)) { # INVALID EXTENSION
            return false;
        }
        $this->deleteCover();
        return $file->storeAs(self::$covers, $this->id . '.' . $file->extension());
	}
}
