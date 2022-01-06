<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpensesType;
use App\Models\Onion;
use App\Models\Potato;
use App\Models\Selling;

class DashboardController extends Controller
{
    public function index()
    {
        $total_net_income = Selling::where('status', false)->get()->sum('price') -
            Expense::where('is_returned', false)->where(function ($q){
                $q->where(fn($q) => $q->whereNotNull('goods_type')->where('expense_type_id', '!=', ExpensesType::debt))
                    ->orWhereNull('goods_type');
            })->get()->sum('expense');

        $monthly_net_income = Selling::where('status', false)->whereMonth('created_at', now()->month)->get()->sum('price') -
            Expense::where('is_returned', false)->where(function ($q){
                $q->where(fn($q) => $q->whereNotNull('goods_type')->where('expense_type_id', '!=', ExpensesType::debt))
                    ->orWhereNull('goods_type');
            })->whereMonth('created_at', now()->month)->get()->sum('expense');

        $daily_net_income = Selling::where('status', false)->whereDate('created_at', now())->get()->sum('price') -
            Expense::where('is_returned', false)->where(function ($q){
                $q->where(fn($q) => $q->whereNotNull('goods_type')->where('expense_type_id', '!=', ExpensesType::debt))
                    ->orWhereNull('goods_type');
            })->whereDate('created_at', now())->get()->sum('expense');

        return view('Admin.index')->with([
            // goods
            'onions' => Onion::isActive()->latest('updated_at')->get(),
            'potatoes' => Potato::isActive()->latest('updated_at')->get(),
            // total data
            'total_net_income' => $total_net_income,
            'total_income' => Selling::where('status', false)->get()->sum('price'),
            'total_waiting_income' => Expense::where('is_returned', false)->where('expense_type_id', ExpensesType::debt)->get()->sum('expense'),
            'total_expense' => Expense::where('is_returned', false)->where('expense_type_id', '!=', ExpensesType::debt)->get()->sum('expense'),
            // monthly data
            'monthly_net_income' => $monthly_net_income,
            'monthly_income' => Selling::where('status', false)->whereMonth('created_at', now()->month)->get()->sum('price'),
            'monthly_waiting_income' => Expense::where('is_returned', false)->where('expense_type_id', ExpensesType::debt)->whereMonth('created_at', now()->month)->get()->sum('expense'),
            'monthly_expense' => Expense::where('is_returned', false)->where('expense_type_id', '!=', ExpensesType::debt)->whereMonth('created_at', now()->month)->get()->sum('expense'),
            // daily data
            'daily_net_income' => $daily_net_income,
            'daily_income' => Selling::where('status', false)->whereDate('created_at', now())->get()->sum('price'),
            'daily_waiting_income' => Expense::where('is_returned', false)->where('expense_type_id', ExpensesType::debt)->whereDate('created_at', now())->get()->sum('expense'),
            'daily_expense' => Expense::where('is_returned', false)->where('expense_type_id', '!=', ExpensesType::debt)->whereDate('created_at', now())->get()->sum('expense'),
        ]);
    }
}
