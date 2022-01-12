<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellingsRequest;
use App\Models\Expense;
use App\Models\ExpensesType;
use App\Models\Onion;
use App\Models\Potato;
use App\Models\Selling;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SellingController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        abort_if(!Setting::first()->getAttribute('is_active') && !auth()->user()->isAdmin(), 503);

        $filters = $request->only(['type', 'daterange', 'customer']);
        $daterange = array_key_exists('daterange', $filters) ? explode(' - ', $filters['daterange']) : [now()->startOfDay(), now()->endOfDay()];

        return view('Admin.sellings.index')->with([
            'sellings' => Selling::query()
                ->when(array_key_exists('type', $filters) && is_numeric($filters['type']), fn ($q) => $q->where('was_debt', $filters['type']))
                ->whereBetween('created_at', [Carbon::parse($daterange[0])->startOfDay(), Carbon::parse($daterange[1])->endOfDay()])
                ->when(array_key_exists('customer', $filters) && !is_null($filters['customer']), fn ($q) => $q->where('customer', 'LIKE', "%{$filters['customer']}%"))
                ->latest()
                ->paginate(25),
            'types' => Selling::flowType(),
        ]);
    }

    public function create(Request $request)
    {
        abort_if(!Setting::first()->getAttribute('is_active') && !auth()->user()->isAdmin(), 503);

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
                Onion::bags() :
                $type->sacs->pluck('name', 'id'),
        ]);
    }

    public function store(SellingsRequest $request): RedirectResponse
    {
        abort_if(!Setting::first()->getAttribute('is_active') && !auth()->user()->isAdmin(), 503);

        $validated = $request->validated();

        $validated['was_debt'] = $request->has('was_debt');

        // Store sellingable model
        $validated['sellingable_type'] = $request->get('type') === 'onion' ? Onion::class : Potato::class;
        $validated['sellingable_id']   = $validated['type_id'];

        $selling = new Selling($validated); // create a Selling model instance to save later if no errors occur
        $sellingable = $selling->getRelationValue('sellingable'); // sellingable morph of the selling model

        $error = false;

        $validated['weight'] = $validated['weight'] ?? 0;
        $validated['sac_count'] = $validated['sac_count'] ?? 0;

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
                    $sac = $sellingable->sacs()->where('potato_id', $validated['type_id'])->where('id', $validated['sac_name'])->first();

                    if ($sac->getAttribute('sac_count') < $validated['sac_count'] || $sac->getAttribute('total_weight') < $validated['weight']) {
                        $error = true;
                        break;
                    }

                    break;
            }
        }

        if((!is_null($validated['sac_name']) && $validated['sac_count'] <= 0) || (is_null($validated['sac_name']) && $validated['sac_count'] >= 0)) {
            $error = true;
        }

        if(!is_null($validated['sac_name']) && $validated['sac_count'] > 0 && $validated['weight'] > 0) {
            $error = true;
        }

        if ($error) {
            return back()->with('message', 'Seçdiyiniz kisədə o qədər say və ya həcm mövcud deyil, ve ya melumatlar duzgun daxil edilmeyib!');
        }

        if($sellingable->getTable() == 'potatoes' && !is_null($validated['sac_name']) && $validated['sac_count'] > 0) {

            $sac_count = $sac->sac_count - $validated['sac_count'];
            $sac_weight = $validated['weight'] > 0 ? $sac->total_weight - $validated['weight'] : $sac_count * $sac->sac_weight;
            $sac->update([
                'sac_count' => $sac_count,
                'total_weight' => $sac_weight,
            ]);

            if ($validated['weight'] == 0) {
                $sellingableData['total_weight'] = $sellingable->getAttribute('total_weight') - ($validated['sac_count'] * $sac->sac_weight);
            }
        }

        $selling->sellingable()->update($sellingableData);

        $selling->save();

        if($validated['was_debt']) {
            Expense::create([
                'expense_type_id' => ExpensesType::debt,
                'goods_type' => Onion::class,
                'goods_type_id' => $selling->getAttribute('sellingable_id'),
                'expense' => $validated['price'],
                'note' => $validated['content'],
                'customer' => $selling->getAttribute('customer'),
                'debt_selling_id' => $selling->getAttribute('id')
            ]);
        }

        return redirect()->route('sellings.index')->with('success', "Satış uğurlu oldu");
    }

    public function show(Selling $selling)
    {
        abort_if(!Setting::first()->getAttribute('is_active') && !auth()->user()->isAdmin(), 503);

        $sellingable = $selling->getRelationValue('sellingable');

        return view('Admin.sellings.edit', [
            'action' => null,
            'method' => null,
            'data'   => $selling,
            'type' => $sellingable,
            'sacs'   => $sellingable->getTable() == 'onions' ?
                Onion::bags() :
                $sellingable->sacs->pluck('name', 'id'),
        ]);
    }

    public function destroy(Selling $selling): JsonResponse
    {
        abort_if(!Setting::first()->getAttribute('is_active') && !auth()->user()->isAdmin(), 503);

        if($selling->delete()){
            $selling->debt()->delete();
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
