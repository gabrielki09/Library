<?php

namespace App\Book;

enum BookLoansStatus: string
{
    case ACTIVE = 'active';
    case RETURNED = 'returned';
    case LATE = 'late';
    case CANCELED = 'canceled';
}
