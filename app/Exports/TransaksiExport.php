<?php

namespace App\Exports;

use App\Models\Transaksi1;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PHPUnit\Event\Telemetry\HRTime;

class TransaksiExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithHeadingRow
{
    protected $blth;

    public function __construct($blth)
    {
        $this->blth = $blth;
    }

    /**
     * Mengambil koleksi data untuk diexport.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Transaksi1::where('blth', $this->blth)->get();
    }


    public function headings(): array
    {
        return [
            'ID',
            'BLTH',
            'Kode',
            'Jam Operasional',
            'Liter',
            'Kapasitas Produksi',
            'Distribusi',
            'Flushing',
            'Spey',
            'Produksi',
        ];
    }
    public function styles(Worksheet $sheet){
        return [
            1 => ['font' => ['bold' => true]],

        ];
    }
}
