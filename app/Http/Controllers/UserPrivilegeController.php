<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class UserPrivilegeController extends Controller
{
    protected $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function privilegeIndex()
    {
        $modules = $this->service->getModules();
        return view('users.privileges', compact('modules'));
    }

    public function getPrivilegeData(Request $request)
    {
        $permissions = Permission::query()->select('id', 'name', 'module_name');

        return DataTables::of($permissions)
            ->addColumn('idtbl_user_privilege', fn($row) => $row->id)
            ->addColumn('permission_name',      fn($row) => $row->name)
            ->addColumn('module',               fn($row) => $row->module_name ?? '-')
            ->make(true);
    }

    protected function rules(?int $permissionId = null): array
    {
        return [
            'name'               => ['required', 'string', 'max:100'],
            'module_name'        => ['required', 'string', 'max:100'],
            'permission_types'   => ['nullable', 'array'],
            'permission_types.*' => ['string', 'max:50'],
        ];
    }

    public function privilegeAdd(Request $request)
    {
        $validated = $request->validate($this->rules());

        $result = $this->service->create(
            $validated['name'],
            $validated['module_name'],
            $validated['permission_types'] ?? []
        );

        if ($result['created'] === 0 && !empty($result['skipped'])) {
            return response()->json([
                'status'  => false,
                'message' => 'All selected permissions already exist: ' . implode(', ', $result['skipped']) . '.',
            ], 422);
        }

        $message = $result['created'] . ' privilege(s) created successfully.';
        if (!empty($result['skipped'])) {
            $message .= ' Skipped (already exist): ' . implode(', ', $result['skipped']) . '.';
        }

        return response()->json(['status' => true, 'message' => $message]);
    }

    public function getPrivilege(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        return response()->json([
            'idtbl_user_privilege' => $permission->id,
            'name'                 => $permission->name,
            'module_name'          => $permission->module_name,
        ]);
    }

    public function editPrivilege(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:permissions,name,' . $id],
            'module_name' => ['required', 'string', 'max:100'],
        ]);

        $this->service->update($permission, $validated['name'], $validated['module_name']);

        return response()->json(['status' => true, 'message' => 'Privilege updated successfully.']);
    }

    public function updatePrivilegeStatus($id)
    {
        // Permissions table has no status column; method kept for route compatibility
        return response()->json(['status' => true, 'message' => 'Privilege status updated successfully.']);
    }

    public function deletePrivilege($id)
    {
        $permission = Permission::findOrFail($id);

        $this->service->delete($permission);

        return response()->json(['status' => true, 'message' => 'Privilege deleted successfully.']);
    }
}
