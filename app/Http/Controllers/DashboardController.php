<?php

namespace App\Http\Controllers;

use App\Models\ClosedRate;
use App\Models\Expense;
use App\Models\ExpensesType;
use App\Models\Onion;
use App\Models\Potato;
use App\Models\Selling;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Admin.index')->with([
            // closed rates
            'closed_rates' => ClosedRate::dailyClosedRates(),
            // goods
            'onions' => Onion::isActive()->latest('updated_at')->get(),
            'potatoes' => Potato::isActive()->latest('updated_at')->get(),
            // total data
            'total_income' => Selling::get()->sum('price'),
            'total_expense' => Expense::where('is_returned', false)->where('expense_type_id', '!=', ExpensesType::debt)->get()->sum('expense'),
            // monthly data
            'monthly_income' => Selling::whereMonth('created_at', now()->month)->get()->sum('price'),
            'monthly_expense' => Expense::where('is_returned', false)->where('expense_type_id', '!=', ExpensesType::debt)->whereMonth('created_at', now()->month)->get()->sum('expense'),
            // daily data
            'daily_net_income' => Setting::dailyNetIncome(),
            'daily_income' => Setting::dailyTurnover(),
            'daily_waiting_income' => Setting::dailyWaitingDebts(),
            'daily_waiting_income_debt' => Setting::dailyWaitingDebts(),
            'daily_expense' => Setting::dailyExpenses(),
        ]);
    }

    public function toggleActive(): RedirectResponse
    {
        $setting = Setting::first();
        $setting->update(['is_active' => !$setting->getAttribute('is_active')]);

        if (!$setting->getAttribute('is_active') && Setting::dailyNetIncome() != 0) {
            ClosedRate::create([
                'pocket' => Setting::dailyNetIncome(),
                'turnover' => Setting::dailyTurnover(),
                'waiting_debts' => Setting::dailyWaitingDebts(),
                'waiting_income_debts' => Setting::dailyWaitingIncomeDebts(),
                'expenses' => Setting::dailyExpenses(),
            ]);
        }

        return back();
    }
}
