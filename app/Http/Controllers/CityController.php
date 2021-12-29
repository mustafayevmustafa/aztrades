<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Requests\CountryRequest;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Admin.cities.index')->with([
            'cities' => City::get()
        ]);
    }

    public function create()
    {
        return view('Admin.cities.edit', [
            'action' => route('cities.store'),
            'method' => null,
            'data'   => null
        ]);
    }

    public function store(CityRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $city = City::create($validated);

        return redirect()->route('cities.index')->with('success', "City {$city->getAttribute('name')} reated successfully!");
    }

    public function show(City $city)
    {
        return view('Admin.cities.edit', [
            'action' => null,
            'method' => null,
            'data'   => $city
        ]);
    }

    public function edit(City $city)
    {
        return view('Admin.countries.edit', [
            'action' => route('cities.update', $city),
            'method' => "PUT",
            'data'   => $city
        ]);
    }

    public function update(CityRequest $request, City $city): RedirectResponse
    {
        $validated = $request->validated();

        $city->update($validated);

        return redirect()->route('cities.index')->with('success', "City {$city->getAttribute('name')} updated successfully!");
    }

    public function destroy(City $city): JsonResponse
    {
        if($city->delete()){
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
