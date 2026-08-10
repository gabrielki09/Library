<?php

namespace App\Models\Book;

use App\Enums\Book\BookLoansStatus;
use App\Models\Reader\Reader;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    use SoftDeletes;

    protected $casts = [
        'due_date' => 'date',
        'returned_at' => 'datetime',
        'fine_amount' => 'decimal:2',
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
