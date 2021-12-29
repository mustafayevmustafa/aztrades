<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Admin.countries.index')->with([
            'countries' => Country::get()
        ]);
    }

    public function create()
    {
        return view('Admin.countries.edit', [
            'action' => route('countries.store'),
            'method' => null,
            'data'   => null
        ]);
    }

    public function store(CountryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $country = Country::create($validated);

        return redirect()->route('countries.index')->with('success', "Country {$country->getAttribute('name')} reated successfully!");
    }

    public function show(Country $country)
    {
        return view('Admin.countries.edit', [
            'action' => null,
            'method' => null,
            'data'   => $country
        ]);
    }

    public function edit(Country $country)
    {
        return view('Admin.countries.edit', [
            'action' => route('countries.update', $country),
            'method' => "PUT",
            'data'   => $country
        ]);
    }

    public function update(CountryRequest $request, Country $country): RedirectResponse
    {
        $validated = $request->validated();

        $country->update($validated);

        return redirect()->route('countries.index')->with('success', "Country {$country->getAttribute('name')} updated successfully!");
    }

    public function destroy(Country $country): JsonResponse
    {
        if($country->delete()){
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
