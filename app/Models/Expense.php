<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $fillable = ['expense_type_id', 'note', 'expense', 'goods_type', 'goods_type_id'];

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

}
