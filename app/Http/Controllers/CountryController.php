<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->authorizeResource(Post::class, 'post');
    }

    public function index()
    {
        $countries = Country::all();
        return view('Admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.edit', [
            'action' => route('countries.store'),
            'method' => null,
            'data'   => null
        ]);
    }

    public function store(CountryRequest $request): RedirectResponse
    {

        $validated = $request->validated();

        Country::create($validated);

        return redirect()->route('countries.index')->with('message', 'Created successfully!');
    }

    public function show(Country $country)
    {
        return view('admin.countries.edit', [
            'action' => null,
            'method' => null,
            'data'   => $country
        ]);
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', [
            'action' => route('countries.update', $country),
            'method' => "PUT",
            'data'   => $country
        ]);
    }

    public function update(CountryRequest $request, Country $country): RedirectResponse
    {
        $validated = $request->validated();

        $country->update($validated);

        return redirect()->route('countries.index')->with('message', "Post {$country->getAttribute('title')} updated successfully!");
    }

    public function destroy(Country $country)
    {
        if($country->delete()){
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
