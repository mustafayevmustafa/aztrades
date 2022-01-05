<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Onion;
use App\Models\Potato;
use App\Models\Selling;

class DashboardController extends Controller
{
    public function index()
    {
        $total_net_income = Selling::where('status', false)->get()->sum('price') - Expense::get()->sum('expense');
        $monthly_net_income = Selling::where('status', false)->whereMonth('created_at', now()->month)->get()->sum('price') - Expense::whereMonth('created_at', now()->month)->get()->sum('expense');
        $daily_net_income = Selling::where('status', false)->whereDate('created_at', now())->get()->sum('price') - Expense::whereDate('created_at', now())->get()->sum('expense');

        return view('Admin.index')->with([
            // goods
            'onions' => Onion::isActive()->latest('updated_at')->get(),
            'potatoes' => Potato::isActive()->latest('updated_at')->get(),
            // total data
            'total_net_income' => $total_net_income,
            'total_income' => Selling::where('status', false)->get()->sum('price'),
            'total_waiting_income' => Selling::where('status', true)->get()->sum('price'),
            'total_expense' => Expense::get()->sum('expense'),
            // monthly data
            'monthly_net_income' => $monthly_net_income,
            'monthly_income' => Selling::where('status', false)->whereMonth('created_at', now()->month)->get()->sum('price'),
            'monthly_waiting_income' => Selling::where('status', true)->whereMonth('created_at', now()->month)->get()->sum('price'),
            'monthly_expense' => Expense::whereMonth('created_at', now()->month)->get()->sum('expense'),
            // daily data
            'daily_net_income' => $daily_net_income,
            'daily_income' => Selling::where('status', false)->whereDate('created_at', now())->get()->sum('price'),
            'daily_waiting_income' => Selling::where('status', true)->whereDate('created_at', now())->get()->sum('price'),
            'daily_expense' => Expense::whereDate('created_at', now())->get()->sum('expense'),
        ]);
    }
}
