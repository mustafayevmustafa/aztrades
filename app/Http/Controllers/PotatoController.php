<?php

namespace App\Http\Controllers;

use App\Http\Requests\PotatoRequest;
use App\Models\Country;
use App\Models\Potato;
use App\Models\PotatoSac;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PotatoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Admin.potatoes.index')->with([
            'potatoes' => Potato::latest()->get()
        ]);
    }

    public function create()
    {
        return view('admin.potatoes.edit', [
            'action' => route('potatoes.store'),
            'method' => null,
            'data'   => null,
            'countries' => Country::get(),
        ]);
    }

    public function store(PotatoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $potato = Potato::create($validated);

        foreach ($validated['sacs'] as $index => $sac) {
            $validated['sacs'][$index]['name'] .= " (#{$potato->id})";
        }

        if($request->has('sacs')){
            $potato->sacs()->createMany($validated['sacs']);
        }

        return redirect()->route('potatoes.index')->with('success', "Potato {$potato->getAttribute('from_whom')} created successfully!");
    }

    public function show(Potato $potato)
    {
        return view('admin.potatoes.edit', [
            'action' => null,
            'method' => null,
            'data'   => $potato,
            'countries' => Country::get(),

        ]);
    }

    public function edit(Potato $potato)
    {
        return view('admin.potatoes.edit', [
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

        $sacs->each(fn($sac) => $potato->sacs()->updateOrCreate(['id' => $sac['id']], $sac));

        return redirect()->route('potatoes.index')->with('success', "Potato {$potato->getAttribute('from_whom')} updated successfully!");
    }

    public function destroy(Potato $potato): JsonResponse
    {
        if($potato->delete()){
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
