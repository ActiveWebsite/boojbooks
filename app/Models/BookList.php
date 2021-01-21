<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// List  is a reserved keyword, using BookList as name
class BookList extends Model
{
    use HasFactory;
    protected $table = "lists";

    protected $fillable = [
        'name',
        'user_id'
    ];


    public function books() {
        return $this->hasManyThrough(Book::class, 'list_books');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
