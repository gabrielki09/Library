<?php

namespace App\Models\Author;

use App\Models\Book\Book;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'name',
    'nationality',
    'birth_date',
])]
class Author extends Model
{
    use SoftDeletes;

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'author_id');
    }
}
