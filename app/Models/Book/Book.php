<?php

namespace App\Models\Book;

use App\Models\Author\Author;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'author_id',
    'title',
    'isbn',
    'description',
    'publication_year',
    'total_copies',
    'available_copies',
    'is_active',
])]
class Book extends Model
{
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function bookLoans(): HasMany
    {
        return $this->hasMany(BookLoan::class, 'book_id', 'id');
    }
}
