<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmploymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $status = [
            ['emp_status' => 'PERMANENT'],
            ['emp_status' => 'TEMPORARY'],
            ['emp_status' => 'TRAINING'],
        ];

        foreach ($status as $st) {
            DB::table('employment_statuses')->insert([
                'emp_status' => $st['emp_status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}