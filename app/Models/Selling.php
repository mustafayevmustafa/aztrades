<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Illuminate\Database\Eloquent\Model;
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
    ];

    protected $casts = [
        'was_debt' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        self::deleted(function (Selling $selling){
            $selling->debt()->delete();

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
}
