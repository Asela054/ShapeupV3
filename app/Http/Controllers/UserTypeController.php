<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class UserTypeController extends Controller
{
    public function typeIndex()
    {
        return view('users.type');
    }

    public function getUsertypeData()
    {
        $roles = Role::query()->select(['id', 'name']);

        return DataTables::of($roles)
            ->addColumn('type', fn($role) => $role->name)
            ->addColumn('idtbl_user_type', fn($role) => $role->id)
            ->addColumn('status', fn($role) => 1)
            ->addIndexColumn()
            ->make(true);
    }

    public function addUserType(Request $request)
    {
        $request->validate([
            'type'         => ['required', 'string', 'max:100', 'unique:roles,name'],
            'permission'   => ['nullable', 'array'],
            'permission.*' => ['integer', 'exists:permissions,id'],
        ]);

        try {
            $role = Role::create([
                'name'       => $request->type,
                'guard_name' => 'web',
            ]);

            if ($request->filled('permission')) {
                $role->permissions()->sync($request->permission);
            }

            return redirect()->back()->with('success', 'User type added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add user type: ' . $e->getMessage());
        }
    }

    public function editUserType(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_id', $id)
            ->pluck('permission_id')
            ->toArray();

        $allPermissions = Permission::select('id', 'name', 'module_name')
            ->orderBy('module_name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'id'              => $role->id,
            'type'            => $role->name,
            'idtbl_user_type' => $role->id,
            'permissions'     => $allPermissions,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    public function updateUserType(Request $request, $id)
    {
        $request->validate([
            'type'         => ['required', 'string', 'max:100', 'unique:roles,name,' . $id],
            'permission'   => ['nullable', 'array'],
            'permission.*' => ['integer', 'exists:permissions,id'],
        ]);

        try {
            $role = Role::findOrFail($id);
            $role->name = $request->type;
            $role->save();

            $role->permissions()->sync($request->permission ?? []);

            return redirect()->back()->with('success', 'User type updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user type: ' . $e->getMessage());
        }
    }

    public function getAllPermissions()
    {
        $allPermissions = Permission::select('id', 'name', 'module_name')
            ->orderBy('module_name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'permissions'     => $allPermissions,
            'rolePermissions' => [],
        ]);
    }

    public function getTypePermissions($id)
    {
        // id=0 is used by the "Create" modal to load all permissions with none checked
        $role            = ($id > 0) ? Role::findOrFail($id) : null;
        $rolePermissions = [];

        if ($role) {
            $rolePermissions = DB::table('role_has_permissions')
                ->where('role_id', $id)
                ->pluck('permission_id')
                ->toArray();
        }

        $allPermissions = Permission::select('id', 'name', 'module_name')
            ->orderBy('module_name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'id'              => $role?->id,
            'type'            => $role?->name,
            'idtbl_user_type' => $role?->id,
            'permissions'     => $allPermissions,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    public function updateUserTypeStatus($id)
    {
        return response()->json(['status' => true, 'message' => 'User type status updated successfully']);
    }

    public function destroyUserType($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json(['status' => true, 'message' => 'User type deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to delete user type'], 500);
        }
    }
}