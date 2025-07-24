<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/produk'), $imageName);
            $produk->gambar_produk = 'images/produk/' . $imageName;
        }

        // Simpan produk terlebih dahulu untuk mendapatkan ID
        $produk->save();

        if ($request->hasFile('gambar_produk_lain')) {
            foreach ($request->file('gambar_produk_lain') as $gambar) {
                $gambarProduk = new \App\Models\GambarProduct();
                $imageName = time() . '_' . $gambar->getClientOriginalName();
                $gambar->move(public_path('images/produk'), $imageName);
                $gambarProduk->gambar = 'images/produk/' . $imageName;
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
        // Validate the request data
        $request->validate([
            'judul_produk' => 'required|string|max:255',
            'gambar_produk' => 'nullable|max:2048',
            'deskripsi_produk' => 'nullable|string',
            'harga' => 'required',
            'berat' => 'required|integer',

        ]);
        $harga = preg_replace('/[^\d]/', '', $request->harga);
        // Fetch the product to update
        $produk = \App\Models\Produk::findOrFail($id);
        // Update the product details
        $produk->judul_produk = $request->judul_produk;
        $produk->harga = (int) $harga;
        $produk->deskripsi_produk = $request->deskripsi_produk;
        $produk->berat = $request->berat;
        $produk->status_produk = $request->status_produk;
        // Handle the image upload if provided
        if ($request->hasFile('gambar_produk')) {
            // Delete the old image if it exists
            if ($produk->gambar_produk && file_exists(public_path($produk->gambar_produk))) {
                unlink(public_path($produk->gambar_produk));
            }
            // Upload the new image
            $image = $request->file('gambar_produk');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/produk'), $imageName);
            $produk->gambar_produk = 'images/produk/' . $imageName;
        }
        if ($request->hasFile('gambar_produk_lain')) {
            $gambarLama = \App\Models\GambarProduct::where('produk_id', $produk->id)->get();
            foreach ($gambarLama as $g) {
                if (file_exists(public_path($g->gambar))) {
                    @unlink(public_path($g->gambar));
                }
                $g->delete();
            }
            foreach ($request->file('gambar_produk_lain') as $gambar) {
                $gambarProduk = new \App\Models\GambarProduct();
                $imageName = time() . '_' . $gambar->getClientOriginalName();
                $gambar->move(public_path('images/produk'), $imageName);
                $gambarProduk->gambar = 'images/produk/' . $imageName;
                $gambarProduk->produk_id = $produk->id;
                $gambarProduk->save();
            }
        }
        $produk->save();
        // Redirect to the product index with a success message
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }
    public function destroy($id)
    {
        // Fetch the product to delete
        $produk = \App\Models\Produk::findOrFail($id);
        // Delete the product
        $produk->delete();
        // Redirect to the product index with a success message
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
    public function destroyImage($id)
    {
        $gambar = \App\Models\GambarProduct::findOrFail($id);
        if (file_exists(public_path($gambar->gambar))) {
            @unlink(public_path($gambar->gambar));
        }
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
