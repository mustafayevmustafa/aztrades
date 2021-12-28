<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Selling extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'from_sell',
        'content',
        'status',
        'weight',
        'price',
        'sac_count',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function sellingable(): MorphTo
    {
        return $this->morphTo();
    }
}
