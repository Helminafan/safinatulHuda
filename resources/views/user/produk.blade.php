@extends('user.master')
@section('master')
    <section class="heading-page header-text" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6>Here are our Produk</h6>
                    <h2>Produk</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="meetings-page" id="meetings">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="work-grid1 konten all">
                                <!-- Work Item -->
                                <div class="container">
                                    <div class="row nail-img row-cols-md-3 g-3">
                                        @foreach ($produk as $row)
                                            @php
                                                $adaDiskon = $row->diskon !== null && $row->diskon > 0;
                                            @endphp
                                            <div class="col work-item thumnail-img">
                                                <div class="card h-100">
                                                    <div class="image-wrapper">
                                                        <a href="{{ route('produk.detail', $row->id) }}">
                                                            <img style="object-fit: cover; height: 400px;"
                                                                src="{{ asset('storage/'.$row->gambar_produk) }}" alt="thumbnail">
                                                        </a>
                                                        @if ($adaDiskon)
                                                            
                                                            <div
                                                                class="badge bg-danger position-absolute top-0 start-0 m-2 fs-6">
                                                                <p style="color: white">Diskon</p>
                                                                 {{ $row->diskon }}%
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="card-body">
                                                        <a href="{{ route('produk.detail', $row->id) }}">
                                                            <h5 style="color: rgb(46, 46, 46); text-decoration: none;"
                                                                class="card-title">
                                                                {{ $row->judul_produk }}
                                                            </h5>
                                                            @if ($adaDiskon)
                                                                @php
                                                                    $hargadiskon = ($row->harga * $row->diskon) / 100;
                                                                    $hargabaru = $row->harga - $hargadiskon;
                                                                @endphp
                                                                <p
                                                                    class="card-text text-decoration-line-through text-muted">
                                                                    Rp. {{ number_format($row->harga, 0, ',', '.') }}
                                                                </p>
                                                                <p class="card-text text-danger fw-bold">
                                                                    Rp. {{ number_format($hargabaru, 0, ',', '.') }}
                                                                </p>
                                                            @else
                                                                <p class="card-text">
                                                                    Rp. {{ number_format($row->harga, 0, ',', '.') }}
                                                                </p>
                                                            @endif
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>



                            </ul>
                        </div>
                        <div class="col-lg-12">
                            <div>
                                <ul class="pagination">
                                    <!-- <li>
                                                            <a href="#" class="next-page"><i class="fa fa-angle-left"></i></a>
                                                          </li>
                                                          <li><a href="#"  class="current-page">1</a></li>
                                                          <li class="active" class="current-page"><a href="#">2</a></li>
                                                          <li><a href="#"class="dots">...</a></li>
                                                          <li  class="current-page"><a href="#">5</a></li>
                                                          <li>
                                                            <a href="#" class="previous-page"><i class="fa fa-angle-right"></i></a>
                                                          </li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="footer">
            <p>Copyright © 2023 Poliwangi Co., Ltd. All Rights Reserved</p>
        </div>
    </section>
@endsection
