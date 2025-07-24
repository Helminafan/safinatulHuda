@extends('admin.master')
@section('admin')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Event</h6>
        </div>
        <div class="card-body">
            <form id="validate" class="user" method="POST" action="{{route('produk.diskon.store', $produk->id)}}"  enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-12 mb-3 mb-sm-0">
                        <label for="diskon">Diskon</label>
                        <input type="number" class="form-control form-control-lg  @error('diskon') is-invalid @enderror"
                            id="diskon" placeholder="masukan berapa persen" name="diskon">
                        @error('diskon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <br>
                    </div>
                </div>

                <button class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Diskon</span>
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
        diskon: {
          required: true,
        },
        
       
      },
      messages: {
        diskon: {
          required: "Diskon tidak boleh kosong",
        },
      },
    });
  </script>
@endpush