<?php

namespace App\Models\Book;

use App\Models\Reader\Reader;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'book_id',
    'reader_id',
    'status',
    'loan_date',
    'due_date',
    'returned_at',
    'fine_amount',
])]
class BookLoans extends Model
{
    protected $casts = [
        'status'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function reader(): BelongsTo
    {
        return $this->belongsTo(Reader::class, 'reader_id');
    }
}
