<!-- Header Area-->
<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
        <!-- Back Button-->
        <div class="back-button me-2"><a href="{{ url()->previous() }}"><i class="ti ti-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
            <h6 class="mb-0" style="color: black;">{{ $post->post_title }}</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas"
            aria-controls="suhaOffcanvas">
            <div><span></span><span></span><span></span></div>
        </div>
    </div>
</div>

@include('Include.SideMenuOptions')

<div class="page-content-wrapper">
    <div class="product-catagories-wrapper py-3">
        <div class="container">
            <div class="row g-2 rtl-flex-d-row-r">
                <!-- Catagory Card -->
                <div class="col-6">
                    <div class="card catagory-card" style="background-color: #FFCC00;">
                        <div class="card-body px-2">
                            <a href="{{ route('jodiSatta', ['post_id' => $post->post_id]) }}">
                                @if(isset($post->post_image))
                                <img src="{{ publicPath($post->post_image) }}" alt="">
                                @else
                                <img src="{{ publicPath('..\themeAssets\img\matka\matka.png') }}" alt="">
                                @endif
                                    <span style="color: white;">Jodi</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Catagory Card -->
                <div class="col-6">
                    <div class="card catagory-card" style="background-color: #FFCC00;">
                        <div class="card-body px-2"><a href="{{ route('harfSatta', ['post_id' => $post->post_id]) }}">
                            @if(isset($post->post_image))
                                <img src="{{ publicPath($post->post_image) }}" alt="">
                                @else
                                <img src="{{ publicPath('..\themeAssets\img\matka\matka.png') }}" alt="">
                                @endif
                                    <span style="color: white;">HARF</span></a></div>
                    </div>
                </div>
                <!-- Catagory Card -->
                <div class="col-6">
                    <div class="card catagory-card" style="background-color: #FFCC00;">
                        <div class="card-body px-2"><a href="{{ route('crossingSatta', ['post_id' => $post->post_id]) }}">
                            @if(isset($post->post_image))
                                <img src="{{ publicPath($post->post_image) }}" alt="">
                                @else
                                <img src="{{ publicPath('..\themeAssets\img\matka\matka.png') }}" alt="">
                                @endif
                                    <span style="color: white;">CROSSING</span></a></div>
                    </div>
                </div>
                <!-- Catagory Card -->
                <div class="col-6">
                    <div class="card catagory-card" style="background-color: #FFCC00;">
                        <div class="card-body px-2"><a href="{{ route('oddEvenSatta', ['post_id' => $post->post_id]) }}">
                            @if(isset($post->post_image))
                                <img src="{{ publicPath($post->post_image) }}" alt="">
                                @else
                                <img src="{{ publicPath('..\themeAssets\img\matka\matka.png') }}" alt="">
                                @endif
                                    <span style="color: white;">ODD & EVEN</span></a></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@include('Include.FooterMenu')