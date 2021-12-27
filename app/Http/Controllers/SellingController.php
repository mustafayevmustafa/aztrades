<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellingsRequest;
use App\Models\Selling;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class SellingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Admin.sellings.index')->with([
            'sellings' => Selling::get()
        ]);
    }

    public function create()
    {
        return view('Admin.sellings.edit', [
            'action' => route('sellings.store'),
            'method' => null,
            'data'   => null
        ]);
    }

    public function store(SellingsRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $selling = Selling::create($validated);

        return redirect()->route('sellings.index')->with('success', "Selling {$selling->getAttribute('from_sell')} created successfully!");
    }

    public function show(Selling $selling)
    {
        return view('Admin.sellings.edit', [
            'action' => null,
            'method' => null,
            'data'   => $selling
        ]);
    }

    public function edit(Selling $selling)
    {
        return view('Admin.sellings.edit', [
            'action' => route('sellings.update', $selling),
            'method' => "PUT",
            'data'   => $selling
        ]);
    }

    public function update(SellingsRequest $request, Selling $selling): RedirectResponse
    {
        $validated = $request->validated();

        $selling->update($validated);

        return redirect()->route('sellings.index')->with('success', "Selling {$selling->getAttribute('from_sell')} updated successfully!");
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
