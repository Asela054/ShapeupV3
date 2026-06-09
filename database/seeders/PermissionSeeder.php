<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
             ['name' => 'Access-Administrator', 'module_name' => 'Administrator'],
             ['name' => 'Access-Organization', 'module_name' => 'Organization'],
             ['name' => 'Access-Employee-Management', 'module_name' => 'Employee-Management'],
             ['name' => 'Access-Attendance_Leave', 'module_name' => 'Attendance_Leave'],
             ['name' => 'Access-Shift_Management', 'module_name' => 'Shift_Management'],
             ['name' => 'Access-Reports', 'module_name' => 'Reports'],
             ['name' => 'Access-Payroll', 'module_name' => 'Payroll'],
             ['name' => 'Access-KPI_Managemnt', 'module_name' => 'KPI_Management'],
             ['name' => 'Access-User_account', 'module_name' => 'User_account'],
            ['name' => 'Role-List', 'module_name' => 'Role'],
            ['name' => 'Role-Create', 'module_name' => 'Role'],
            ['name' => 'Role-Edit', 'module_name' => 'Role'],
            ['name' => 'Role-Delete', 'module_name' => 'Role'],
            ['name' => 'User-List', 'module_name' => 'User'],
            ['name' => 'User-Create', 'module_name' => 'User'],
            ['name' => 'User-Edit', 'module_name' => 'User'],
            ['name' => 'User-Delete', 'module_name' => 'User'],
            ['name' => 'User-Status', 'module_name' => 'User'],
            ['name' => 'Permission-List', 'module_name' => 'Permission'],
            ['name' => 'Permission-Create', 'module_name' => 'Permission'],
            ['name' => 'Permission-Edit', 'module_name' => 'Permission'],
            ['name' => 'Permission-Delete', 'module_name' => 'Permission'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
               'name' => $permission['name'],
           ], [
               'module_name' => $permission['module_name']
           ]);
       }
    }
}
