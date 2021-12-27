<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Http\Requests\SellingsRequest;
use App\Models\Country;
use App\Models\Debet;
use App\Models\Selling;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SellingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->authorizeResource(Post::class, 'post');
    }

    public function index()
    {
        $sellings = Selling::all();
        return view('Admin.sellings.index', compact('sellings'));
    }

    public function create()
    {
        return view('admin.debets.edit', [
            'action' => route('debets.store'),
            'method' => null,
            'data'   => null
        ]);
    }

    public function store(SellingsRequest $request): RedirectResponse
    {

        $validated = $request->validated();

        Debet::create($validated);

        return redirect()->route('debets.index')->with('message', 'Created successfully!');
    }

    public function show(Debet $country)
    {
        return view('admin.debets.edit', [
            'action' => null,
            'method' => null,
            'data'   => $country
        ]);
    }

    public function edit(Debet $debet)
    {
        return view('admin.countries.edit', [
            'action' => route('debets.update', $debet),
            'method' => "PUT",
            'data'   => $debet
        ]);
    }

    public function update(SellingsRequest $request, Debet $debet): RedirectResponse
    {
        $validated = $request->validated();

        $debet->update($validated);

        return redirect()->route('debets.index')->with('message', "Post {$debet->getAttribute('title')} updated successfully!");
    }

    public function destroy(Debet $debet)
    {
        if($debet->delete()){
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
