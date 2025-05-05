<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $allowedCodes = [
        //     'WBC',
        //     'RBC',
        //     'HGB',
        //     'HCT',
        //     'MCV',
        //     'MCH',
        //     'MCHC',
        //     'PLT',
        //     'LYM%',
        //     'MXD%',
        //     'NEUT%',
        //     'LYM#',
        //     'MXD#',
        //     'NEUT#',
        //     'RDW-CV',
        //     'PDW',
        //     'MPV',
        //     'P-LCR',
        //     'PCT',
        //     'P-LCC'
        // ];

        $data = [
            [
                'code' => 'WBC',
                'name' => 'White Blood Cell',
                'loinc_code' => '6690-2',
                'default_unit' => '10^9/L',
                'default_ref_range' => '4.0-10.0',
            ],
            [
                'code' => 'RBC',
                'name' => 'Red Blood Cell',
                'loinc_code' => '789-8',
                'default_unit' => '10^12/L',
                'default_ref_range' => '4.5-6.0',
            ],
            [
                'code' => 'HGB',
                'name' => 'Hemoglobin',
                'loinc_code' => '718-7',
                'default_unit' => 'g/dL',
                'default_ref_range' => '13.0-17.0',
            ],
            [
                'code' => 'HCT',
                'name' => 'Hematocrit',
                'loinc_code' => '718-7',
                'default_unit' => '%',
                'default_ref_range' => '40-50',
            ],
            [
                'code' => 'MCV',
                'name' => 'Mean Corpuscular Volume',
                'loinc_code' => '787-0',
                'default_unit' => 'fL',
                'default_ref_range' => '80-100',
            ],
            [
                'code' => 'MCH',
                'name' => 'Mean Corpuscular Hemoglobin',
                'loinc_code' => '785-4',
                'default_unit' => 'pg',
                'default_ref_range' => '27-31',
            ],
            [
                'code' => 'MCHC',
                'name' => 'Mean Corpuscular Hemoglobin Concentration',
                'loinc_code' => '786-2',
                'default_unit' => '%',
                'default_ref_range' => '32-36',
            ],
            [
                'code' => 'PLT',
                'name' => 'Platelet Count',
                'loinc_code' => '777-3',
                'default_unit' => '/uL',
                'default_ref_range' => '',
            ],
            [
                'code' => 'LYM%',
                'name' => 'Lymphocyte Percentage',
                'loinc_code' => '26464-8',
                'default_unit' => '%',
                'default_ref_range' => '',
            ],
            [
                'code' => 'MXD%',
                'name' => 'Mixed Cell Percentage',
                'loinc_code' => '26465-5',
                'default_unit' => '%',
                'default_ref_range' => '',
            ],
            [
                'code' => 'NEUT%',
                'name' => 'Neutrophil Percentage',
                'loinc_code' => '26466-3',
                'default_unit' => '%',
                'default_ref_range' => '',
            ],
            [
                'code' => 'LYM#',
                'name' => 'Lymphocyte Count',
                'loinc_code' => '',
                'default_unit' => '/uL',
                'default_ref_range' => '',
            ],
            [
                'code' => 'MXD#',
                'name' => 'Mixed Cell Count',
                'loinc_code' => '',
                'default_unit' => '/uL',
                'default_ref_range' => '',
            ],
            [
                'code' => 'NEUT#',
                'name' => 'Neutrophil Count',
                'loinc_code' => '',
                'default_unit' => '/uL',
                'default_ref_range' => '',
            ],
            [
                'code' => 'RDW-CV',
                'name' => "Red Cell Distribution Width - Coefficient of Variation",
                'loinc_code' => null,
                'default_unit' => null,
                'default_ref_range' => null
            ],
            [
                'code' => 'PDW',
                'name' => 'Platelet Distribution Width',
                'loinc_code' => null,
                'default_unit' => null,
                'default_ref_range' => null
            ],
            [
                'code' => 'MPV',
                'name' => 'Mean Platelet Volume',
                'loinc_code' => null,
                'default_unit' => null,
                'default_ref_range' => null
            ],
            [
                'code' => 'P-LCR',
                'name' => 'Platelet Large Cell Ratio',
                'loinc_code' => null,
                'default_unit' => null,
                'default_ref_range' => null
            ],
            [
                'code' => 'PCT',
                'name' => 'Plateletcrit',
                'loinc_code' => null,
                'default_unit' => null,
                'default_ref_range' => null
            ],
            [
                'code' => 'P-LCC',
                'name' => 'Platelet Large Cell Count',
                'loinc_code' => null,
                'default_unit' => null,
                'default_ref_range' => null
            ]
        ];

        DB::table('lab_parameters')->insert($data);
    }
}
