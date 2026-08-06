<?php

namespace App\Models\Reader;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(
    'name',
    'email',
    'document',
    'phone',
    'status',
)]
class Reader extends Model
{
    use SoftDeletes;

    protected $casts = [
        'status'
    ];
}
