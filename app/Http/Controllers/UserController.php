<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user_type = Role::all();
        return view('users.account', compact('user_type'));
    }

    public function getUsersData()
    {
        $users = User::with('role')->where('status', '!=', 3)->orderBy('name')->get();

        return datatables()->of($users)
            ->addIndexColumn()
            ->addColumn('username', function ($user) {
                return $user->email;
            })
            ->addColumn('user_type', function ($user) {
                return [
                    'type' => $user->role ? $user->role->name : 'No Role'
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
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role_id = $request->user_type;
            $user->status = 1;
            $user->created_by = Auth::id();
            $user->updated_by = 0;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('users/images', 'public');
                if (Schema::hasColumn('users', 'imagepath')) {
                    $user->imagepath = $imagePath;
                }
            }

            $user->save();

            return response()->json(['status' => true, 'message' => 'User created successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'User creation failed: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $user->idtbl_user = $user->id;
        $user->username = $user->email;
        $user->tbl_user_type_idtbl_user_type = $user->role_id;

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
                if (Schema::hasColumn('users', 'imagepath')) {
                    $user->imagepath = $imagePath;
                }
            }

            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->role_id = $request->user_type;
            $user->updated_by = Auth::id();
            $user->save();

            return response()->json(['status' => true, 'message' => 'User updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'User update failed: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = 3; // Soft delete
            $user->updated_by = Auth::id();
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
            $user->updated_by = Auth::id();
            $user->save();

            return response()->json([
                'status' => true,
                'message' => $request->status == 1 ? 'User activated' : 'User deactivated'
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Action failed'], 500);
        }
    }
}