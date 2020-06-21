<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->role;

        $hasPermission = null;

        $permissions = null;

        $roles = Role::all()->filter(function ($q) {
            return $q->name != 'super admin';
        })->pluck('name');

        if (!empty($role)) {
            $getRole = Role::findByName($role);

            $hasPermission = $getRole->permissions->pluck('name')->toArray();

            $permissions = Permission::all()->pluck('name');
        }

        return view('role.index', compact('roles', 'hasPermission', 'permissions'));
    }

    public function update(Request $request, $role)
    {
        $role = Role::findByName($role);

        $role->syncPermissions($request->permissions);
        
        return redirect()->back()->with(['success' => 'Hak akses berhasil di simpan']);
    }
}
