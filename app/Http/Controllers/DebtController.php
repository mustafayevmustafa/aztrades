<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpensesType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function __invoke(Request $request)
    {
        $filters = $request->only(['daterange', 'note', 'is_returned', 'customer']);
        $daterange = array_key_exists('daterange', $filters) ? explode(' - ', $filters['daterange']) : [];

        return view('Admin.debts.index')->with([
            'expenses' => Expense::query()
                ->where('expense_type_id', ExpensesType::debt)
                ->when(array_key_exists('daterange', $filters), fn ($q) => $q->whereBetween('created_at', [Carbon::parse($daterange[0])->startOfDay(), Carbon::parse($daterange[1])->endOfDay()]))
                ->when(array_key_exists('note', $filters) && !empty($filters['note']), fn ($q) => $q->where('note', 'LIKE', "%{$filters['note']}%"))
                ->when(array_key_exists('customer', $filters) && !is_null($filters['customer']), fn ($q) => $q->where('customer', 'LIKE', "%{$filters['customer']}%"))
                ->when(array_key_exists('is_returned', $filters) && !is_null($filters['is_returned']), fn ($q) => $q->where('is_returned', $filters['is_returned']))
                ->latest()
                ->latest('expense')
                ->paginate(25),
            'types' => ['Borca geden', 'Borcdan gelen']
        ]);
    }


}
