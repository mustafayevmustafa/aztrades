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

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Admin.expenses.index')->with([
            'expenses' => Expense::latest()->latest('expense')->get()
        ]);
    }

    public function create()
    {
        return view('Admin.expenses.edit', [
            'action' => route('expenses.store'),
            'method' => null,
            'data'   => new Expense(),
            'types'  => ExpensesType::isNotCost()->get()
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
            'types'  => ExpensesType::isNotCost()->get()
        ]);
    }

    public function edit(Expense $expense)
    {
        return view('Admin.expenses.edit', [
            'action' => route('expenses.update', $expense),
            'method' => "PUT",
            'data'   => $expense,
            'types'  => ExpensesType::isNotCost()->get()
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
