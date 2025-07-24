<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                   
                    <a href="{{route('dashboard.user')}}" class="logo">
                        <div class="d-flex align-items-center">
                            <img style="width: 50px; height:60px" src="{{asset('user/images/logo-sekolah.png')}}"alt="">
                            SAFINDA 
                        </div>
                        
                        </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li ><a class="{{Request::is('') ? 'active' : '';}}" href="{{route('dashboard.user')}}">Home</a></li>
                        <li><a href="{{route('dashboard.user')}}#about">Tentang</a></li>
                        <li><a class="{{Request::is('prestasi') ? 'active' : '';}}" href="{{url('/prestasi')}}">Prestasi</a></li>
                        <li class="has-sub">
                            <a href="javascript:void(0)" class="{{set_active(['portoVidio','event'])}}">Event</a>
                            <ul class="sub-menu">
                                <li><a href="{{route('event.user')}}">Berita Event</a></li>
                                <li><a href="{{ route('portoVidio.user') }}">Vidio</a></li>
                            </ul>
                        </li>
                        <li class=""><a href="{{route('produk.user')}}">Produk</a></li>
                        <li class=""><a href="{{route('dashboard.user')}}#contact">Contact Us</a></li>
                    </ul>
                    <a class="menu-trigger">
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
