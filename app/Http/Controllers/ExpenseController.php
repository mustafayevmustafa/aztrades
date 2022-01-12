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
use Carbon\Carbon;
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
        $filters = $request->only(['expense_type_id', 'all_except', 'type', 'daterange', 'note', 'customer']);
        $daterange = array_key_exists('daterange', $filters) ? explode(' - ', $filters['daterange']) : [now()->startOfDay(), now()->endOfDay()];

        return view('Admin.expenses.index')->with([
            'expenses' => Expense::with('type', 'goodsType')
                ->where('expense_type_id', '!=', ExpensesType::debt)
                ->when(array_key_exists('expense_type_id', $filters), fn ($q) => $q->where('expense_type_id', $filters['expense_type_id']))
                ->when(array_key_exists('all_except', $filters), fn ($q) => $q->where('expense_type_id', '!=', $filters['all_except']))
                ->when(array_key_exists('type', $filters) && is_numeric($filters['type']), fn ($q) => $q->where('expense_type_id', $filters['type']))
                ->whereBetween('created_at', [Carbon::parse($daterange[0])->startOfDay(), Carbon::parse($daterange[1])->endOfDay()])
                ->when(array_key_exists('note', $filters) && !is_null($filters['note']), fn ($q) => $q->where('note', 'LIKE', "%{$filters['note']}%"))
                ->when(array_key_exists('customer', $filters) && !is_null($filters['customer']), fn ($q) => $q->where('customer', 'LIKE', "%{$filters['customer']}%"))
                ->latest()
                ->latest('expense')
                ->paginate(25),
            'expenseTypes' => ExpensesType::expenseTypes(false,8)
        ]);
    }

    public function create()
    {
        abort_if(\request()->has('type') && is_null(ExpensesType::find(\request()->get('type'))), 404);

        $back = strpos(back()->getTargetUrl(), '?') != false ? substr(back()->getTargetUrl(), 0, strpos(back()->getTargetUrl(), '?')) : back()->getTargetUrl();

        return view('Admin.expenses.edit', [
            'action' => route('expenses.store'),
            'method' => 'POST',
            'data'   => new Expense(),
            'types'  => ExpensesType::expenseTypes(true, 8),
            'back'   => $back
        ]);
    }

    public function store(ExpenseRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_income'] = $request->has('is_income');

        Expense::create($validated);

        return redirect()->to($validated['back'])->with('success', "Expense created successfully!");
    }

    public function show(Expense $expense)
    {
        return view('Admin.expenses.edit', [
            'action' => null,
            'method' => null,
            'data'   => $expense,
            'types'  => ExpensesType::expenseTypes(),
            'selling' => $expense->getRelationValue('selling')
        ]);
    }

    public function destroy(Expense $expense): JsonResponse
    {
        abort_if(   !is_null($expense->getAttribute('goods_type')) && $expense->getAttribute('expense_type_id') != ExpensesType::debt, 503);

        if($expense->delete()){
            $expense->selling()->delete();
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
