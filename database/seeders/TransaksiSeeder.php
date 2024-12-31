<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        $transaksiData = [
            [
                'blth' => '122024', // Desember 2024
                'kode' => 'X4',
                'jam_operasional' => '21',
                'liter' => 1500.0,
                'kapasitas_produksi' => 1800.0,
                'produksi' => 1700.0,
                'distribusi' => 1600.0,
                'flushing' => 50.0,
                'spey' => 30.0,
            ],
            [
                'blth' => '122024', // Januari 2025
                'kode' => 'X2',
                'jam_operasional' => '20',
                'liter' => 2000.0,
                'kapasitas_produksi' => 2300.0,
                'produksi' => 2200.0,
                'distribusi' => 2100.0,
                'flushing' => 60.0,
                'spey' => 40.0,
            ],
            [
                'blth' => '122024', // Februari 2025
                'kode' => 'X3',
                'jam_operasional' => '21',
                'liter' => 1700.0,
                'kapasitas_produksi' => 1900.0,
                'produksi' => 1800.0,
                'distribusi' => 1700.0,
                'flushing' => 40.0,
                'spey' => 20.0,
            ],
        ];

        DB::table('transaksi1')->insert($transaksiData);
    }
}
