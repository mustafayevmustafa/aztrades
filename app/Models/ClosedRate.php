<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClosedRate extends Model
{
    protected $fillable = ['pocket', 'turnover', 'waiting_debts', 'expenses'];

    public static function dailyClosedRates()
    {
        return ClosedRate::whereDate('created_at', now())->get();
    }
}
