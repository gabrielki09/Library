<?php

namespace App\Models\Reader;

use App\Models\Book\BookLoans;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'name',
    'email',
    'document',
    'phone',
    'status',
])]
class Reader extends Model
{
    use SoftDeletes;

    protected $casts = [
        'status'
    ];

    public function bookLoans(): HasMany
    {
        return $this->hasMany(BookLoans::class, 'reader_id', 'id');
    }
}
