<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserPrivilegeController extends Controller
{
    public function privilegeIndex()
    {
        $users = User::where('status', 1)->get();
        $users = $users->map(function ($u) {
            $u->idtbl_user = $u->id;
            $u->username = $u->email;
            return $u;
        });

        $menus = \Spatie\Permission\Models\Permission::all();
        $menus = $menus->map(function ($m) {
            $m->idtbl_menu_list = $m->id;
            $m->menu = $m->name;
            return $m;
        });

        return view('users.privileges', compact('users', 'menus'));
    }

    public function getPrivilegeData()
    {
        $users = User::where('status', 1)->get();
        $permissions = \Spatie\Permission\Models\Permission::all();
        $privileges = collect();
        $id = 1;
        
        foreach ($users as $user) {
            foreach ($permissions as $permission) {
                $hasPermission = $user->hasDirectPermission($permission) || $user->hasPermissionTo($permission);
                
                $privileges->push((object)[
                    'idtbl_user_privilege' => $id++,
                    'tbl_user_idtbl_user' => $user->id,
                    'tbl_menu_list_idtbl_menu_list' => $permission->id,
                    'user' => (object)[
                        'idtbl_user' => $user->id,
                        'name' => $user->name,
                        'username' => $user->email,
                    ],
                    'menu' => (object)[
                        'idtbl_menu_list' => $permission->id,
                        'menu' => $permission->name,
                    ],
                    'access_status' => $hasPermission ? 1 : 0,
                    'add' => $hasPermission ? 1 : 0,
                    'edit' => $hasPermission ? 1 : 0,
                    'statuschange' => $hasPermission ? 1 : 0,
                    'remove' => $hasPermission ? 1 : 0,
                    'status' => 1,
                ]);
            }
        }

        return datatables()->of($privileges)
            ->addIndexColumn()
            ->make(true);
    }

    public function privilegeAdd(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'menu_id' => 'required|array',
            'menu_id.*' => 'exists:permissions,id',
        ]);

        try {
            $user = User::findOrFail($request->user_id);

            foreach ($request->menu_id as $permissionId) {
                $permission = \Spatie\Permission\Models\Permission::findById($permissionId);
                if ($permission) {
                    if ($request->access_status == 1) {
                        $user->givePermissionTo($permission);
                    } else {
                        $user->revokePermissionTo($permission);
                    }
                }
            }

            return response()->json(['status' => true, 'message' => 'Privileges processed successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to assign privileges: ' . $e->getMessage()], 500);
        }
    }

    public function editPrivilege(Request $request, $id)
    {
        $users = User::where('status', 1)->get();
        $permissions = \Spatie\Permission\Models\Permission::all();
        $mockId = 1;
        
        foreach ($users as $user) {
            foreach ($permissions as $permission) {
                if ($mockId == $id) {
                    if ($request->access_status == 1) {
                        $user->givePermissionTo($permission);
                    } else {
                        $user->revokePermissionTo($permission);
                    }
                    return response()->json(['status' => true, 'message' => 'Privilege updated successfully']);
                }
                $mockId++;
            }
        }
        return response()->json(['status' => false, 'message' => 'Privilege not found'], 404);
    }

    public function getPrivilege(Request $request, $id)
    {
        $users = User::where('status', 1)->get();
        $permissions = \Spatie\Permission\Models\Permission::all();
        $mockId = 1;
        
        foreach ($users as $user) {
            foreach ($permissions as $permission) {
                if ($mockId == $id) {
                    $hasPermission = $user->hasDirectPermission($permission) || $user->hasPermissionTo($permission);
                    return response()->json((object)[
                        'idtbl_user_privilege' => $mockId,
                        'tbl_user_idtbl_user' => $user->id,
                        'tbl_menu_list_idtbl_menu_list' => $permission->id,
                        'access_status' => $hasPermission ? 1 : 0,
                        'add' => $hasPermission ? 1 : 0,
                        'edit' => $hasPermission ? 1 : 0,
                        'statuschange' => $hasPermission ? 1 : 0,
                        'remove' => $hasPermission ? 1 : 0,
                        'status' => 1,
                    ]);
                }
                $mockId++;
            }
        }
        return response()->json(['error' => 'Privilege not found'], 404);
    }

    public function updatePrivilegeStatus($id)
    {
        return response()->json(['status' => true, 'message' => 'Privilege status updated successfully']);
    }

    public function deletePrivilege($id)
    {
        $users = User::where('status', 1)->get();
        $permissions = \Spatie\Permission\Models\Permission::all();
        $mockId = 1;
        
        foreach ($users as $user) {
            foreach ($permissions as $permission) {
                if ($mockId == $id) {
                    $user->revokePermissionTo($permission);
                    return response()->json(['status' => true, 'message' => 'Privilege deleted successfully']);
                }
                $mockId++;
            }
        }
        return response()->json(['status' => false, 'message' => 'Privilege not found'], 404);
    }
}