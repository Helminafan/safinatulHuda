<?php

namespace App\Http\Controllers;

use App\Models\event;
use App\Models\pendaftaran;
use App\Models\prestasi;
use App\Models\User;
use App\Models\vidio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function navbar()
    {
        $data = User::all();
        return view('admin.header', compact('data'));
    }
    public function dashboard()
    {
        // Ambil list tahun untuk dropdown
        $year = pendaftaran::select(DB::raw("YEAR(created_at) as tahun"))
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->orderBy(DB::raw("YEAR(created_at)"), 'desc')
            ->pluck('tahun');

        // Tahun yang dipilih di dropdown (default: tahun sekarang)
        $tahunDipilih = request('tahun') ?? now()->year;

        // Data total
        $pendaftar = pendaftaran::count();
        $vidio = vidio::count();
        $event = event::count();
        $prestasi = prestasi::count();

         $datavidio = vidio::select(DB::raw("COUNT(*) as jumlah"))
            ->count();
        $dataevent = event::select(DB::raw("COUNT(*) as jumlah"))
            ->count();
        $dataprestasi = prestasi::select(DB::raw("COUNT(*) as jumlah"))
            ->count();

        // Data pendaftaran bulanan berdasarkan tahun terpilih
        $results = pendaftaran::select(
            DB::raw("YEAR(created_at)  AS tahun"), 
            DB::raw("DATE_FORMAT(MIN(created_at), '%M') AS nama_bulan"),
            DB::raw("MONTH(created_at) AS bulan"),
            DB::raw("COUNT(*) AS daftar")
        )
            ->whereYear('created_at', $tahunDipilih)
            ->groupBy(DB::raw("YEAR(created_at), MONTH(created_at)"))
            ->orderByRaw("MONTH(created_at)")
            ->get();


        return view('admin.dashboard', compact(
            'year',
            'tahunDipilih',
            'datavidio',
            'dataevent',
            'dataprestasi',
            'pendaftar',
            'vidio',
            'event',
            'prestasi',
            'results'
        ));
    }
}
