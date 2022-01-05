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
        $filters = $request->only(['expense_type_id', 'all_except', 'type', 'daterange', 'note']);
        $daterange = array_key_exists('daterange', $filters) ? explode(' - ', $filters['daterange']) : [];

        return view('Admin.expenses.index')->with([
            'expenses' => Expense::query()
                ->where('expense_type_id', '!=', ExpensesType::debt)
                ->when(array_key_exists('expense_type_id', $filters), fn ($q) => $q->where('expense_type_id', $filters['expense_type_id']))
                ->when(array_key_exists('all_except', $filters), fn ($q) => $q->where('expense_type_id', '!=', $filters['all_except']))
                ->when(array_key_exists('type', $filters) && $filters['type'], fn ($q) => $q->where('expense_type_id', $filters['type']))
                ->when(array_key_exists('daterange', $filters), fn ($q) => $q->whereBetween('created_at', [$daterange[0], $daterange[1]]))
                ->when(array_key_exists('note', $filters), fn ($q) => $q->where('note', 'LIKE', "%{$filters['note']}%"))
                ->latest()
                ->latest('expense')
                ->paginate(25),
            'expenseTypes' => ExpensesType::expenseTypes(false,8)
        ]);
    }

    public function create()
    {
        abort_if(\request()->has('type') && is_null(ExpensesType::find(\request()->get('type'))), 404);

        $back = back()->getTargetUrl();

        return view('Admin.expenses.edit', [
            'action' => route('expenses.store'),
            'method' => null,
            'data'   => new Expense(),
            'types'  => ExpensesType::expenseTypes(true, 8),
            'back'   => $back
        ]);
    }

    public function store(ExpenseRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Expense::create($validated);

        return redirect()->to($validated['back'])->with('success', "Expense created successfully!");
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
        $back = back()->getTargetUrl();

        return view('Admin.expenses.edit', [
            'action' => route('expenses.update', $expense),
            'method' => "PUT",
            'data'   => $expense,
            'types'  => ExpensesType::expenseTypes(),
            'back'   => $back
        ]);
    }

    public function update(ExpenseRequest $request, Expense $expense): RedirectResponse
    {
        $validated = $request->validated();

        $expense->update($validated);

        return redirect()->to($validated['back'])->with('success', "Expense updated successfully!");
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
