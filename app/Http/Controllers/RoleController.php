<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function index()
    {
        return view('Admin.roles.index')->with([
            'roles' => Role::paginate(10)
        ]);
    }

    public function create()
    {
        abort(403);

        return view('Admin.roles.edit', [
            'action' => route('roles.store'),
            'method' => null,
            'data'   => null
        ]);
    }

    public function store(RoleRequest $request): RedirectResponse
    {
        abort(403);

        $validated = $request->validated();

        $role = Role::create($validated);

        return redirect()->route('roles.index')->with('success', "Roles {$role->getAttribute('name')} reated successfully!");
    }

    public function show(Role $role)
    {
        abort(403);

        return view('Admin.roles.edit', [
            'action' => null,
            'method' => null,
            'data'   => $role
        ]);
    }

    public function edit(Role $role)
    {
        abort(403);

        return view('Admin.roles.edit', [
            'action' => route('roles.update', $role),
            'method' => "PUT",
            'data'   => $role
        ]);
    }

    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        abort(403);

        $validated = $request->validated();

        $role->update($validated);

        return redirect()->route('roles.index')->with('success', "Roles {$role->getAttribute('name')} updated successfully!");
    }

    public function destroy(Role $role): JsonResponse
    {
        abort(403);

        if($role->delete()){
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
