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

    public function debt(): Expense
    {
        if ($this->getAttribute('was_debt')) {
            return Expense::where('goods_type', $this->getAttribute('sellingable_type'))->where('goods_type_id', $this->getAttribute('sellingable_id'))->first();
        }

        return new Expense();
    }
}
