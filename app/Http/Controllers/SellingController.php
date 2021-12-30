<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellingsRequest;
use App\Models\Onion;
use App\Models\Potato;
use App\Models\Selling;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SellingController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');

        abort_if(!Setting::first()->getAttribute('is_active'), 503);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'was_debt']);

        return view('Admin.sellings.index')->with([
            'sellings' => Selling::query()
                ->when(array_key_exists('status', $filters) &&
                    array_key_exists('was_debt', $filters) &&
                    $filters['status'] == 0 && $filters['was_debt'] == 1 ,
                    fn ($q) => $q->where('status', $filters['status'])->where('was_debt', $filters['was_debt'])
                )
                ->when(array_key_exists('status', $filters) &&
                    $filters['status'] == 1,
                    fn ($q) => $q->where('status', $filters['status'])
                )
                ->latest()
                ->get()
        ]);
    }

    public function create(Request $request)
    {
        abort_if($request->get('type') !== 'onion' && $request->get('type') !== 'potato', 404);

        $type = $request->get('type') == 'onion' ?
            Onion::findOrFail($request->get('type_id')) :
            Potato::findOrFail($request->get('type_id')) ;

        return view('Admin.sellings.edit', [
            'action' => route('sellings.store'),
            'method' => 'POST',
            'data'   => new Selling(),
            'type'   => $type,
            'sacs'   => $type->getTable() == 'onions' ?
                ['yellow_bag_number' => 'Sarı Kisə', 'red_bag_number' => 'Qırmızı Kisə', 'lom_bag_number' => 'Lom Kisə'] :
                $type->sacs->pluck('name'),
        ]);
    }

    public function store(SellingsRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['status'] = $request->has('status');
        $validated['was_debt'] = $validated['status'];

        // Store sellingable model
        $validated['sellingable_type'] = $request->get('type') === 'onion' ? Onion::class : Potato::class;
        $validated['sellingable_id']   = $validated['type_id'];

        $selling = new Selling($validated); // create a Selling model instance to save later if no errors occur
        $sellingable = $selling->getRelationValue('sellingable'); // sellingable morph of the selling model

        $error = false;

        $validated['weight'] = $validated['weight'] ?? 0;

        $sellingableData['total_weight'] = $sellingable->getAttribute('total_weight') - $validated['weight'];

        if(!is_null($validated['sac_name']) && $validated['sac_count'] > 0) {
            switch ($sellingable->getTable()) {
                case 'onions':
                    if ($sellingable->getAttribute($validated['sac_name']) < $validated['sac_count']) {
                        $error = true;
                        break;
                    }

                    $sellingableData[$validated['sac_name']] = $sellingable->getAttribute($validated['sac_name']) - $validated['sac_count'];
                    break;

                case 'potatoes':
                    $sac = $sellingable->sacs()->where('potato_id', $validated['type_id'])->where('name', $validated['sac_name'])->first();

                    if ($sac->getAttribute('sac_count') < $validated['sac_count'] || $sac->getAttribute('total_weight') < $validated['weight']) {
                        $error = true;
                        break;
                    }

                    if ($sellingable->sacs->sum('total_weight') < $validated['weight']) {
                        $error = true;
                        break;
                    }

                    break;
            }
        }

        if ($error) {
            return back()->with('message', 'Seçdiyiniz kisədə o qədər say və ya həcm mövcud deyil');
        }

        $selling->sellingable()->update($sellingableData);

        if($sellingable->getTable() == 'potatoes') {
            $sac_count = $sac->sac_count - $validated['sac_count'];
            $sac->update([
                'sac_count' => $sac_count,
                'total_weight' => $validated['weight'] > 0 ? $sac->total_weight - $validated['weight'] : $sac_count * $sac->sac_weight,
            ]);
        }
        $selling->save();

        return redirect()->route('sellings.index')->with('success', "Satış uğurlu oldu");
    }

    public function show(Selling $selling)
    {
        $sellingable = $selling->getRelationValue('sellingable');

        return view('Admin.sellings.edit', [
            'action' => null,
            'method' => null,
            'data'   => $selling,
            'type' => $sellingable,
            'sacs'   => $sellingable->getTable() == 'onions' ?
                ['yellow_bag_number' => 'Sarı Kisə', 'red_bag_number' => 'Qırmızı Kisə', 'lom_bag_number' => 'Lom Kisə'] :
                $sellingable->sacs->pluck('name'),
        ]);
    }

    public function edit(Selling $selling)
    {
        $sellingable = $selling->getRelationValue('sellingable');

        return view('Admin.sellings.edit', [
            'action' => route('sellings.update', $selling),
            'method' => "PUT",
            'data'   => $selling,
            'type' => $selling->getRelationValue('sellingable'),
            'sacs'   => $sellingable->getTable() == 'onions' ?
                ['yellow_bag_number' => 'Sarı Kisə', 'red_bag_number' => 'Qırmızı Kisə', 'lom_bag_number' => 'Lom Kisə'] :
                $sellingable->sacs->pluck('name'),
        ]);
    }

    public function update(SellingsRequest $request, Selling $selling): RedirectResponse
    {
        $validated = $request->validated();
        $validated['status'] = $request->has('status');

        if(is_null($validated['sac_name'])) $validated['sac_count'] = null;

        $sellingable = $selling->getRelationValue('sellingable'); // sellingable morph of the selling model

        $error = false;

        $weight_change = $validated['weight'] - $selling->getAttribute('weight');
        $sellingableData['total_weight'] = $sellingable->getAttribute('total_weight') - $weight_change;

        if($selling->getAttribute('sac_name') != $validated['sac_name'] && $validated['sac_count'] > 0) {
            switch ($sellingable->getTable()) {
                case 'onions':
                    if ($sellingable->getAttribute($validated['sac_name']) < $validated['sac_count']) {
                        $error = true;
                        break;
                    }

                    $sac_count_change = $validated['sac_count'] - $selling->getAttribute('sac_count');
                    $sellingableData[$validated['sac_name']] = $sellingable->getAttribute($validated['sac_name']) - $sac_count_change;
                    break;

                case 'potatoes':
                    $sac = $sellingable->sacs()->where('potato_id', $validated['type_id'])->where('name', $validated['sac_name'])->first();

                    if ($sac->getAttribute('sac_count') < $validated['sac_count']) {
                        $error = true;
                        break;
                    }

                    $potato_sac_weight_change = $validated['weight'] - $selling->getAttribute('weight');
                    $potato_sac_count_change  = $validated['sac_count'] - $selling->getAttribute('sac_count');

                    $sac->update([
                        'sac_count' => $sac->sac_count - $potato_sac_count_change,
                        'sac_weight' => $sac->sac_weight - $potato_sac_weight_change,
                    ]);
                    break;
            }
        }

        if ($error) {
            return back()->with('message', 'Seçdiyiniz kisədə o qədər say mövcud deyil');
        }

        $selling->sellingable()->update($sellingableData);
        $selling->update($validated);

        return redirect()->route('sellings.index')->with('success', "Satış  uğurla dəyişdirildi!");
    }

    public function destroy(Selling $selling): JsonResponse
    {
        if($selling->delete()){
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
