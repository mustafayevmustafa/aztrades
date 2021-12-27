<?php

namespace App\Http\Controllers;

use App\Http\Requests\OnionRequest;
use App\Models\Onion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OnionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
//        $this->authorizeResource(Post::class, 'post');
    }

    public function index()
    {
        $onions = Onion::all();
        return view('Admin.onions.index', compact('onions'));
    }

    public function create()
    {
        return view('admin.onions.edit', [
            'action' => route('onions.store'),
            'method' => null,
            'data'   => null
        ]);
    }

    public function store(OnionRequest $request): RedirectResponse
    {

        $validated = $request->validated();

        Onion::create($validated);

        return redirect()->route('onions.index')->with('message', 'Created successfully!');
    }

    public function show(Onion $onion)
    {
        return view('admin.onions.edit', [
            'action' => null,
            'method' => null,
            'data'   => $onion
        ]);
    }

    public function edit(Onion $onion)
    {
        return view('admin.onions.edit', [
            'action' => route('onions.update', $onion),
            'method' => "PUT",
            'data'   => $onion
        ]);
    }

    public function update(OnionRequest $request, Onion $onion): RedirectResponse
    {
        $validated = $request->validated();


        $validated['state'] = $request->has('state');

        $onion->update($validated);

        return redirect()->route('onions.index')->with('message', "Post {$onion->getAttribute('title')} updated successfully!");
    }

    public function destroy(Onion $onion)
    {
        if($onion->delete()){
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
