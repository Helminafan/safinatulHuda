<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        // Fetch all products from the database
        $produk = \App\Models\Produk::all();
        return view('admin.produk.view_produk', compact('produk'));
    }
    public function create()
    {
        // Return the view to create a new product
        return view('admin.produk.add_produk');
    }
    public function store(Request $request)
    {

        $request->validate([
            'judul_produk' => 'required|string|max:255',
            'gambar_produk' => 'nullable|image|max:2048', // gambar utama
            'gambar_produk_lain.*' => 'nullable|image|max:2048', // multiple images
            'harga' => 'required',
            'deskripsi_produk' => 'nullable|string',
            'berat' => 'required|integer',
        ]);

        $harga = preg_replace('/[^\d]/', '', $request->harga);


        $produk = new \App\Models\Produk();
        $produk->judul_produk = $request->judul_produk;
        $produk->deskripsi_produk = $request->deskripsi_produk;
        $produk->harga = (int) $harga;
        $produk->berat = $request->berat;
        $produk->status_produk = "Aktif";

        // Upload gambar utama jika ada
        if ($request->hasFile('gambar_produk')) {
            $image = $request->file('gambar_produk');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('images/produk', $imageName, 'cpanel_public');
            $produk->gambar_produk = $path;
        }

        // Simpan produk terlebih dahulu untuk mendapatkan ID
        $produk->save();

        if ($request->hasFile('gambar_produk_lain')) {
            foreach ($request->file('gambar_produk_lain') as $gambar) {
                $imageName = time() . '_' . $gambar->getClientOriginalName();
                $path = $gambar->storeAs('images/produk', $imageName, 'cpanel_public');

                $gambarProduk = new \App\Models\GambarProduct();
                $gambarProduk->gambar = $path;
                $gambarProduk->produk_id = $produk->id;
                $gambarProduk->save();
            }
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Ambil data produk berdasarkan ID, termasuk relasi gambar tambahan
        $produk = \App\Models\Produk::with('gambarProduk')->findOrFail($id);
        $produk->harga = number_format($produk->harga, 0, ',', '.');
        // Tampilkan halaman edit dengan data produk
        return view('admin.produk.edit_produk', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'judul_produk' => 'required|string|max:255',
            'gambar_produk' => 'nullable|image|max:2048',
            'gambar_produk_lain.*' => 'nullable|image|max:2048',
            'deskripsi_produk' => 'nullable|string',
            'harga' => 'required',
            'berat' => 'required|integer',
        ]);

        $harga = preg_replace('/[^\d]/', '', $request->harga);

        // Ambil produk
        $produk = \App\Models\Produk::findOrFail($id);

        // Update data produk
        $produk->judul_produk = $request->judul_produk;
        $produk->harga = (int) $harga;
        $produk->deskripsi_produk = $request->deskripsi_produk;
        $produk->berat = $request->berat;
        $produk->status_produk = $request->status_produk;

        // Update gambar utama jika ada
        if ($request->hasFile('gambar_produk')) {
            // Hapus gambar lama
            if ($produk->gambar_produk && Storage::disk('cpanel_public')->exists($produk->gambar_produk)) {
                Storage::disk('cpanel_public')->delete($produk->gambar_produk);
            }

            // Simpan gambar baru
            $image = $request->file('gambar_produk');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('images/produk', $imageName, 'cpanel_public');
            $produk->gambar_produk = $path;
        }

        // Update gambar produk lain jika ada
        if ($request->hasFile('gambar_produk_lain')) {
            // Hapus semua gambar lama
            $gambarLama = \App\Models\GambarProduct::where('produk_id', $produk->id)->get();
            foreach ($gambarLama as $g) {
                if (Storage::disk('cpanel_public')->exists($g->gambar)) {
                    Storage::disk('cpanel_public')->delete($g->gambar);
                }
                $g->delete();
            }

            // Simpan gambar baru
            foreach ($request->file('gambar_produk_lain') as $gambar) {
                $imageName = time() . '_' . $gambar->getClientOriginalName();
                $path = $gambar->storeAs('images/produk', $imageName, 'cpanel_public');

                $gambarProduk = new \App\Models\GambarProduct();
                $gambarProduk->gambar = $path;
                $gambarProduk->produk_id = $produk->id;
                $gambarProduk->save();
            }
        }

        $produk->save();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }
    public function destroy($id)
    {
        // Ambil produk
        $produk = \App\Models\Produk::findOrFail($id);

        // Hapus gambar utama jika ada
        if ($produk->gambar_produk && Storage::disk('cpanel_public')->exists($produk->gambar_produk)) {
            Storage::disk('cpanel_public')->delete($produk->gambar_produk);
        }

        // Hapus semua gambar tambahan
        $gambarLain = \App\Models\GambarProduct::where('produk_id', $produk->id)->get();
        foreach ($gambarLain as $g) {
            if (Storage::disk('cpanel_public')->exists($g->gambar)) {
                Storage::disk('cpanel_public')->delete($g->gambar);
            }
            $g->delete();
        }

        // Hapus produk
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function destroyImage($id)
    {
        $gambar = \App\Models\GambarProduct::findOrFail($id);

        // Hapus file fisik jika ada
        if ($gambar->gambar && Storage::disk('cpanel_public')->exists($gambar->gambar)) {
            Storage::disk('cpanel_public')->delete($gambar->gambar);
        }

        // Hapus data di DB
        $gambar->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
    public function diskon($id)
    {
        $produk = \App\Models\Produk::findOrFail($id);
        return view('admin.produk.diskon_produk', compact('produk'));
    }
    public function storeDiskon(Request $request, $id)
    {
        $request->validate([
            'diskon' => 'required|numeric|min:0|max:100',
        ]);
        $produk = \App\Models\Produk::findOrFail($id);
        $produk->diskon = $request->diskon;
        $produk->save();
        return redirect()->route('produk.index')->with('success', 'Diskon berhasil ditambahkan.');
    }
}
