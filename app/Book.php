<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    
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
	 * Get book owner.
	 * 
	 * @return User
	 */
	public function user()
    {
		return $this->belongsTo('App\User');
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
}
