<?php

namespace App\Http\Controllers;

use App\Http\Requests\PotatoRequest;
use App\Models\Country;
use App\Models\Expense;
use App\Models\ExpensesType;
use App\Models\Onion;
use App\Models\Potato;
use App\Models\PotatoSac;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PotatoController extends Controller
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

        return view('Admin.potatoes.index')->with([
            'potatoes' => Potato::query()
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
        return view('Admin.potatoes.edit', [
            'action' => route('potatoes.store'),
            'method' => null,
            'data'   => new Potato(),
            'countries' => Country::get(),
        ]);
    }

    public function store(PotatoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $potato = new Potato($validated);

        $total = 0;
        if($request->has('sacs')){
            foreach ($validated['sacs'] ?? [] as $index => $sac) {
                $validated['sacs'][$index]['name'] .= " (#{$index})";
                $validated['sacs'][$index]['total_weight'] = $validated['sacs'][$index]['sac_count'] * $validated['sacs'][$index]['sac_weight'];
                $total += $validated['sacs'][$index]['total_weight'];
            }
        }

        if($total == 0) {
            $potato->save();
        } elseif($total <= $potato->getAttribute('total_weight')) {
            $potato->save();
            $potato->sacs()->createMany($validated['sacs']);
        }else {
            return back()->with('message', 'Daxil etdiyiniz kisə həcmi qədər həcm mövcud deyil');
        }

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

        ]);
    }

    public function edit(Potato $potato)
    {
        return view('Admin.potatoes.edit', [
            'action' => route('potatoes.update', $potato),
            'method' => "PUT",
            'data'   => $potato,
            'countries' => Country::get(),
        ]);
    }

    public function update(PotatoRequest $request, Potato $potato): RedirectResponse
    {
        $validated = $request->validated();

        $validated['state'] = $request->has('state');

        $potato->update($validated);

        // Add, update or delete social networks
        $sacs = collect($request->get('sacs') ?? []);

        // destroy should appear before create or update
        PotatoSac::destroy($potato->sacs()->pluck('id')->diff($sacs->pluck('id')));

        $sacs->each(function($sac, $index) use ($potato){
            $sac['total_weight'] = $sac['sac_count'] * $sac['sac_weight'];
            $sac['name'] = strpos($sac['name'], "#") > 0 ? substr($sac['name'], 0, strpos($sac['name'], "#") - 1) . " (#{$index})" : $sac['name'] . " (#{$index})";

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
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
