<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Sumber;
use App\Models\Transaksi1;
use Carbon\Carbon;

class SumberController extends Controller
{
    public function index()
    {
        $sumbers = Sumber::all();
        $totalKapasitasProduksi = DB::table('transaksi1')
            ->join('sumber', 'transaksi1.kode', '=', 'sumber.kode') // Join tabel transaksi1 dengan sumber
            ->select('sumber.nama_sumber', DB::raw('SUM(transaksi1.kapasitas_produksi) as total_produksi'))
            ->groupBy('sumber.nama_sumber')
            ->get();


        return view('sumber.index', compact('sumbers', 'totalKapasitasProduksi'));
    }

    public function create()
    {
        return view('sumber.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sumber' => 'required|string|max:255',
            'kode' => 'required|string|max:8|unique:sumber,kode',
            'status' => 'required|integer'
        ]);

        Sumber::create($request->all());
        return redirect()->route('sumber.index')->with('success', 'Sumber added successfully.');
    }

    public function edit($id)
    {
        $sumber = Sumber::findOrFail($id);
        return view('sumber.edit', compact('sumber'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sumber' => 'required|string|max:255',
            'kode' => 'required|string|max:8|unique:sumber,kode,' . $id,
            'status' => 'required|integer'
        ]);

        $sumber = Sumber::findOrFail($id);
        $sumber->update($request->all());
        return redirect()->route('sumber.index')->with('success', 'Sumber updated successfully.');
    }

    public function changeStatus($id)
    {
        $sumber = Sumber::findOrFail($id);
        $sumber->status = $sumber->status == 1 ? 0 : 1;
        $sumber->save();
        return redirect()->route('sumber.index')->with('success', 'Status updated successfully.');
    }


    public function destroy($id)
    {
        $sumber = Sumber::findOrFail($id);
        $sumber->delete();
        return redirect()->route('sumber.index')->with('error', 'Sumber deleted successfully.');
    }

    public function show(Sumber $sumber)
    {
        // Ambil semua transaksi untuk sumber ini
        $transaksis = Transaksi1::where('kode', $sumber->kode)->get();

        // Hitung kapasitas produksi bulanan
        $bulanProduksi = $transaksis->groupBy(function ($transaksi) {
            return Carbon::createFromFormat('mY', $transaksi->blth)->format('F Y'); // Group by bulan dan tahun
        })->map(function ($month) {
            return $month->sum('kapasitas_produksi');
        });

        // Hitung kapasitas produksi keseluruhan
        $totalKapasitasProduksi = $transaksis->sum('kapasitas_produksi');

        // Hitung kapasitas produksi bulan ini
        $bulanIni = Carbon::now()->format('m') . Carbon::now()->format('Y'); // Format bulan ini sebagai 'mY'
        $kapasitasProduksiBulanIni = $transaksis->where('blth', $bulanIni)->sum('kapasitas_produksi');

        return view('sumber.show', compact('sumber', 'bulanProduksi', 'totalKapasitasProduksi', 'kapasitasProduksiBulanIni', 'transaksis'));
    }

}
