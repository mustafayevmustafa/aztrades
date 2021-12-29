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
        return view('Admin.index')->with([
            'onions' => Onion::notTrash()->hasWeight()->limit(5)->get(),
            'potatoes' => Potato::notTrash()->hasWeight()->limit(5)->get(),
            'net_income' => Selling::where('status', false)->get()->sum('price'),
            'waiting_income' => Selling::where('status', true)->get()->sum('price'),
            'expense' => Expense::get()->sum('expense'),
            'monthly_net_income' => Selling::where('status', false)->whereMonth('created_at', now()->month)->get()->sum('price'),
            'monthly_waiting_income' => Selling::where('status', true)->whereMonth('created_at', now()->month)->get()->sum('price'),
            'monthly_expense' => Expense::whereMonth('created_at', now()->month)->get()->sum('expense'),
            'daily_net_income' => Selling::where('status', false)->whereDate('created_at', now())->get()->sum('price'),
            'daily_waiting_income' => Selling::where('status', true)->whereDate('created_at', now())->get()->sum('price'),
            'daily_expense' => Expense::whereDate('created_at', now())->get()->sum('expense'),
        ]);
    }
}
