<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;


class UserTypeController extends Controller
{
    public function typeIndex()
    {
        return view('users.type');
    }

    public function getUsertypeData()
    {
        $roles = Role::all();
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
            Role::create([
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
        $role = Role::findOrFail($id);
        
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
            $role = Role::findOrFail($id);
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
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json(['status' => true, 'message' => 'User type deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to delete user type'], 500);
        }
    }
}