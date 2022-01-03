<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Altek\Eventually\Eventually;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PotatoSac extends Model
{
    use SoftDeletes;

    protected $touches = ['potato'];

    protected $fillable = ['name', 'sac_count', 'old_sac_count', 'sac_weight', 'total_weight'];

    protected static function boot()
    {
        parent::boot();

        self::creating(function (PotatoSac $potatoSac){
            $potatoSac->setAttribute('old_sac_count', $potatoSac->getAttribute('sac_count'));
        });

        self::updating(function (PotatoSac $potatoSac){
            if (!\request()->has('is_waste')) {
                $potatoSac->setAttribute('old_sac_count', $potatoSac->getAttribute('sac_count'));
            }
        });
    }

    public function potato(): BelongsTo
    {
        return $this->belongsTo(Potato::class)->withDefault();
    }
}
