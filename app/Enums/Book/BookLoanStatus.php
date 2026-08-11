<?php

namespace App\Enums\Book;

enum BookLoanStatus: string
{
    case ACTIVE = 'active';
    case RETURNED = 'returned';
    case LATE = 'late';
    case CANCELED = 'canceled';
}
