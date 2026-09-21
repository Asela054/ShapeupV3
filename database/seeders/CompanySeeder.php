<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Organization\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name'              => 'Test_1',
                'code'              => 'T01',
                'logo'              => null,
                'address'           => 'No. 45, Galle Road, Colombo 03',
                'mobile'            => '0771234567',
                'land'              => '0112345678',
                'email'             => 'info@test1.lk',
                'domain_name'       => 'test1.lk',
                'epf'               => 'EPF001',
                'etf'               => 'ETF001',
                'employer_number'   => 'EMP0001',
                'zone_code'         => '1',
                'ref_no'            => 'REF-001',
                'vat_reg_no'        => 'VAT001122334',
                'svat_no'           => 'SVAT00112233',
                'company_type'      => 1,
                'paysheet_language' => 1,
                'status'            => 1,
                'created_by'        => 1,
                'updated_by'        => 1,
            ],
            [
                'name'              => 'Test_2',
                'code'              => 'T02',
                'logo'              => null,
                'address'           => 'No. 12, Lewis Place, Negombo',
                'mobile'            => '0772345678',
                'land'              => '0312233445',
                'email'             => 'contact@test2.lk',
                'domain_name'       => 'test2.lk',
                'epf'               => 'EPF002',
                'etf'               => 'ETF002',
                'employer_number'   => 'EMP0002',
                'zone_code'         => '2',
                'ref_no'            => 'REF-002',
                'vat_reg_no'        => 'VAT002233445',
                'svat_no'           => 'SVAT00223344',
                'company_type'      => 2,
                'paysheet_language' => 1,
                'status'            => 1,
                'created_by'        => 1,
                'updated_by'        => 1,
            ],
            [
                'name'              => 'Test_3',
                'code'              => 'T03',
                'logo'              => null,
                'address'           => 'No. 78, Peradeniya Road, Kandy',
                'mobile'            => '0773456789',
                'land'              => '0812233445',
                'email'             => 'hello@test3.lk',
                'domain_name'       => 'test3.lk',
                'epf'               => 'EPF003',
                'etf'               => 'ETF003',
                'employer_number'   => 'EMP0003',
                'zone_code'         => '3',
                'ref_no'            => 'REF-003',
                'vat_reg_no'        => 'VAT003344556',
                'svat_no'           => 'SVAT00334455',
                'company_type'      => 1,
                'paysheet_language' => 2,
                'status'            => 1,
                'created_by'        => 1,
                'updated_by'        => 1,
            ],
        ];
 
        foreach ($companies as $company) {
            Company::updateOrCreate(
                ['code' => $company['code']],
                $company
            );
        }
    }
}