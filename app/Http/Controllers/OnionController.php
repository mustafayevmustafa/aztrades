<?php

namespace App\Http\Controllers;

use App\Http\Requests\OnionRequest;
use App\Models\City;
use App\Models\Expense;
use App\Models\ExpensesType;
use App\Models\Onion;
use App\Models\Selling;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OnionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $is_trash = $request->get('is_trash', 0);

        $types = ['Aktiv mallar', 'Atxod mallar'];

        return view('Admin.onions.index')->with([
            'onions' => Onion::query()
                ->when($is_trash == 0, fn($q) => $q->where('is_trash', 0))
                ->when($is_trash == 1, fn($q) => $q->where('is_trash', 1))
                ->latest()
                ->paginate(25),
            'is_trash' => $is_trash,
            'types' => $types
        ]);
    }

    public function create()
    {
        return view('Admin.onions.edit', [
            'action' => route('onions.store'),
            'method' => "POST",
            'data'   => new Onion(),
            'cities' => City::get(),
            'old_values' => [0, 0, 0]

        ]);
    }

    public function store(OnionRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $onion = Onion::create($validated);

        foreach ($validated as $key => $value) {
            if (!str_contains($key, 'cost')) continue;

            if(!is_null($value)) {
                Expense::create([
                    'expense_type_id' => ExpensesType::expenseTypes()[$key],
                    'expense' => $value,
                    'goods_type' => Onion::class,
                    'goods_type_id' => $onion->getAttribute('id'),
                ]);
            }
        }

        return redirect()->route('onions.index')->with('success', "Onion {$onion->getAttribute('from_whom')} Created successfully!");
    }

    public function show(Onion $onion)
    {
        return view('Admin.onions.edit', [
            'action' => null,
            'method' => null,
            'data'   => $onion,
            'cities' => City::get(),
            'old_values' => explode(',', $onion->getAttribute('old_bag_numbers'))
        ]);
    }

    public function edit(Onion $onion)
    {
        return view('Admin.onions.edit', [
            'action' => route('onions.update', $onion),
            'method' => "PUT",
            'data'   => $onion,
            'cities' => City::get(),
            'old_values' => explode(',', $onion->getAttribute('old_bag_numbers'))
        ]);
    }

    public function update(OnionRequest $request, Onion $onion): RedirectResponse
    {
        $validated = $request->validated();

        $validated['is_trash'] = $request->has('is_trash');

        $onion->update($validated);

        foreach ($validated as $key => $value) {
            if (!str_contains($key, 'cost')) continue;

            if(!is_null($value)) {
                Expense::updateOrCreate(
                    [
                        'expense_type_id' => ExpensesType::expenseTypes()[$key],
                        'goods_type' => Onion::class,
                        'goods_type_id' => $onion->getAttribute('id')
                    ],
                    [
                        'expense' => $value,
                    ]
                );
            }
        }

        return redirect()->route('onions.index')->with('success', "Onion {$onion->getAttribute('from_whom')} updated successfully!");
    }

    public function destroy(Onion $onion): JsonResponse
    {
        if($onion->delete()){
            $onion->expenses()->delete();
            Selling::where('sellingable_type', Onion::class)->where('sellingable_id', $onion->getAttribute('id'))->delete();
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
