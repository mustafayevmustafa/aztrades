<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Requests\CountryRequest;
use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\ExpensesTypeRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Expense;
use App\Models\ExpensesType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $filters = $request->only(['expense_type_id', 'all_except', 'type', 'daterange']);
        $daterange = array_key_exists('daterange', $filters) ? explode(' - ', $filters['daterange']) : [];

        return view('Admin.expenses.index')->with([
            'expenses' => Expense::query()
                ->when(array_key_exists('expense_type_id', $filters), fn ($q) => $q->where('expense_type_id', $filters['expense_type_id']))
                ->when(array_key_exists('all_except', $filters), fn ($q) => $q->where('expense_type_id', '!=', $filters['all_except']))
                ->when(array_key_exists('type', $filters) && $filters['type'], fn ($q) => $q->where('expense_type_id', $filters['type']))
                ->when(array_key_exists('daterange', $filters), fn ($q) => $q->whereBetween('created_at', [$daterange[0], $daterange[1]]))
                ->latest()
                ->latest('expense')
                ->paginate(25),
            'expenseTypes' => ExpensesType::expenseTypes(false,8)
        ]);
    }

    public function create()
    {
        abort_if(\request()->has('type') && is_null(ExpensesType::find(\request()->get('type'))), 404);

        return view('Admin.expenses.edit', [
            'action' => route('expenses.store'),
            'method' => null,
            'data'   => new Expense(),
            'types'  => ExpensesType::expenseTypes(true, 8)
        ]);
    }

    public function store(ExpenseRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', "Expense created successfully!");
    }

    public function show(Expense $expense)
    {
        return view('Admin.expenses.edit', [
            'action' => null,
            'method' => null,
            'data'   => $expense,
            'types'  => ExpensesType::expenseTypes()
        ]);
    }

    public function edit(Expense $expense)
    {
        return view('Admin.expenses.edit', [
            'action' => route('expenses.update', $expense),
            'method' => "PUT",
            'data'   => $expense,
            'types'  => ExpensesType::expenseTypes()
        ]);
    }

    public function update(ExpenseRequest $request, Expense $expense): RedirectResponse
    {
        $validated = $request->validated();

        $expense->update($validated);

        return redirect()->route('expenses.index')->with('success', "Expense updated successfully!");
    }

    public function destroy(Expense $expense): JsonResponse
    {
        if($expense->delete()){
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
