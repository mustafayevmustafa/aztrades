<?php

namespace App\Http\Controllers;

use App\Http\Requests\PotatoRequest;
use App\Models\Country;
use App\Models\Expense;
use App\Models\ExpensesType;
use App\Models\Onion;
use App\Models\Potato;
use App\Models\PotatoSac;
use App\Models\Selling;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PotatoController extends Controller
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

        return view('Admin.potatoes.index')->with([
            'potatoes' => Potato::query()
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
        return view('Admin.potatoes.edit', [
            'action' => route('potatoes.store'),
            'method' => 'POST',
            'data'   => new Potato(),
            'countries' => Country::get(),
        ]);
    }

    public function store(PotatoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $potato = new Potato($validated);

        if($request->has('sacs')){
            foreach ($validated['sacs'] ?? [] as $index => $sac) {
                $validated['sacs'][$index]['total_weight'] = $validated['sacs'][$index]['sac_count'] * $validated['sacs'][$index]['sac_weight'];
            }
        }

        $potato->save();
        $potato->sacs()->createMany($validated['sacs'] ?? []);

        foreach ($validated as $key => $value) {
            if (!str_contains($key, 'cost')) continue;

            if(!is_null($value)) {
                Expense::create([
                    'expense_type_id' => ExpensesType::expenseTypes()[$key],
                    'expense' => $value,
                    'goods_type' => Potato::class,
                    'goods_type_id' => $potato->getAttribute('id'),
                ]);
            }
        }

        return redirect()->route('potatoes.index')->with('success', "Potato {$potato->getAttribute('from_whom')} created successfully!");
    }

    public function show(Potato $potato)
    {
        return view('Admin.potatoes.edit', [
            'action' => null,
            'method' => null,
            'data'   => $potato,
            'countries' => Country::get(),
            'bags' => $potato->getRelationValue('sacs')->pluck('name', 'id'),
            'waste' => $potato->waste()->orderByDesc('created_at')->get(),
            'sellings' => $potato->sellings()->orderByDesc('created_at')->get(),
        ]);
    }

    public function edit(Potato $potato)
    {
        return view('Admin.potatoes.edit', [
            'action' => route('potatoes.update', $potato),
            'method' => "PUT",
            'data'   => $potato,
            'countries' => Country::get(),
            'bags' => $potato->getRelationValue('sacs')->pluck('name', 'id'),
            'waste' => $potato->waste()->orderByDesc('created_at')->get(),
            'sellings' => $potato->sellings()->orderByDesc('created_at')->get(),
        ]);
    }

    public function update(PotatoRequest $request, Potato $potato): RedirectResponse
    {
        $validated = $request->validated();

        if (array_key_exists('is_waste', $validated)) {
            if(is_null($validated['waste_weight']) && is_null($validated['waste_sac_count'])) {
                return redirect()->route('potatoes.show', $potato)->with('error', "Atxod elave etmek ucun kise ve ya ceki daxil edilmelidir!");
            }

            $wasteData = $request->only(['waste_sac_count', 'waste_sac_name', 'waste_weight']);
            $wasteData['waste_sac_name'] = optional(PotatoSac::find($wasteData['waste_sac_name']))->getAttribute('name') ?? null;

            $wastableData = [
                'total_weight' => $potato->getAttribute('total_weight') - $wasteData['waste_weight'],
            ];

            if (!is_null($validated['waste_sac_name'])){
                $sac = PotatoSac::find($request->get('waste_sac_name'));
                $sac_count = $sac->sac_count - $wasteData['waste_sac_count'];
                $sac_weight = $wasteData['waste_weight'] > 0 ? $sac->total_weight - $wasteData['waste_weight'] : $sac_count * $sac->sac_weight;

                if($sac_weight < 0) {
                    return redirect()->route('potatoes.show', $potato)->with('error', "Bu kisede secdiyiniz qeder hecm yoxdur!");
                }

                $sac->update([
                    'total_weight' => $sac_weight,
                    'sac_count' => $sac_count,
                ]);
            }

            $potato->waste()->create($wasteData);

            $potato->update($wastableData);

            return redirect()->route('potatoes.show', $potato)->with('success', "Waste added successfully!");
        }

        $validated['status'] = $request->has('status');

        $potato->update($validated);

        // Add, update or delete social networks
        $sacs = collect($request->get('sacs') ?? []);

        // destroy should appear before create or update
        PotatoSac::destroy($potato->sacs()->pluck('id')->diff($sacs->pluck('id')));

        $sacs->each(function($sac, $index) use ($potato){
            $sac['total_weight'] = $sac['sac_count'] * $sac['sac_weight'];

            $potato->sacs()->updateOrCreate(['id' => $sac['id']], $sac);
        });

        foreach ($validated as $key => $value) {
            if (!str_contains($key, 'cost')) continue;

            if(!is_null($value)) {
                Expense::updateOrCreate(
                    [
                        'expense_type_id' => ExpensesType::expenseTypes()[$key],
                        'goods_type' => Potato::class,
                        'goods_type_id' => $potato->getAttribute('id')
                    ],
                    [
                        'expense' => $value,
                    ]
                );
            }
        }

        return redirect()->route('potatoes.index')->with('success', "Potato {$potato->getAttribute('from_whom')} updated successfully!");
    }

    public function destroy(Potato $potato): JsonResponse
    {
        if($potato->delete()){
            $potato->expenses()->delete();
            Selling::where('sellingable_type', Potato::class)->where('sellingable_id', $potato->getAttribute('id'))->delete();
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
