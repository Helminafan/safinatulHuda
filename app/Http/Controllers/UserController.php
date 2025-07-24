<?php

namespace App\Http\Controllers;

use App\Models\event;
use App\Models\KomenGambar;
use App\Models\KomentProduk;
use App\Models\prestasi;
use App\Models\vidio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function portoVidio()
    {
        $data = vidio::orderByDesc('created_at')->get();
        return view('user.portoVidio', compact('data'));
    }
    public function dashboard()
    {
        $foto_prestasi = prestasi::orderBy('created_at', 'desc')->take(4)->get();
        return view('user.dashboard', compact('foto_prestasi'));
    }
    public function event()
    {
        $data = event::orderByDesc('created_at')->get();
        $berita = DB::table('event')->select('berita')->first();

        return view('user.meetings', compact('data'));
    }
    public function prestasi()
    {
        $data = prestasi::orderByDesc('created_at')->get();;
        return view('user.prestasi', compact('data'));
    }
    public function blog($id)
    {
        $data = event::find($id);
        $news = event::orderBy('created_at', 'desc')->take(10)->get();
        return view('user.blog', compact('data', 'news'));
    }
    public function produk()
    {
        $produk = \App\Models\Produk::all();

        return view('user.produk', compact('produk'));
    }
    public function detailproduk($id)
    {
        $produk = \App\Models\Produk::with('gambarProduk')->findOrFail($id);
        $komentar = \App\Models\KomentProduk::where('produk_id', $id)->get();
        return view('user.detail_produk', compact('produk', 'komentar'));
    }
    public function create_komentar(Request $request, $id)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'komentar' => 'required|string',
            'email_pengguna' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:0|max:5',
        ]);
        $komentar = new \App\Models\KomentProduk();
        $komentar->produk_id = $id;
        $komentar->nama_pengguna = $request->nama_pengguna;
        $komentar->komentar = $request->komentar;
        $komentar->email_pengguna = $request->email_pengguna;
        $komentar->rating = $request->rating;
        $komentar->is_verified = false; // Default to false, can be updated later
        $komentar->tanggal_komentar = now();

        $komentar->save();

        if ($request->hasFile('foto_komentar')) {
            foreach ($request->file('foto_komentar') as $gambar) {
                if ($gambar && $gambar->isValid()) {
                    $gambarKoment = new KomenGambar();
                    $imageName = time() . '_' . $gambar->getClientOriginalName();
                    $gambar->move(public_path('images/koment'), $imageName);
                    $gambarKoment->foto_komentar = 'images/koment/' . $imageName;
                    $gambarKoment->komen_id = $komentar->id;
                    $gambarKoment->save();
                }
            }
        }



        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
