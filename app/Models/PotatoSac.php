<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PotatoSac extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'sac_count', 'sac_weight'];

    public function potato(): BelongsTo
    {
        return $this->belongsTo(Potato::class)->withDefault();
    }
}
