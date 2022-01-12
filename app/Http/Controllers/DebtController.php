<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpensesType;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function debtQuery($request, $is_income = false): LengthAwarePaginator
    {
        $filters = $request->only(['daterange', 'note', 'customer']);
        $daterange = array_key_exists('daterange', $filters) ? explode(' - ', $filters['daterange']) : [now()->startOfDay(), now()->endOfDay()];

        return Expense::query()
            ->where('is_income', $is_income)
            ->where('expense_type_id', ExpensesType::debt)
            ->when(array_key_exists('daterange', $filters), fn ($q) => $q->whereBetween('created_at', [Carbon::parse($daterange[0])->startOfDay(), Carbon::parse($daterange[1])->endOfDay()]))
            ->when(array_key_exists('note', $filters) && !empty($filters['note']), fn ($q) => $q->where('note', 'LIKE', "%{$filters['note']}%"))
            ->when(array_key_exists('customer', $filters) && !is_null($filters['customer']), fn ($q) => $q->where('customer', 'LIKE', "%{$filters['customer']}%"))
            ->latest()
            ->latest('expense')
            ->paginate(25);
    }

    public function incomeIndex(Request $request)
    {
        return view('Admin.debts.income.index')->with([
            'expenses' => $this->debtQuery($request, true),
        ]);
    }

    public function expenseIndex(Request $request)
    {
        return view('Admin.debts.expense.index')->with([
            'expenses' => $this->debtQuery($request),
        ]);
    }
}
