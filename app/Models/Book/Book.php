<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(
    'author_id',
    'title',
    'isbn',
    'description',
    'publication_year',
    'total_copies',
    'available_copies',
    'is_active',
)]
class Book extends Model
{
    //
}
