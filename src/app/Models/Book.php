<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'list_order',
        'description',
        'author',
        'published',
        'length',
        'rating'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published' => 'date',
    ];


    /**
     * Get the list for the book.
    */
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
    

}

