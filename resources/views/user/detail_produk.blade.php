@extends('user.master')
@section('master')
    @php
        $adaDiskon = $produk->diskon !== null && $produk->diskon > 0;
    @endphp
    <section class="meetings-page" id="meetings">
        <div class="container">
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3 class="d-inline-block d-sm-none">{{ $produk->judul_produk }}</h3>
                            <div class="col-12">
                                <img src="{{ asset($produk->gambar_produk) }}" class="product-image" alt="Product Image">
                            </div>
                            <div class="col-12 product-image-thumbs">
                                <div class="product-image-thumb active"><img src="{{ asset($produk->gambar_produk) }}"
                                        alt="Product Image"></div>
                                @if ($produk->gambarProduk->count())
                                    @foreach ($produk->gambarProduk as $g)
                                        <div class="product-image-thumb"><img src="{{ asset($g->gambar) }}"
                                                alt="Product Image">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h3 class="my-3">{{ $produk->judul_produk }}</h3>
                            <hr>
                            <div class="bg-gray py-2 px-3 mt-4">
                                @if ($adaDiskon)
                                    @php
                                        $hargadiskon = ($produk->harga * $produk->diskon) / 100;
                                        $hargabaru = $produk->harga - $hargadiskon;
                                    @endphp
                                    <h2 class="mb-0">
                                        Rp. {{ number_format($hargabaru, 0, ',', '.') }}
                                    </h2>
                                    <h4 class="text-decoration-line-through text-muted">
                                        Rp. {{ number_format($produk->harga, 0, ',', '.') }}
                                    </h4>
                                @endif
                                @if (!$adaDiskon)
                                    <h2 class="mb-0">
                                        Rp. {{ number_format($produk->harga, 0, ',', '.') }}
                                    </h2>
                                @endif
                                <hr>
                                <h4>Berat</h4>
                                <h4 class="mt-0">
                                    <small>{{ $produk->berat }} Gram</small>
                                </h4>
                            </div>
                            @php
                                $nomor = '6287861416667';
                                $pesan = urlencode(
                                    "Halo Safinda , saya tertarik dengan produk  {$produk->judul_produk}, apakah tersedia?. \n\n http://127.0.0.1:8000/produk/detail/{$produk->id}",
                                );
                            @endphp
                            <div class="mt-4">
                                <a href="https://wa.me/{{ $nomor }}?text={{ $pesan }}">
                                    <div style="width: 100%" class="btn btn-primary btn-lg btn-flat">
                                        <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                        Beli Sekarang
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                    aria-selected="true">Deskripsi</button>
                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                                    aria-selected="false">Ulasan</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <p>
                                    {!! $produk->deskripsi_produk !!}
                                </p>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                @if ($produk->ulasan->count())
                                    @foreach ($produk->ulasan as $ulasan)
                                        <div class="media mb-4 mt-2">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <img src="https://ui-avatars.com/api/?name={{ $ulasan->nama_pengguna }}&background=random"
                                                        class="mr-3 img-fluid rounded-circle"
                                                        style="width: 50px; height: 50px;"
                                                        alt="{{ $ulasan->nama_pengguna }}">
                                                </div>
                                                <div class="media-body col">
                                                    <h6 class="mt-0">{{ $ulasan->nama_pengguna }} . <small
                                                            class="text-muted">{{ $ulasan->created_at->diffForHumans() }}</small>
                                                    </h6>
                                                    <p>{{ $ulasan->komentar }}</p>
                                                    <div class="text-warning">
                                                        @for ($i = 0; $i < $ulasan->rating; $i++)
                                                            <i class="fas fa-star"></i>
                                                        @endfor
                                                    </div>
                                                    <div class="mt-2">
                                                        @foreach ($ulasan->gambarproduk as $item)
                                                            <a href="{{ asset($item->foto_komentar) }}"
                                                                class="popup-image">
                                                                <img src="{{asset($item->foto_komentar) }}"
                                                                    class="img-fluid rounded " alt="Foto Ulasan"
                                                                    style="height 100px;width: 100px; object-fit: cover; ">
                                                            </a>
                                                        @endforeach


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="mt-4">Belum ada ulasan untuk produk ini.</p>
                                    <h5 class="mt-4">Jadilah yang pertama memberikan ulasan "{{ $produk->judul_produk }}"
                                    </h5>
                                @endif
                                <p class="mt-4">Alamat email Anda tidak akan dipublikasikan.
                                </p>

                                <form action="{{ route('produk.komentar', $produk->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mt-4">
                                        <label for="rating">Rating</label>
                                        <select class="form-control @error('rating') is-invalid @enderror" id="rating"
                                            name="rating">
                                            <option value="">Pilih Rating</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('rating') == $i ? 'selected' : '' }}>
                                                    {{ $i }} Bintang
                                                </option>
                                            @endfor
                                        </select>
                                        @error('rating')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div id="fotoContainer">
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama_pengguna">Nama</label>
                                                    <input type="text"
                                                        class="form-control @error('nama_pengguna') is-invalid @enderror"
                                                        id="nama_pengguna" name="nama_pengguna" placeholder="Nama Anda">
                                                    @error('nama_pengguna')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email_pengguna">Email</label>
                                                    <input type="email_pengguna"
                                                        class="form-control @error('email_pengguna') is-invalid @enderror"
                                                        id="email_pengguna" name="email_pengguna"
                                                        placeholder="Email Anda">
                                                    @error('email_pengguna')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="foto_komentar">Foto</label>
                                                    <input type="file"
                                                        class="form-control @error('foto_komentar') is-invalid @enderror"
                                                        id="foto_komentar_0" name="foto_komentar[]"
                                                        onchange="handleFileInput(this)" accept="image/*">
                                                    @error('foto_komentar')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="komentar">Komentar</label>
                                        <textarea class="form-control @error('komentar') is-invalid @enderror" id="komentar" name="komentar"
                                            rows="3">{{ old('komentar') }}</textarea>
                                        @error('komentar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4">Kirim Ulasan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="footer">
            <p>Copyright © 2023 Poliwangi Co., Ltd. All Rights Reserved</p>
        </div>
    </section>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.product-image-thumb').on('click', function() {
                var $image_element = $(this).find('img')
                $('.product-image').prop('src', $image_element.attr('src'))
                $('.product-image-thumb.active').removeClass('active')
                $(this).addClass('active')
            })
        })
    </script>
    <script>
        function handleFileInput(input) {
            // Tambah input baru hanya kalau pengguna sudah memilih file
            if (input.files.length === 0) return;

            // Hitung jumlah input yang sudah ada agar id tetap unik
            const index = document.querySelectorAll('#fotoContainer input[type=file]').length;

            // Buat elemen input baru
            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'foto_komentar[]';
            newInput.id = `foto_komentar_${index}`;
            newInput.accept = 'image/*';
            newInput.className = 'form-control mt-3';
            newInput.onchange = function() {
                handleFileInput(this);
            };

            // Bungkus dengan div supaya rapi (Bootstrap grid)
            const wrapper = document.createElement('div');
            wrapper.classList.add('col-md-12', 'form-group');
            wrapper.appendChild(newInput);

            document.getElementById('fotoContainer').appendChild(wrapper);
        }
    </script>
@endpush
