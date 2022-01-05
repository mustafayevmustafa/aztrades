<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Selling extends Model implements Recordable
{
    use SoftDeletes, \Altek\Accountant\Recordable;

    protected $fillable = [
        'customer',
        'content',
        'status',
        'was_debt',
        'weight',
        'price',
        'sac_count',
        'sac_name',
        'type',
        'sellingable_type',
        'sellingable_id',
    ];

    protected $casts = [
        'status' => 'boolean',
        'was_debt' => 'boolean',
    ];

    public static function flowType(): array
    {
        return ['Nəgd', 'Borc'];
    }

    public function sellingable(): MorphTo
    {
        return $this->morphTo();
    }
}
