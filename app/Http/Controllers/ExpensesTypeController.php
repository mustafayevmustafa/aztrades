<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpensesTypeRequest;
use App\Models\ExpensesType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ExpensesTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function index()
    {
        return view('Admin.expenses_types.index')->with([
            'expenses_types' => ExpensesType::paginate(10)
        ]);
    }

    public function create()
    {
        abort(503);

//        return view('Admin.expenses_types.edit', [
//            'action' => route('expenses_types.store'),
//            'method' => null,
//            'data'   => new ExpensesType()
//        ]);
    }

    public function store(ExpensesTypeRequest $request): RedirectResponse
    {
        abort(503);

//        $validated = $request->validated();
//
//        $expenses_type = ExpensesType::create($validated);
//
//        return redirect()->route('expenses_types.index')->with('success', "Expense type {$expenses_type ->getAttribute('name')} created successfully!");
    }

    public function show(ExpensesType $expensesType)
    {
        return view('Admin.expenses_types.edit', [
            'action' => null,
            'method' => null,
            'data'   => $expensesType
        ]);
    }

    public function edit(ExpensesType $expensesType)
    {
        abort(503);

//        return view('Admin.expenses_types.edit', [
//            'action' => route('expenses_types.update', $expensesType),
//            'method' => "PUT",
//            'data'   => $expensesType
//        ]);
    }

    public function update(ExpensesTypeRequest $request, ExpensesType $expensesType): RedirectResponse
    {
        abort(503);

//        $validated = $request->validated();
//
//        $expensesType->update($validated);
//
//        return redirect()->route('expenses_types.index')->with('success', "Expense type {$expensesType->getAttribute('name')} updated successfully!");
    }

    public function destroy(ExpensesType $expensesType): JsonResponse
    {
        abort(503);
//        if($expensesType->delete()){
//            return response()->json(['code' => 200]);
//        }else{
//            return response()->json(['code' => 400]);
//        }
    }
}
