<?php

namespace App\Models\Author;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(
    'name',
    'nationality',
    'birth_date',
)]
class Author extends Model
{
    //
}
