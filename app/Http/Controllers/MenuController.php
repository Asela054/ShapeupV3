<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index()
    {
        return view('menu.index');
    }

    public function getdata()
    {
        $menus = Menu::query()
            ->select(['idtbl_menu_list', 'menu', 'status'])
            ->where('status', '!=', 3);

        return datatables()->eloquent($menus)
            ->filterColumn('idtbl_menu_list', function ($query, $keyword) {
                $query->where('idtbl_menu_list', 'LIKE', "%{$keyword}%");
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function show($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            return response()->json($menu);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Menu not found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu' => 'required|string|max:4500',
        ]);

        $menu = Menu::create([
            'menu' => strtoupper(trim($request->menu)),
            'status' => 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Menu added successfully!',
            'menu' => $menu,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'menu' => 'required|string|max:4500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $menu = Menu::findOrFail($id);
            $menu->update([
                'menu' => strtoupper(trim($request->menu)),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Menu updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update menu',
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,2,3',
        ]);

        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'message' => 'Menu not found'
            ], 404);
        }

        $menu->status = (int) $request->status;
        $menu->save();

        if ((int) $request->status === 3) {
            $message = 'Menu deleted successfully';
        } elseif ((int) $request->status === 2) {
            $message = 'Menu deactivated successfully';
        } else {
            $message = 'Menu activated successfully';
        }

        return response()->json([
            'message' => $message
        ], 200);
    }
}
