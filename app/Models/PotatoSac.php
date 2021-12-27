<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Reliese\Coders\Model\Relations\BelongsTo;

class PotatoSac extends Model
{
    use HasFactory;

    public function potato(): BelongsTo
    {
        return $this->belongsTo(Potato::class);
    }
}
