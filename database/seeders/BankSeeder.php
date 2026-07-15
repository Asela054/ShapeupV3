<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $banks = [
            ['code' => '7852', 'name' => 'Alliance Finance Company PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7463', 'name' => 'Amana Bank PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7472', 'name' => 'Axis Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7010', 'name' => 'Bank of Ceylon', 'status' => 1, 'created_by' => '1'],
            ['code' => '7481', 'name' => 'Cargills Bank Limited', 'status' => 1, 'created_by' => '1'],
            ['code' => '8004', 'name' => 'Central Bank of Sri Lanka', 'status' => 1, 'created_by' => '1'],
            ['code' => '7825', 'name' => 'Central Finance PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7047', 'name' => 'Citi Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7746', 'name' => 'Citizen Development Business Finance PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7056', 'name' => 'Commercial Bank PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7870', 'name' => 'Commercial Credit & Finance PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7807', 'name' => 'Commercial Leasing and Finance', 'status' => 1, 'created_by' => '1'],
            ['code' => '7205', 'name' => 'Deutsche Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7454', 'name' => 'DFCC Bank PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7074', 'name' => 'Habib Bank Ltd', 'status' => 1, 'created_by' => '1'],
            ['code' => '7083', 'name' => 'Hatton National Bank PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7737', 'name' => 'HDFC Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7092', 'name' => 'Hongkong Shanghai Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7384', 'name' => 'ICICI Bank Ltd', 'status' => 1, 'created_by' => '1'],
            ['code' => '7108', 'name' => 'Indian Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7117', 'name' => 'Indian Overseas Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7834', 'name' => 'Kanrich Finance Limited', 'status' => 1, 'created_by' => '1'],
            ['code' => '7861', 'name' => 'Lanka Orix Finance PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7773', 'name' => 'LB Finance PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7269', 'name' => 'MCB Bank Ltd', 'status' => 1, 'created_by' => '1'],
            ['code' => '7913', 'name' => 'Mercantile Investment and Finance PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7898', 'name' => 'Merchant Bank of Sri Lanka & Finance PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7214', 'name' => 'National Development Bank PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7719', 'name' => 'National Savings Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7162', 'name' => 'Nations Trust Bank PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7311', 'name' => 'Pan Asia Banking Corporation PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7135', 'name' => 'Peoples Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7922', 'name' => 'People\'s Leasing & Finance PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7296', 'name' => 'Public Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7755', 'name' => 'Regional Development Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7278', 'name' => 'Sampath Bank PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7728', 'name' => 'Sanasa Development Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7782', 'name' => 'Senkadagala Finance PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7287', 'name' => 'Seylan Bank PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7038', 'name' => 'Standard Chartered Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7144', 'name' => 'State Bank of India', 'status' => 1, 'created_by' => '1'],
            ['code' => '7764', 'name' => 'State Mortgage & Investment Bank', 'status' => 1, 'created_by' => '1'],
            ['code' => '7302', 'name' => 'Union Bank of Colombo PLC', 'status' => 1, 'created_by' => '1'],
            ['code' => '7816', 'name' => 'Vallibel Finance PLC', 'status' => 1, 'created_by' => '1'],
        ];

        foreach ($banks as $bank) {
            DB::table('banks')->insert([
                'code' => $bank['code'],
                'name' => $bank['name'],
                'status' => $bank['status'],
                'created_by' => $bank['created_by'],
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}