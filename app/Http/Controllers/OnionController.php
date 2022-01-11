<?php

namespace App\Http\Controllers;

use App\Http\Requests\OnionRequest;
use App\Models\City;
use App\Models\Expense;
use App\Models\ExpensesType;
use App\Models\Onion;
use App\Models\Selling;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OnionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('can:admin')->except('update');
    }

    public function index(Request $request)
    {
        $status = $request->get('status', 1);

        $types = ['Deaktiv mallar', 'Aktiv mallar'];

        return view('Admin.onions.index')->with([
            'onions' => Onion::query()
                ->when($status == 0, fn($q) => $q->where('status', 0))
                ->when($status == 1, fn($q) => $q->where('status', 1))
                ->latest()
                ->paginate(25),
            'status' => $status,
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
            'old_values' => explode(',', $onion->getAttribute('old_bag_numbers')),
            'bags' => Onion::bags(),
            'waste' => $onion->waste()->orderByDesc('created_at')->get(),
            'sellings' => $onion->sellings()->orderByDesc('created_at')->get(),
        ]);
    }

    public function edit(Onion $onion)
    {
        return view('Admin.onions.edit', [
            'action' => route('onions.update', $onion),
            'method' => "PUT",
            'data'   => $onion,
            'cities' => City::get(),
            'old_values' => explode(',', $onion->getAttribute('old_bag_numbers')),
            'bags' => Onion::bags(),
            'waste' => $onion->waste()->orderByDesc('created_at')->get(),
            'sellings' => $onion->sellings()->orderByDesc('created_at')->get()
        ]);
    }

    public function update(OnionRequest $request, Onion $onion): RedirectResponse
    {
        $validated = $request->validated();

        if (array_key_exists('is_waste', $validated)) {
            if(is_null($validated['waste_weight']) && is_null($validated['waste_sac_count'])) {
                return redirect()->route('onions.show', $onion)->with('error', "Atxod elave etmek ucun kise ve ya ceki daxil edilmelidir!");
            }

            $wasteData = $request->only(['waste_sac_count', 'waste_sac_name', 'waste_weight']);
            $wasteData['waste_sac_name'] = $wasteData['waste_sac_name'] ?? null;

            $onion->waste()->create($wasteData);

            $wastableData = [
                'total_weight' => $onion->getAttribute('total_weight') - $wasteData['waste_weight'],
            ];

            if($request->get('waste_sac_name')) {
                $wastableData[$request->get('waste_sac_name')] = $onion->getAttribute($request->get('waste_sac_name')) - $wasteData['waste_sac_count'];
            }

            $onion->update($wastableData);

            return redirect()->route('onions.show', $onion)->with('success', "Waste added successfully!");
        }

        $validated['status'] = $request->has('status');

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
            $onion->waste()->delete();
            Selling::where('sellingable_type', Onion::class)->where('sellingable_id', $onion->getAttribute('id'))->delete();
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
