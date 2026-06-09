<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function index()
    {
        $user_type = \Spatie\Permission\Models\Role::all();
        return view('users.account', compact('user_type'));
    }

    public function getUsersData()
    {
        $users = User::with('roles')->where('status', '!=', 3)->orderBy('name')->get();
        
        return datatables()->of($users)
            ->addIndexColumn()
            ->addColumn('username', function ($user) {
                return $user->email;
            })
            ->addColumn('user_type', function ($user) {
                return [
                    'type' => $user->roles->first() ? $user->roles->first()->name : 'No Role'
                ];
            })
            ->addColumn('idtbl_user', function ($user) {
                return $user->id;
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_type' => ['required', 'exists:roles,id'],
            'image' => ['nullable', 'image', 'max:1024'],
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('users/images', 'public');
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->status = 1;
            
            if (Schema::hasColumn('users', 'role_id')) {
                $user->role_id = $request->user_type;
            }
            $user->save();

            $role = \Spatie\Permission\Models\Role::find($request->user_type);
            if ($role) {
                $user->assignRole($role);
            }

            return redirect()->back()->with('success', 'User created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'User creation failed: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        $user->idtbl_user = $user->id;
        $user->username = $user->email;
        $user->tbl_user_type_idtbl_user_type = $user->roles->first() ? $user->roles->first()->id : null;
        
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $id],
            'user_type' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'image' => ['nullable', 'image', 'max:1024'],
        ]);

        try {
            $user = User::findOrFail($id);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('users/images', 'public');
                // Check if user has imagepath column
                if (Schema::hasColumn('users', 'imagepath')) {
                    $user->imagepath = $imagePath;
                }
            }

            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            if (Schema::hasColumn('users', 'role_id')) {
                $user->role_id = $request->user_type;
            }
            $user->save();

            $role = \Spatie\Permission\Models\Role::find($request->user_type);
            if ($role) {
                $user->syncRoles([$role]);
            }

            return redirect()->back()->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'User update failed: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = 3; // Soft delete
            $user->save();
            return response()->json(['status' => true, 'message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to delete user'], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = $request->status;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => $request->status == 1 ? 'User activated' : 'User deactivated'
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Action failed'], 500);
        }
    }

    public function typeIndex()
    {
        return view('users.type');
    }

    public function getUsertypeData()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        return datatables()->of($roles)
            ->addColumn('type', function ($role) {
                return $role->name;
            })
            ->addColumn('idtbl_user_type', function ($role) {
                return $role->id;
            })
            ->addColumn('status', function ($role) {
                return 1;
            })
            ->addIndexColumn()
            ->make(true);
    }
    
    public function addUserType(Request $request)
    {
        $request->validate([
            'type' => ['required', 'string', 'max:100', 'unique:roles,name'],
        ]);

        try {
            \Spatie\Permission\Models\Role::create([
                'name' => $request->type,
                'guard_name' => 'web'
            ]);

            return redirect()->back()->with('success', 'User type added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add user type: ' . $e->getMessage());
        }
    }

    public function editUserType(Request $request, $id)
    {
        $role = \Spatie\Permission\Models\Role::findOrFail($id);
        
        $role->idtbl_user_type = $role->id;
        $role->type = $role->name;
        
        return response()->json($role);
    }

    public function updateUserType(Request $request, $id)
    {
        $request->validate([
            'type' => ['required', 'string', 'max:100', 'unique:roles,name,' . $id],
        ]);

        try {
            $role = \Spatie\Permission\Models\Role::findOrFail($id);
            $role->name = $request->type;
            $role->save();
            
            return redirect()->back()->with('success', 'User type updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user type: ' . $e->getMessage());
        }
    }

    public function updateUserTypeStatus($id)
    {
        return response()->json(['status' => true, 'message' => 'User type status updated successfully']);
    }

    public function destroyUserType($id)
    {
        try {
            $role = \Spatie\Permission\Models\Role::findOrFail($id);
            $role->delete();
            return response()->json(['status' => true, 'message' => 'User type deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to delete user type'], 500);
        }
    }

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