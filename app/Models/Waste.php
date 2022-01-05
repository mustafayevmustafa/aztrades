<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Waste extends Model implements Recordable
{
    use SoftDeletes, \Altek\Accountant\Recordable;

    protected $table = 'waste';

    protected $fillable = ['waste_weight', 'waste_sac_name', 'waste_sac_count'];

    public function wastable(): MorphTo
    {
        return $this->morphTo('wastable');
    }

    public function getTypeAttribute(): string
    {
        return $this->getRelationValue('wastable')->getTable() == 'onions' ? 'Soğan' : 'Kartof';
    }
}
