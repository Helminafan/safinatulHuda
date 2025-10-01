@extends('admin.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
@endpush
@section('admin')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Produk</h1>
       

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-primary">DataTables Produk</h6>
                    </div>
                    <div class="co"><a href="{{ route('produk.create') }}" class="btn btn-primary"> Tambah Produk</a>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Foto Produk</th>
                                <th>Nama Produk</th>
                                <th>Berat Produk</th>
                                <th>Status Produk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $item => $row)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center"><img src="{{asset('storage/'.$row->gambar_produk)}}"  width="70px" alt=""></td>
                                    <td class="text-center">{{ $row->judul_produk }}</td>
                                    <td class="text-center">{{ $row->berat }}</td>
                                    <td class="text-center">{{ $row->status_produk }}</td>
                                    <td class="text-center">
                                        <a href="{{route('produk.edit',$row->id)}}" class="btn btn-warning"> Edit </a>
                                        <a href="{{route('produk.diskon',$row->id)}}" class="btn btn-info"> Diskon </a>
                                        <a href="{{route('produk.delete',$row->id)}}" id="delete" data-confirm-delete="true"><button type="button"
                                                class="btn btn-danger delete">Hapus</button></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
