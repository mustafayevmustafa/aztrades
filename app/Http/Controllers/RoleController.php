<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Admin.roles.index')->with([
            'roles' => Role::get()
        ]);
    }
    public function create()
    {
        return view('admin.roles.edit', [
            'action' => route('roles.store'),
            'method' => null,
            'data'   => null
        ]);
    }

    public function store(RoleRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $role = Role::create($validated);

        return redirect()->route('roles.index')->with('success', "Roles {$role->getAttribute('name')} reated successfully!");
    }

    public function show(Role $role)
    {
        return view('admin.roles.edit', [
            'action' => null,
            'method' => null,
            'data'   => $role
        ]);
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', [
            'action' => route('roles.update', $role),
            'method' => "PUT",
            'data'   => $role
        ]);
    }

    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $validated = $request->validated();

        $role->update($validated);

        return redirect()->route('roles.index')->with('success', "Roles {$role->getAttribute('name')} updated successfully!");
    }

    public function destroy(Role $role): RedirectResponse
    {
        if($role->delete()){
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
