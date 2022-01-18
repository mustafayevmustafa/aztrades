<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ClosedRate extends Model
{
    protected $fillable = ['pocket', 'turnover', 'waiting_debts', 'expenses', 'waiting_income_debts', 'waiting_income_goods'];

    public static function dailyClosedRates()
    {
        return ClosedRate::whereDate('created_at', now())->latest()->get();
    }

    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
}
