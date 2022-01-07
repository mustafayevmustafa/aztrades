<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClosedRate extends Model
{
    protected $fillable = ['value'];

    public static function dailyClosedRatesSum()
    {
        return ClosedRate::whereDate('created_at', now())->get()->sum('value');
    }

    public static function dailyClosedRates()
    {
        return ClosedRate::whereDate('created_at', now())->get();
    }
}
