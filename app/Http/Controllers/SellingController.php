<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellingsRequest;
use App\Models\Onion;
use App\Models\Potato;
use App\Models\Selling;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SellingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Admin.sellings.index')->with([
            'sellings' => Selling::latest()->get()
        ]);
    }

    public function create(Request $request)
    {
        $type = $request->get('type') == 'onion' ?
            Onion::findOrFail($request->get('type_id')) :
            Potato::findOrFail($request->get('type_id'));

        return view('Admin.sellings.edit', [
            'action' => route('sellings.store'),
            'method' => null,
            'data'   => null,
            'type'   => $type
        ]);
    }

    public function store(SellingsRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['status'] = $request->has('status');

        $selling = Selling::create($validated);

        return redirect()->route('sellings.index')->with('success', "Satış  uğurlu oldu");
    }

    public function show(Selling $selling)
    {
        $selling->load('type');

        return view('Admin.sellings.edit', [
            'action' => null,
            'method' => null,
            'data'   => $selling,
            'type' => $selling->getRelationValue('type'),
        ]);
    }

    public function edit(Selling $selling)
    {
        $selling->load('type');

        return view('Admin.sellings.edit', [
            'action' => route('sellings.update', $selling),
            'method' => "PUT",
            'data'   => $selling,
            'type' => $selling->getRelationValue('type'),
        ]);
    }

    public function update(SellingsRequest $request, Selling $selling): RedirectResponse
    {
        $validated = $request->validated();

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
