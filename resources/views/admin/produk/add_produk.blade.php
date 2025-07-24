@extends('admin.master')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
@endpush
@section('admin')
    <form class="user" method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Data Produk</h6>
                </div>
                <div class="card-body">

                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="judul_produk">Judul produk</label>
                            <input type="text"
                                class="form-control form-control-lg  @error('judul_produk') is-invalid @enderror"
                                id="judul_produk" placeholder="Masukan Judul produk" name="judul_produk">
                            @error('judul_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <br>
                        </div>

                        <div class="col-sm-6">
                            <label for="harga">Harga Produk</label>
                            <input type="text" class="form-control form-control-lg  @error('harga') is-invalid @enderror"
                                id="harga" placeholder="masukan harga" name="harga">
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="harga">Berat Produk</label>
                            <input type="number" class="form-control form-control-lg  @error('berat') is-invalid @enderror"
                                id="berat" placeholder="gram" name="berat">
                            @error('berat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="gambar_produk">Foto Produk</label>
                            <input class="form-control-file " accept="image/*" type="file" id="gambar_produk"
                                name="gambar_produk">
                            @error('gambar_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <br>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-3 mb-sm-0">
                        <label for="deskripsi_produk">Deskripsi Produk</label>
                        <textarea class="form-control  @error('berita') is-invalid @enderror" id="deskripsi_produk" name="deskripsi_produk"
                            rows="3"></textarea>
                    </div>



                </div>
            </div>
            <div class="card mb-3 mb-sm-0">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h1 class="h3 mb-0 text-gray-800">Add Foto Produk</h1>
                        <button type="button" class="btn btn-outline-primary add-more"><i class="bi bi-plus-circle"></i>
                            Add
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="add-more-data">
                        <div class="row mb-3">
                            <input class="form-control-file m-2" accept="image/*" type="file" id="gambar_produk"
                                name="gambar_produk_lain[]">
                            @error('gambar_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
            <button class=" mt-5 btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Produk</span>
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
        $(".add-more").on("click", function() {
            var card =
                '<div class="row mb-3 justify-content-between">' +
                '<div class="col">' +
                '<div class="custom-file">' +
                '<input type="file" accept="image/* class="form-control-file" required name="gambar_produk_lain[]" id="gambar_produk">' +
                "</div>" +
                "</div>" +
                '<div class="co">' +
                '<button class="btn btn-danger delete"> Delete </button>' +
                "</div>" +
                "</div>";
            $(".add-more-data").append(card);
        });

        $(".add-more-data").delegate(".delete", "click", function() {
            $(this).parent().parent().remove();
        });
    </script>
    <script type="text/javascript">
        $("#validate").validate({
            rules: {
                berat: {
                    required: true,
                },
                judul_produk: {
                    required: true,
                },
                gambar_produk: {
                    required: true,
                },
            },
            messages: {
                berat: {
                    required: "Berat tidak boleh kosong",
                },
                judul_produk: {
                    required: "jenis prestasi tidak boleh kosong",
                },
                gambar_produk: {
                    required: "foto prestasi harus ditambahkan",
                },
            },
        });
    </script>
@endpush
