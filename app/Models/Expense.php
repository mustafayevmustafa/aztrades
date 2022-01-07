<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model implements Recordable
{
    use SoftDeletes, \Altek\Accountant\Recordable;

    protected $fillable = [
        'expense_type_id',
        'note',
        'expense',
        'goods_type',
        'goods_type_id',
        'is_returned',
        'is_income',
        'debt_selling_id',
        'customer'
    ];

    protected $casts = ['is_returned' => 'boolean', 'is_income' => 'boolean'];

    public function type(): BelongsTo
    {
        return $this->belongsTo(ExpensesType::class, 'expense_type_id')->withDefault();
    }

    public function goodsType(): BelongsTo
    {
        $type = Onion::class; // assume the goods type is onion at first

        if($this->getAttribute('goods_type') == Potato::class) $type = Potato::class;

        return $this->belongsTo($type, 'goods_type_id')->withDefault();
    }

    public function selling(): BelongsTo
    {
        return $this->belongsTo(Selling::class, 'debt_selling_id')->withDefault();
    }
}
