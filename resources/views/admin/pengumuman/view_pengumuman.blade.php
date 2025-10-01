@extends('admin.master')
@section('admin')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Pengumuman</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-primary">DataTable Pengumuman</h6>
                    </div>
                    <div class="co"><a href="{{ route('add.pengumuman') }}" class="btn btn-primary"> Tambah Data</a>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Pengumuman</th>
                                <th>Isi Pengumuman</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $item => $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                 
                                    <td>{{$row->judul_pengumuman}}</td>
                                    <td>{{$row->isi_pengumuman}}</td>
                                    <td>
                                        <a href="{{route('edit.pengumuman',$row->id)}}" class="btn btn-warning"> Edit </a>
                                        <a href="{{route('delete.pengumuman',$row->id)}}" id="delete" data-confirm-delete="true" ><button type="button"
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

