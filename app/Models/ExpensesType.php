<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpensesType extends Model
{
    use SoftDeletes;

    public const COST = 6;

    protected $fillable = ['name', 'key'];

    public function scopeIsNotCost($query)
    {
        return $query->where('key', '!=', 'cost');
    }

}
