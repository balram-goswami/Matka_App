@include('Include.HeaderMenu')

<div class="page-content-wrapper">

    <!-- Hero Wrapper -->
    <div class="hero-wrapper">
        <div class="container">
            <div class="pt-3">
                <!-- Hero Slides-->
                <div class="hero-slides owl-carousel">
                    <!-- Single Hero Slide-->
                    @if(isset($homePage['bannerLogo']))
                    <div class="single-hero-slide" style="background-image: url('{{$homePage['bannerLogo']}}')">
                        @else
                        <div class="single-hero-slide" style="background-image: url('../themeAssets/img/bg-img/1.jpg')">
                        @endif
                        <div class="slide-content h-100 d-flex align-items-center">
                            <div class="slide-text">
                                <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms"
                                    data-duration="1000ms">Matka App</h4>
                                <p class="text-white" data-animation="fadeInUp" data-delay="400ms"
                                    data-duration="1000ms">Play Unlimited</p>
                                <!-- <a class="btn btn-primary"
                                    href="#" data-animation="fadeInUp" data-delay="800ms"
                                    data-duration="1000ms">Buy Now</a> -->
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>


    <div class="weekly-best-seller-area py-3">
        <div class="container">
            <div class="row g-2">
                <div class="col-6">
                    <div class="card horizontal-product-card">
                        <div class="d-flex align-items-center">
                            <div class="product-description">
                                <div class="sale-price"><i class="ti ti-arrow-right"></i><a
                                        href="{{ route('addMoneyPage') }}">Diposit</a></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card horizontal-product-card">
                        <div class="d-flex align-items-center">
                            <div class="product-description">
                                <div class="sale-price"><i class="ti ti-arrow-right"></i><a
                                        href="{{ route('withdrawPage') }}">Withdraw</a></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="weekly-best-seller-area py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Quiz Games</h6>
            </div>
            <div class="row g-2">
                @foreach($optionGame as $quizgame)
                <div class="col-12">
                    <div class="card horizontal-product-card">
                        <div class="d-flex align-items-center">
                            <div class="product-thumbnail-side">
                                @if (isset($quizgame->post_image))
                                <a class="product-thumbnail d-block" href="void('0')"><img
                                        src="{{ publicPath($quizgame->post_image) }}" alt="game"></a>
                                @else
                                <a class="product-thumbnail d-block" href="void('0')"><img
                                        src="..\themeAssets\img\matka\matka.png" alt="game"></a>
                                @endif
                            </div>
                            <div class="product-description">
                                <!-- Product Title -->
                                <p class="product-title d-block">{{ $quizgame->post_title }}</p>
                                @php
                                $closeDate = $quizgame['extraFields']['close_date'] ?? null;
                                $currentDate = dateonly();
                                $closeTime = $quizgame['extraFields']['close_time'] ?? null;
                                @endphp

                                @if($closeDate >= $currentDate)
                                <p class="product-rating"><i class="ti ti-clock"></i><span
                                        id="time-left">{{ \Carbon\Carbon::parse($quizgame['extraFields']['close_time'])->diffInSeconds(now()) }}</span>
                                </p>
                                <div class="product-rating"><i class="ti ti-star-filled"></i>Market <span
                                        class="ms-1">( Open )</span></div>
                                <div class="sale-price"><i class="ti ti-arrow-right"></i><a
                                        href="{{ route('single.post', ['post_type' => $quizgame->post_type, 'slug' => $quizgame->post_name]) }}">Play</a>
                                </div>
                                @else
                                <div class="product-rating"><i class="ti ti-star-filled"></i>Market <span
                                        class="ms-1">( Closed )</span></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    <div class="weekly-best-seller-area py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
                <h6>Daily Satta</h6>
            </div>
            <div class="row g-2">
                @foreach($sattaGame as $satta)
                <div class="col-12">
                    <div class="card horizontal-product-card">
                        <div class="d-flex align-items-center">
                            <div class="product-thumbnail-side">
                                @if (isset($satta->post_image))
                                <a class="product-thumbnail d-block" href="void('0')"><img src="{{ publicPath($satta->post_image) }}" alt="game"></a>
                                @else
                                <a class="product-thumbnail d-block" href="void('0')"><img src="..\themeAssets\img\matka\matka.png" alt="game"></a>
                                @endif
                            </div>
                            <div class="product-description">
                                <!-- Product Title -->
                                <p class="product-title d-block">{{ $satta->post_title }}</p>

                                <!-- Check if morning or evening market is open -->
                                @if($satta['isMorningOpen'] || $satta['isEveningOpen'])
                                <p class="product-rating">
                                    <i class="ti ti-clock"></i>
                                    <span id="time-lefts">
                                        {{ \Carbon\Carbon::parse($satta['extraFields']['close_time_evening'])->diffInSeconds(now()) }}
                                    </span>
                                </p>
                                <div class="product-rating">
                                    <i class="ti ti-star-filled"></i>Market <span class="ms-1">( Open )</span>
                                </div>
                                <div class="sale-price">
                                    <i class="ti ti-arrow-right"></i>
                                    <a href="{{ route('single.post', ['post_type' => $satta->post_type, 'slug' => $satta->post_name]) }}">Play</a>
                                </div>
                                @else
                                <div class="product-rating">
                                    <i class="ti ti-star-filled"></i>Market <span class="ms-1">( Closed )</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <br>

    <!-- Dark Mode -->
    <div class="container">
        <div class="dark-mode-wrapper mt-3 bg-img p-4 p-lg-5">
            <p class="text-white">You can change your display to a dark background using a dark mode.</p>
            <div class="form-check form-switch mb-0">
                <label class="form-check-label text-white h6 mb-0" for="darkSwitch">Switch to Dark Mode</label>
                <input class="form-check-input" id="darkSwitch" type="checkbox" role="switch">
            </div>
        </div>
    </div>
    <br>

</div>



@include('Include.FooterMenu')

<script>
    let remainingTime = parseInt(document.getElementById('time-left').innerText);

    const updateTimer = () => {
        if (remainingTime > 0) {
            remainingTime--;

            // Calculate hours, minutes, and seconds
            let hours = Math.floor(remainingTime / 3600); // 3600 seconds in an hour
            let minutes = Math.floor((remainingTime % 3600) / 60); // Remaining minutes
            let seconds = remainingTime % 60; // Remaining seconds

            // Format time as HH:mm:ss
            document.getElementById('time-left').innerText =
                `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        } else {
            document.getElementById('time-left').innerText = "Time's up!";
        }
    };

    setInterval(updateTimer, 1000);
</script>

<script>
    let remainingTime = parseInt(document.getElementById('time-lefts').innerText);

    const updateTimer = () => {
        if (remainingTime > 0) {
            remainingTime--;

            // Calculate hours, minutes, and seconds
            let hours = Math.floor(remainingTime / 3600); // 3600 seconds in an hour
            let minutes = Math.floor((remainingTime % 3600) / 60); // Remaining minutes
            let seconds = remainingTime % 60; // Remaining seconds

            // Format time as HH:mm:ss
            document.getElementById('time-left').innerText =
                `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        } else {
            document.getElementById('time-left').innerText = "Time's up!";
        }
    };

    setInterval(updateTimer, 1000);
</script>