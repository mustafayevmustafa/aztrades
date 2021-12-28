<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Selling extends Model
{
    protected $fillable = [
        'from_sell',
        'type',
        'type_id',
        'content',
        'status',
        'weight',
        'price',
        'sac_count',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function type(): BelongsTo
    {
        $type = $this->getAttribute('type') == 'onion' ? Onion::class : Potato::class;

        return $this->belongsTo($type, 'type_id')->withDefault();
    }


}
