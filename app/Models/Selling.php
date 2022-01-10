<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Selling extends Model implements Recordable
{
    use SoftDeletes, \Altek\Accountant\Recordable;

    protected $fillable = [
        'customer',
        'content',
        'was_debt',
        'weight',
        'price',
        'sac_count',
        'sac_name',
        'type',
        'sellingable_type',
        'sellingable_id',
        'closed_rate_id'
    ];

    protected $casts = [
        'was_debt' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        self::deleted(function (Selling $selling){
            // Revert the sold goods
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

                // Revert the closed rate
                if ($selling->closedRate()->exists()) {
                    $rate = $selling->getRelationValue('closedRate');

                    $data = [];
                    switch ($selling->getAttribute('was_debt')) {
                        case 0:
                            $data['pocket'] = $rate->getAttribute('pocket') - $selling->getAttribute('price');
                            break;
                        case 1:
                            $data['waiting_income_goods'] = $rate->getAttribute('waiting_income_goods') - $selling->getAttribute('price');
                            break;
                    }

                    $data['turnover'] = $rate->getAttribute('turnover') - $selling->getAttribute('price');
                    $selling->closedRate()->update($data);
                }
            }
        });
    }

    public static function flowType(): array
    {
        return ['Nəgd', 'Borc'];
    }

    public function sellingable(): MorphTo
    {
        return $this->morphTo();
    }

    public function debt(): HasOne
    {
        return $this->hasOne(Expense::class, 'debt_selling_id')->withDefault();
    }

    public function closedRate(): BelongsTo
    {
        return $this->belongsTo(ClosedRate::class, 'closed_rate_id')->withDefault();
    }
}
