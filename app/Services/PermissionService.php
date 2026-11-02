<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionService
{
    /**
     * Create one or more permissions from a base name + optional types.
     * Returns the number of permissions created and any names that were skipped.
     */
    public function create(string $baseName, string $moduleName, array $types = []): array
    {
        return DB::transaction(function () use ($baseName, $moduleName, $types) {
            $created = 0;
            $skipped = [];

            $names = empty($types)
                ? [$baseName]
                : array_map(fn($type) => $baseName . '-' . $type, $types);

            foreach ($names as $name) {
                if (Permission::where('name', $name)->exists()) {
                    $skipped[] = $name;
                    continue;
                }

                Permission::create([
                    'name'        => $name,
                    'guard_name'  => 'web',
                    'module_name' => $moduleName,
                ]);

                $created++;
            }

            return ['created' => $created, 'skipped' => $skipped];
        });
    }

    /**
     * Update an existing permission's name and module.
     */
    public function update(Permission $permission, string $name, string $moduleName): Permission
    {
        return DB::transaction(function () use ($permission, $name, $moduleName) {
            DB::table('permissions')->where('id', $permission->id)->update([
                'name'        => $name,
                'guard_name'  => 'web',
                'module_name' => $moduleName,
            ]);

            // Clear Spatie permission cache after name change
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return $permission->fresh();
        });
    }

    /**
     * Delete a permission.
     */
    public function delete(Permission $permission): void
    {
        DB::transaction(function () use ($permission) {
            $permission->delete();
        });
    }

    /**
     * Get distinct module names for the datalist.
     */
    public function getModules()
    {
        return DB::table('permissions')
            ->select('module_name')
            ->distinct()
            ->whereNotNull('module_name')
            ->get();
    }
}

