@extends('admin.master')
@section('admin')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Pengumuman</h6>
        </div>
        <div class="card-body">
            <form id="validate" class="user" method="POST" action="{{route('store.pengumuman')}}"  enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-12 mb-3 mb-sm-0">
                        <label for="judul_pengumuman">Judul Pengumuman</label>
                        <input type="text" class="form-control form-control-lg  @error('judul_pengumuman') is-invalid @enderror"
                            id="judul_pengumuman" placeholder="Judul Event" name="judul_pengumuman">
                        @error('judul_pengumuman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <br>
                    </div>
                    <div class="col-sm-12 mb-3 mb-sm-0">
                        <label for="berota">Isi Pengumuman</label>
                        <textarea class="form-control  @error('isi_pengumuman') is-invalid @enderror" id="exampleFormControlTextarea1" name="isi_pengumuman" rows="3"></textarea>
                    </div>
                    
                </div>

                <button class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Pengumuman</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $("#validate").validate({
      
      rules: {
        judul_pengumuman: {
          required: true,
        },
        isi_pengumuman: {
          required: true,
        },
       
      },
      messages: {
        judul_pengumuman: {
          required: "Judul event tidak boleh kosong",
        },
       
        isi_pengumuman: {
          required: "Isi Pengmuman tidak boleh kosong",
        },
      },
    });
  </script>
@endpush