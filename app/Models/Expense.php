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
        'is_income',
        'customer'
    ];

    protected $casts = ['is_income' => 'boolean'];

    protected static function boot()
    {
        parent::boot();

        self::deleted(function (Expense $expense) {
            $selling = $expense->getRelationValue('selling');

            $sellingable = $selling->getRelationValue('sellingable');

            if(!is_null($selling->getAttribute('weight'))) {
                $selling->sellingable()->update([
                    'total_weight' => $sellingable->getAttribute('total_weight') + $selling->getAttribute('weight'),
                ]);
            }

            if (!is_null($selling->getAttribute('sac_name'))) {
                if ($selling->getAttribute('sellingable_type') == Onion::class) {
                    $selling->sellingable()->update([
                        $selling->getAttribute('sac_name') => $sellingable->getAttribute($selling->getAttribute('sac_name')) + $selling->getAttribute('sac_count'),
                    ]);
                } else if ($selling->getAttribute('sellingable_type') == Potato::class) {
                    $sac = PotatoSac::find($selling->getAttribute('sac_name'));
                    $sac_count = $sac->getAttribute('sac_count') + $selling->getAttribute('sac_count');

                    if (is_null($selling->getAttribute('weight'))) {
                        $selling->sellingable()->update([
                            'total_weight' => $sellingable->getAttribute('total_weight') + ($sac->getAttribute('sac_weight') * $selling->getAttribute('sac_count')),
                        ]);
                    }

                    $sac->update([
                        'sac_count' => $sac_count,
                        'total_weight' => $sac_count * $sac->getAttribute('sac_weight'),
                    ]);
                }
            }
        });
    }

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
