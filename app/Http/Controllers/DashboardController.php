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
            // goods
            'onions' => Onion::isActive()->latest('updated_at')->get(),
            'potatoes' => Potato::isActive()->latest('updated_at')->get(),
            // total data
            'total_income' => Selling::where('status', false)->get()->sum('price'),
            'total_waiting_income' => Expense::where('is_returned', false)->where('expense_type_id', ExpensesType::debt)->get()->sum('expense'),
            'total_expense' => Expense::where('is_returned', false)->where('expense_type_id', '!=', ExpensesType::debt)->get()->sum('expense'),
            // monthly data
            'monthly_income' => Selling::where('status', false)->whereMonth('created_at', now()->month)->get()->sum('price'),
            'monthly_waiting_income' => Expense::where('is_returned', false)->where('expense_type_id', ExpensesType::debt)->whereMonth('created_at', now()->month)->get()->sum('expense'),
            'monthly_expense' => Expense::where('is_returned', false)->where('expense_type_id', '!=', ExpensesType::debt)->whereMonth('created_at', now()->month)->get()->sum('expense'),
            // daily data
            'daily_net_income' => Setting::getDailyNetIncome(),
            'daily_income' => Selling::where('status', false)->whereDate('created_at', now())->get()->sum('price'),
            'daily_waiting_income' => Expense::where('is_returned', false)->where('expense_type_id', ExpensesType::debt)->whereDate('created_at', now())->get()->sum('expense'),
            'daily_expense' => Expense::where('is_returned', false)->where('expense_type_id', '!=', ExpensesType::debt)->whereDate('created_at', now())->get()->sum('expense'),
        ]);
    }

    public function toggleActive(): RedirectResponse
    {
        $setting = Setting::first();
        $setting->update(['is_active' => !$setting->getAttribute('is_active')]);

        if (!$setting->getAttribute('is_active') && Setting::getDailyNetIncome() != 0) {
            ClosedRate::create(['value' => Setting::getDailyNetIncome()]);
        }

        return back();
    }
}
