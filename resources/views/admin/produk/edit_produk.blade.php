@extends('admin.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
@endpush
@section('admin')
    <form class="user" method="POST" action="{{ route('produk.update', $produk->id) }}" enctype="multipart/form-data">
        @csrf


        <div class="container-fluid">

            {{-- ====== CARD: Data Produk ====== --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Edit Data Produk
                    </h6>
                </div>
                <div class="card-body">

                    {{-- Judul --}}
                    <div class="form-group">
                        <label for="judul_produk">Judul Produk</label>
                        <input type="text" id="judul_produk" name="judul_produk"
                            class="form-control @error('judul_produk') is-invalid @enderror"
                            value="{{ old('judul_produk', $produk->judul_produk) }}" placeholder="Masukan Judul Produk">
                        @error('judul_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga Produk</label>
                        <input type="text" id="harga" name="harga"
                            class="form-control @error('harga') is-invalid @enderror"
                            value="{{ old('harga', 'Rp ' . $produk->harga) }}" placeholder="Masukan Harga Produk">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Berat --}}
                    <div class="form-group">
                        <label for="berat">Berat (gram)</label>
                        <input type="number" id="berat" name="berat"
                            class="form-control @error('berat') is-invalid @enderror"
                            value="{{ old('berat', $produk->berat) }}" placeholder="gram">
                        @error('berat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="form-group">
                        <label for="deskripsi_produk">Deskripsi Produk</label>
                        <textarea class="form-control @error('deskripsi_produk') is-invalid @enderror" id="deskripsi_produk"
                            name="deskripsi_produk" rows="3">{{ old('deskripsi_produk', $produk->deskripsi_produk ?? '') }}</textarea>
                        @error('deskripsi_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status (opsional) --}}
                    <div class="form-group">
                        <label for="status_produk">Status Produk</label>
                        <select id="status_produk" name="status_produk" class="form-control">
                            <option value="Aktif"
                                {{ old('status_produk', $produk->status_produk) == 'Aktif' ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="Nonaktif"
                                {{ old('status_produk', $produk->status_produk) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif
                            </option>
                        </select>
                    </div>

                    {{-- Gambar Utama --}}
                    <div class="form-group">
                        <label>Gambar Utama</label><br>
                        @if ($produk->gambar_produk)
                            <img src="{{ asset('storage/'.$produk->gambar_produk) }}" class="img-thumbnail mb-2"
                                style="max-width:150px">
                        @endif
                        <input type="file" accept="image/*" name="gambar_produk"
                            class="form-control-file @error('gambar_produk') is-invalid @enderror">
                        @error('gambar_produk')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- ====== CARD: Gambar Tambahan Lama ====== --}}
            @if ($produk->gambarProduk->count())
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Gambar Tambahan Lama</h6>
                    </div>
                    <div class="card-body">
                        @foreach ($produk->gambarProduk as $g)
                            <div class="row align-items-center mb-3">
                                <div class="col-auto">
                                    <img src="{{ asset('storage/'.$g->gambar) }}" class="img-thumbnail" style="max-width:120px">
                                </div>
                                <div class="col">
                                    <a href="{{ route('produk.gambar.delete', $g->id) }}" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus gambar ini?')">
                                        Hapus
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ====== CARD: Tambah Gambar Tambahan Baru ====== --}}
            <div class="card mb-4">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Gambar Tambahan Baru</h6>
                    <button type="button" class="btn btn-outline-primary add-more">
                        <i class="bi bi-plus-circle"></i> Add
                    </button>
                </div>
                <div class="card-body">
                    <div class="add-more-data">
                        {{-- 1 input awal --}}
                        <div class="row mb-3">
                            <input type="file" accept="image/*" name="gambar_produk_lain[]" class="form-control-file">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Simpan --}}
            <button class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50"><i class="fas fa-save"></i></span>
                <span class="text">Simpan Perubahan</span>
            </button>

        </div>
    </form>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#deskripsi_produk').summernote();
        });
        document.addEventListener("DOMContentLoaded", function() {
            const hargaInput = document.getElementById("harga");

            hargaInput.addEventListener("input", function(e) {
                let value = e.target.value.replace(/[^,\d]/g, "").toString();
                let split = value.split(",");
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }

                rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
                e.target.value = "Rp. " + rupiah;
            });
        });
    </script>
    <script>
        /* === Tambah input gambar dinamis === */

        $('.add-more').on('click', function() {
            const row =
                '<div class="row mb-3 justify-content-between">' +
                '<div class="col">' +
                '<input type="file" accept="image/*" name="gambar_produk_lain[]" class="form-control-file" required>' +
                '</div>' +
                '<div class="col-auto">' +
                '<button class="btn btn-danger delete" type="button">Delete</button>' +
                '</div>' +
                '</div>';
            $('.add-more-data').append(row);
        });
        /* === Hapus input dinamis === */
        $('.add-more-data').on('click', '.delete', function() {
            $(this).closest('.row').remove();
        });
    </script>
@endpush
