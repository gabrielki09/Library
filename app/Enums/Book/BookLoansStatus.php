<?php

namespace App\Enums\Book;

enum BookLoansStatus: string
{
    case ACTIVE = 'active';
    case RETURNED = 'returned';
    case LATE = 'late';
    case CANCELED = 'canceled';
}
