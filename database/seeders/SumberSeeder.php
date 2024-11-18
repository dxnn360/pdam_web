<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sumber;

class SumberSeeder extends Seeder
{
    public function run()
    {
        Sumber::create([
            'nama_sumber' => 'SB MEDONO',
            'kode' => 'X1',
        ]);

        Sumber::create([
            'nama_sumber' => 'SB PODOSUGIH',
            'kode' => 'X2',
        ]);

        Sumber::create([
            'nama_sumber' => 'SB KERGON',
            'kode' => 'X3',
        ]);

        Sumber::create([
            'nama_sumber' => 'SB PASIRSARI',
            'kode' => 'X4',
        ]);

        Sumber::create([
            'nama_sumber' => 'SB KRATON',
            'kode' => 'X5',
        ]);


    }
}
