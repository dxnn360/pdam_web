<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sumber;
use App\Models\Transaksi1;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $totalKapasitasProduksi = Transaksi1::sum('kapasitas_produksi');
        $totalKapasitasProduksiBulanIni = $this->totalKapasitasProduksiBulanIni();
        $jumlahSumber = Sumber::count();
        $transaksis = Transaksi1::with('sumber')->get();
        $tanggal = date('mY');
        $judulTanggal = $this->formatBlth($tanggal);

        $blth = $request->input('blth', '');

        // Ambil daftar blth dari transaksi (dengan distinct)
        $listBlth = Transaksi1::select('blth')
            ->distinct()
            ->orderBy('blth', 'asc')
            ->pluck('blth');

        // Jika blth dipilih, filter transaksi berdasarkan blth tersebut
        $transaksis = Transaksi1::when($blth, function ($query) use ($blth) {
            return $query->where('blth', $blth);
        })->get();

        // Format data untuk grafik
        $transaksiPerBulan = Transaksi1::select(
            DB::raw("SUBSTR(blth, 1, 2) AS month"),
            DB::raw("CONCAT('20', SUBSTR(blth, 5, 4)) AS year"),
            DB::raw("SUM(kapasitas_produksi) AS total_produksi")
        )
            ->groupBy(DB::raw("month"), DB::raw("year"))
            ->orderBy(DB::raw("year"), 'ASC')
            ->orderBy(DB::raw("month"), 'ASC')
            ->get();

        $labels = [];
        $values = [];

        foreach ($transaksiPerBulan as $transaksi) {
            $blthConvert = $transaksi->month . $transaksi->year;
            $labels[] = $this->formatBlth($blthConvert);
            $values[] = $transaksi->total_produksi;
        }

        $listBlth = Transaksi1::select('blth')->distinct()->pluck('blth');


        return view('welcome', compact('totalKapasitasProduksi', 'jumlahSumber', 'transaksis', 'labels', 'values', 'listBlth', 'blth', 'judulTanggal', 'totalKapasitasProduksiBulanIni'));
    }

    public function transaksiPage(Request $request)
    {

        $totalKapasitasProduksi = Transaksi1::sum('kapasitas_produksi');
        $bulanIni = date('mY');
        $judulBulanIni = $this->formatBlth($bulanIni);
        $transaksismonth = Transaksi1::where('blth', $bulanIni)->with('sumber')->get();;

        $blth = $request->input('blth', '');

        // Ambil daftar blth dari transaksi (dengan distinct)
        $listBlth = Transaksi1::select('blth')
            ->distinct()
            ->orderBy('blth', 'asc')
            ->pluck('blth');

        // Jika blth dipilih, filter transaksi berdasarkan blth tersebut
        $transaksis = Transaksi1::when($blth, function ($query) use ($blth) {
            return $query->where('blth', $blth);
        })->get();

        // Format data untuk grafik
        $transaksiPerBulan = Transaksi1::select(
            DB::raw("SUBSTR(blth, 1, 2) AS month"),
            DB::raw("CONCAT('20', SUBSTR(blth, 5, 4)) AS year"),
            DB::raw("SUM(kapasitas_produksi) AS total_produksi")
        )
            ->groupBy(DB::raw("month"), DB::raw("year"))
            ->orderBy(DB::raw("year"), 'ASC')
            ->orderBy(DB::raw("month"), 'ASC')
            ->get();

        $labels = [];
        $values = [];

        foreach ($transaksiPerBulan as $transaksi) {
            $blthConvert = $transaksi->month . $transaksi->year;
            $labels[] = $this->formatBlth($blthConvert);
            $values[] = $transaksi->total_produksi;
        }

        return view('transaksi.index', compact('totalKapasitasProduksi', 'transaksismonth', 'transaksis', 'labels', 'values', 'listBlth', 'blth', 'bulanIni', 'judulBulanIni'));
    }

    public function filterByBlt(Request $request)
    {
        $bulanIni = date('mY');
        $blth = $request->input('blth', $bulanIni);
        $judulTanggal = $this->formatBlth($blth);
        $jumlahSumber = Sumber::count();
        $transaksismonth= Transaksi1::where('blth', $blth)->with('sumber')->get();
        $totalKapasitasProduksi = $transaksismonth->sum('kapasitas_produksi');
        $transaksiPerBulan = Transaksi1::select(
            DB::raw("SUBSTR(blth, 1, 2) AS month"),
            DB::raw("SUBSTR(blth, 3, 4) AS year"),
            DB::raw("SUM(kapasitas_produksi) AS total_produksi")
        )
            ->where('blth', $blth)
            ->groupBy(DB::raw("SUBSTR(blth, 1, 2)"), DB::raw("SUBSTR(blth, 3, 4)"))
            ->orderBy(DB::raw("SUBSTR(blth, 3, 4)"), 'ASC')
            ->orderBy(DB::raw("SUBSTR(blth, 1, 2)"), 'ASC')
            ->get();

        $labels = [];
        $values = [];

        foreach ($transaksiPerBulan as $transaksi) {
            $blth1 = $transaksi->month . $transaksi->year;
            $labels[] = $this->formatBlthToLabel($blth1);
            $values[] = $transaksi->total_produksi;
        }

        // Get list of available blth for the dropdown
        $listBlth = Transaksi1::select('blth')->distinct()->pluck('blth');


        return view('transaksi.index', compact('totalKapasitasProduksi', 'transaksismonth', 'labels', 'values', 'blth', 'listBlth', 'jumlahSumber', 'judulTanggal'));
    }

    public function totalKapasitasProduksiBulanIni()
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->format('m'); 
        $currentYear = Carbon::now()->format('Y');  
        // Mengambil blth dalam format 'mY'
        $blth = $currentMonth . substr($currentYear, 0); 

        // Menghitung total kapasitas produksi bulan ini
        $totalKapasitasProduksi = Transaksi1::where('blth', $blth)->sum('kapasitas_produksi');

        return $totalKapasitasProduksi;
    }

    private function formatBlth($blth)
    {
        $month = substr($blth, 0, 2);
        $year = '20' . substr($blth, 4, 5);

        $months = [
            '01' => ' Januari',
            '02' => ' Februari',
            '03' => ' Maret',
            '04' => ' April',
            '05' => ' Mei',
            '06' => ' Juni',
            '07' => ' Juli',
            '08' => ' Agustus',
            '09' => ' September',
            '10' => ' Oktober',
            '11' => ' November',
            '12' => ' Desember'
        ];

        $monthName = $months[$month] ?? $month;

        return "{$monthName} {$year}";
    }

    private function formatBlthToLabel($blth)
    {
        $month = substr($blth, 0, 2); // Mengambil dua digit pertama sebagai bulan
        $year = '20' . substr($blth, 4, 5); // Mengambil dua digit berikutnya sebagai tahun dan menambahkan '20' di depannya

        // Daftar nama bulan
        $months = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        // Mengubah angka bulan menjadi nama bulan
        $monthName = $months[$month] ?? $month; // Jika bulan tidak ditemukan, gunakan angka bulan

        return "{$monthName} {$year}";
    }


    public function downloadPdf($blth)
    {
        $judul = 'Transaksi' . $this->formatBlth($blth);
        $transaksis = Transaksi1::where('blth', $blth)->with('sumber')->get();
        $totalKapasitasProduksi = $transaksis->sum('kapasitas_produksi');
        $pdf = PDF::loadView('pdf.transaksi', compact('transaksis', 'blth', 'judul', 'totalKapasitasProduksi'));
        return $pdf->download('transaksi-' . $this->formatBlthToLabel($blth) . '.pdf');
    }

    public function downloadExcel($blth)
    {
        return Excel::download(new TransaksiExport($blth), 'transaksi-' . $blth . '.xlsx');
    }

    public function create()
    {

        $blthOptions = [];
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->subMonths($i);
            $blthOptions[] = $date->format('mY');
        }

        $currentBlth = Carbon::now()->format('mY');

        $availSumber = Sumber::where('status', '1')
            ->whereNotIn('kode', function ($query) use ($currentBlth) {
                $query->select('kode')->from('transaksi1')->where('blth', $currentBlth);
            })
            ->get();

        return view('transaksi.create', compact('availSumber', 'blthOptions'));
    }

    public function getSumberByBlth(Request $request)
    {
        $blth = $request->input('blth');

        $sumberList = Sumber::where('status', '1')
            ->whereNotIn('kode', function ($query) use ($blth) {
                $query->select('kode')->from('transaksi1')->where('blth', $blth);
            })
            ->get();

        return response()->json($sumberList);
    }

    public function store(Request $request)
    {
        // Debug data yang diterima
        // dd($request->all());

        $blth = $request->input('blth'); // Pastikan mengambil blth dari request
        $kode = $request->kode;

        $exists = Transaksi1::where('kode', $kode)->where('blth', $blth)->exists();

        if ($exists) {
            return redirect()->route('transaksi.index')->with('error', 'Transaksi sudah ada.');
        }

        $validated = $request->validate([
            'blth' => 'required|string',
            'kode' => 'required|exists:sumber,kode',
            'jam_operasional' => 'required|numeric',
            'liter' => 'required|numeric',
            'produksi' => 'nullable|numeric',
            'distribusi' => 'nullable|numeric',
            'flushing' => 'nullable|numeric',
            'spey' => 'nullable|numeric',
        ]);

        $validated['kapasitas_produksi'] = $validated['jam_operasional'] * $validated['liter'] * 365 * 3.6;

        Transaksi1::create($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }


    public function edit(Transaksi1 $transaksi)
    {
        $sumbers = Sumber::all();
        return view('transaksi.edit', compact('transaksi', 'sumbers'));
    }

    public function update(Request $request, Transaksi1 $transaksi)
    {
        // Validasi input
        $validatedData = $request->validate([
            'blth' => 'string',
            'kode' => 'exists:sumber,kode',
            'jam_operasional' => 'required|numeric',
            'liter' => 'required|numeric',
            'produksi' => 'nullable|numeric',
            'distribusi' => 'nullable|numeric',
            'flushing' => 'nullable|numeric',
            'spey' => 'nullable|numeric',
        ]);


        $validatedData['blth'] = old('blth', $transaksi->blth);
        $validatedData['kode'] = old('kode', $transaksi->kode);


        $validatedData['kapasitas_produksi'] = $validatedData['jam_operasional'] * $validatedData['liter'] * 365 * 3.6;

        // Mengupdate data transaksi
        $transaksi->update($validatedData);

        // Redirect ke halaman utama dengan pesan sukses
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diupdate.');
    }

    public function destroy(Transaksi1 $transaksi)
    {
        $transaksi->delete(); // Menghapus transaksi

        // Redirect ke halaman utama dengan pesan sukses
        return redirect()->route('transaksi.index')->with('error', 'Transaksi berhasil dihapus.');
    }
}
