<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'title',
        'cover_image',
        'publication_date',
        'rating',
        'user_id',
    ];

    public function authors() {
        return $this->belongsToMany(Author::class, 'book_authors', 'book_id', 'author_id');
    }



    public function lists() {
        return $this->belongsToMany(BookList::class, 'list_books', 'book_id', 'list_id')->withPivot('sort_order');
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'book_genres', 'book_id', 'genre_id');
    }
}
