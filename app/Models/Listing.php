<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the books for the list.
    */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Get the owner for the list.
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
