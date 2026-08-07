<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(
    'book_id',
    'reader_id',
    'status',
    'loan_date',
    'due_date',
    'returned_at',
    'fine_amount',
)]
class BookLoans extends Model
{
    protected $casts = [
        'status'
    ];
}
