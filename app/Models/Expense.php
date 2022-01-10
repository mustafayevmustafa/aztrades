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
        'customer',
        'debt_selling_id',
        'closed_rate_id'
    ];

    protected $casts = ['is_income' => 'boolean'];

    protected static function boot()
    {
        parent::boot();

        self::updating(function (Expense $expense) {
            if ($expense->closedRate()->exists()) {
                $rate = $expense->getRelationValue('closedRate');
                $change = $expense->getAttribute('expense') - $expense->getOriginal('expense');

                $expense->closedRate()->update([
                    'pocket' => $rate->getAttribute('pocket') - $change,
                    'expenses' => $rate->getAttribute('expenses') + $change
                ]);
            }
        });

        self::deleted(function (Expense $expense) {
            // Revert the sold goods
            if (!is_null($expense->getAttribute('goods_type'))){
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
            }

            // Revert the closed rate
            if ($expense->closedRate()->exists()) {
                $rate = $expense->getRelationValue('closedRate');
                $data = [];

                switch ($expense->getAttribute('expense_type_id')) {
                    case 8:
                        if (is_null($expense->getAttribute('goods_type'))) {
                            if ($expense->getAttribute('is_income')) {
                                $data = [
                                    'waiting_income_debts' => $rate->getAttribute('waiting_income_debts') - $expense->getAttribute('expense'),
                                    'pocket' => $rate->getAttribute('pocket') - $expense->getAttribute('expense')
                                ];
                            }else {
                                $data = [
                                    'waiting_debts' => $rate->getAttribute('waiting_debts') - $expense->getAttribute('expense'),
                                    'pocket' => $rate->getAttribute('pocket') + $expense->getAttribute('expense')
                                ];
                            }

                        }else {
                            if (is_null($expense->getAttribute('debt_selling_id'))) {
                                $data['pocket'] = $rate->getAttribute('pocket') - $expense->getAttribute('expense');
                            }else {
                                $data['waiting_income_goods'] = $rate->getAttribute('waiting_income_goods') - $expense->getAttribute('expense');
                            }

                            $data['turnover'] = $rate->getAttribute('turnover') - $expense->getAttribute('expense');
                        }

                        break;
                    default:
                        $data = [
                            'pocket' => $rate->getAttribute('pocket') + $expense->getAttribute('expense'),
                            'expenses' => $rate->getAttribute('expenses') - $expense->getAttribute('expense')
                        ];

                        break;
                }

                $expense->closedRate()->update($data);
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

    public function selling(): BelongsTo
    {
        return $this->belongsTo(Selling::class, 'debt_selling_id')->withDefault();
    }

    public function closedRate(): BelongsTo
    {
        return $this->belongsTo(ClosedRate::class, 'closed_rate_id')->withDefault();
    }
}
