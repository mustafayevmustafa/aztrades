<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpensesType;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function __invoke(Request $request)
    {
        $filters = $request->only(['daterange', 'note', 'is_returned']);
        $daterange = array_key_exists('daterange', $filters) ? explode(' - ', $filters['daterange']) : [];

        return view('Admin.debts.index')->with([
            'expenses' => Expense::query()
                ->where('expense_type_id', ExpensesType::debt)
                ->when(array_key_exists('daterange', $filters), fn ($q) => $q->whereBetween('created_at', [$daterange[0], $daterange[1]]))
                ->when(array_key_exists('note', $filters), fn ($q) => $q->where('note', 'LIKE', "%{$filters['note']}%"))
                ->when(array_key_exists('is_returned', $filters), fn ($q) => $q->where('is_returned', $filters['is_returned']))
                ->latest()
                ->latest('expense')
                ->paginate(25),
            'types' => ['Borcda', 'Borcdan gelen']
        ]);
    }


}
