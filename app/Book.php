<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Collective\Html\Eloquent\FormAccessible;
use Storage;

class Book extends Model
{
    use FormAccessible;
    use Traits\Sortable;
    
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
	protected $fillable = ['title', 'author', 'isbn13', 'publication_date', 'position'];

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
    public static $coverExts = [
        'gif',
        'jpg',
        'jpeg',
        'png'
    ];

	/**
	 * Create a new book instance.
	 * 
     * @param  array  $attributes
	 * @return User
	 */
	public function __construct(array $attributes = [])
    {
        $this->initializeMoves();
        
		return parent::__construct($attributes);
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
	 * Save model.
	 * 
	 * @param  array  $options
	 * @return void
	 */
	public function save(array $options = [])
    {
        $this->position = $this->position ?? $this->user->countBooks(); # DEFAULT POSITION IS LAST
        
        parent::save($options);
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
