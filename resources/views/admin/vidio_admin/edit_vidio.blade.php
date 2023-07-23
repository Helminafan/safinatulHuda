@extends('admin.master')
@section('admin')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Vidio</h6>
        </div>
        <div class="card-body">
            <form class="user" method="POST" action="{{route('update.vidio_admin',$vidio->id)}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="judul_vidio">Judul Vidio</label>
                        <input type="text" class="form-control form-control-lg  @error('judul_vidio') is-invalid @enderror"
                            id="judul_vidio" placeholder="Jenis Vidio" name="judul_vidio" value="{{$vidio->judul_vidio}}">
                        @error('judul_vidio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <br>
                    </div>
                    <div class="col-sm-6">
                        <label for="link_vidio">Link Vidio</label>
                        <input type="text"
                            class="form-control form-control-lg  @error('link_vidio') is-invalid @enderror"
                            id="link_vidio" placeholder="Link Vidio" name="link_vidio" value="{{$vidio->link_vidio}}">
                        @error('link_vidio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="Thumbnail">Thumbnail</label>
                        <input class="form-control form-control-lg"  accept="image/*" type="file" name="thumbnail" id="Thumbnail">
                        @error('Thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <br>
                    </div>
                </div>
                <button class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-pen"></i>
                    </span>
                    <span class="text">Edit Vidio</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection