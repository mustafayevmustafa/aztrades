<?php

namespace App\Http\Controllers;

use App\Http\Requests\PotatoRequest;
use App\Models\Potato;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PotatoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
//        $this->authorizeResource(Post::class, 'post');
    }

    public function index()
    {
        $potatoes = Potato::all();
        return view('Admin.potatoes.index', compact('potatoes'));
    }

    public function create()
    {
        return view('admin.potatoes.edit', [
            'action' => route('potatoes.store'),
            'method' => null,
            'data'   => null
        ]);
    }

    public function store(PotatoRequest $request): RedirectResponse
    {

        $validated = $request->validated();

        Potato::create($validated);

        return redirect()->route('potatoes.index')->with('message', 'Created successfully!');
    }

    public function show(Potato $potato)
    {
        return view('admin.potatoes.edit', [
            'action' => null,
            'method' => null,
            'data'   => $potato
        ]);
    }

    public function edit(Potato $potato)
    {
        return view('admin.potatoes.edit', [
            'action' => route('potatoes.update', $potato),
            'method' => "PUT",
            'data'   => $potato
        ]);
    }

    public function update(PotatoRequest $request, Potato $potato): RedirectResponse
    {
        $validated = $request->validated();


        $validated['state'] = $request->has('state');

        $potato->update($validated);

        return redirect()->route('potatoes.index')->with('message', "Post {$potato->getAttribute('title')} updated successfully!");
    }

    public function destroy(Potato $potato)
    {
        if($potato->delete()){
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
