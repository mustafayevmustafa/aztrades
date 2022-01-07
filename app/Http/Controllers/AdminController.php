<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function index()
    {
        return view('Admin.admins.index')->with([
            'users' => User::latest()->paginate(10)
        ]);
    }


    public function create()
    {
        return view('Admin.admins.edit', [
            'action' => route('admins.store'),
            'method' => null,
            'data'   => null
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create($validated);

        return redirect()->route('admins.index')->with('success', "User {$user->getAttribute('name')} reated successfully!");
    }

    public function show(User $user)
    {
        return view('Admin.admins.edit', [
            'action' => null,
            'method' => null,
            'data'   => $user
        ]);
    }

    public function edit(User $user)
    {
        return view('Admin.admins.edit', [
            'action' => route('admins.update', $user),
            'method' => "PUT",
            'data'   => $user
        ]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        $user->update($validated);

        return redirect()->route('admins.index')->with('success', "User {$user->getAttribute('name')} updated successfully!");
    }

    public function destroy(User $user): JsonResponse
    {
        if($user->delete()){
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
