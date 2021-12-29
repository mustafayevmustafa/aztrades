<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Requests\CountryRequest;
use App\Http\Requests\ExprenceTypeRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\ExprencType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ExprenceTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Admin.cities.index')->with([
            'exprence_types' => ExprencType::get()
        ]);
    }

    public function create()
    {
        return view('admin.exprence_types.edit', [
            'action' => route('cities.store'),
            'method' => null,
            'data'   => null
        ]);
    }

    public function store(ExprenceTypeRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $exprence_type = ExprencType::create($validated);

        return redirect()->route('cities.index')->with('success', "City {$exprence_type ->getAttribute('name')} reated successfully!");
    }

    public function show(City $city)
    {
        return view('admin.cities.edit', [
            'action' => null,
            'method' => null,
            'data'   => $city
        ]);
    }

    public function edit(City $city)
    {
        return view('admin.countries.edit', [
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
