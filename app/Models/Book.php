<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'subtitle',
        'isbn13',
        'price',
        'image',
        'url',
    ];

    protected $searchableFields = ['*'];

    public function libraries()
    {
        return $this->hasMany(Library::class);
    }
}
