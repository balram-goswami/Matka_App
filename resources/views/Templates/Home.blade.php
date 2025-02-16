@include('Include.HeaderMenu')
@php
$news = getPostsByPostType('news', 0, 'new', true);
$gameStatus = getThemeOptions('betSetting');
@endphp

<style>
    /* News Ticker Container */
    .news-ticker {
        width: 100%;
        background: black;
        color: white;
        padding: 10px 0;
        overflow: hidden;
        white-space: nowrap;
        position: relative;
    }

    /* Scrolling Content */
    .ticker-content {
        display: inline-block;
        white-space: nowrap;
        animation: ticker 15s linear infinite;
    }

    /* Animation for Scrolling Effect */
    @keyframes ticker {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(-100%);
        }
    }

    /* Space between news items */
    .ticker-content p {
        margin-right: 50px;
    }
</style>

<div class="container">
    <div class="page-content-wrapper">
        @if($news->isNotEmpty())
        <div class="news-ticker">
            <div class="ticker-content">
                {{ implode(' || ', $news->pluck('post_excerpt')->toArray()) }}
            </div>
        </div>
        @endif
    </div>
</div>

<div class="container">
    <div>
        <!-- Hero Slides-->
        <div class="hero-slides owl-carousel">
            @foreach(['banner1', 'banner2', 'banner3'] as $banner)
            @if(isset($homePage[$banner]))
            <div class="single-hero-slide" style="background-image: url('{{ publicPath($homePage[$banner]) }}')">
                <div class="slide-content h-100 d-flex align-items-center">
                    <div class="slide-text">
                        <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms"
                            data-duration="1000ms">{{ $homePage['bannerText'] ?? 'Matka App' }}</h4>
                        <p class="text-white" data-animation="fadeInUp" data-delay="400ms"
                            data-duration="1000ms">{{ $homePage['buttonText'] ?? 'Play Unlimited' }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="single-hero-slide" style="background-image: url('../themeAssets/img/bg-img/1.jpg')">
                <div class="slide-content h-100 d-flex align-items-center">
                    <div class="slide-text">
                        <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-duration="1000ms">Amazon Echo</h4>
                        <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-duration="1000ms">3rd Generation, Charcoal</p>
                        <a class="btn btn-primary" href="#" data-animation="fadeInUp" data-delay="800ms" data-duration="1000ms">Buy Now</a>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>


@if(isset($gameStatus['status']) && $gameStatus['status'] === 'on')
<div class="weekly-best-seller-area py-3">
    <div class="container">
        <div class="row g-2 rtl-flex-d-row-r">
            <div class="col-6">
                <div class="select-all-products-btn mt-2">
                    <a class="btn btn-primary btn-lg w-100" href="{{ route('addMoneyPage') }}"><i class="ti ti-circle-check me-1 h6"></i>Diposit</a>
                </div>
            </div>
            <div class="col-6">
                <div class="select-all-products-btn mt-2">
                    <a class="btn btn-primary btn-lg w-100" href="{{ route('withdrawPage') }}"><i class="ti ti-circle-check me-1 h6"></i>Withdraw</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endisset




<div class="weekly-best-seller-area py-3">
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
            <h6>Quiz Games</h6>
        </div>
        <div class="row g-2">
            @foreach($optionGame as $index => $quizgame)
            @if($quizgame['extraFields']['close_date'] >= now()->toDateString())
            <div class="col-12">
                <div class="single-vendor-wrap bg-img p-4 bg-overlay" style="background-image: url('../themeAssets/img/bg-img/16.jpg')">
                    <h6 class="vendor-title text-white">{{ $quizgame->post_title }}</h6>
                    <div class="vendor-info">
                        <p class="mb-1 text-white"><i class="ti ti-map-pin me-1"></i>Game Category: {{ $quizgame->post_type }}</p>
                        @php
                        $closeDate = $quizgame['extraFields']['close_date'] ?? null;
                        $currentDate = dateonly();
                        $closeTime = $quizgame['extraFields']['close_time'] ?? null;
                        @endphp
                        @if($closeDate >= $currentDate)
                        <p class="product-rating text-white"><i class="ti ti-clock"></i>
                            <span id="time-left-{{ $index }}" data-time-left="{{ \Carbon\Carbon::parse($quizgame['extraFields']['close_time'])->diffInSeconds(now()) }}">
                                Loading...
                            </span>
                        </p>
                        <div class="ratings lh-1 text-white"><i class="ti ti-star-filled"></i>Market <span class="ms-1">( Open )</span></div>
                        <a class="btn btn-primary btn-sm mt-3" href="{{ route('single.post', ['post_type' => $quizgame->post_type, 'slug' => $quizgame->post_name]) }}">Play Now<i class="ti ti-arrow-right ms-1"></i></a>
                        @else
                        <div class="ratings lh-1 text-white"><i class="ti ti-star-filled"></i>Market <span class="ms-1">( Closed )</span></div>
                        @php
                        $result = DB::table('game_results')->where('game_id', $quizgame->post_id)->get()->first();
                        @endphp
                        <div class="ratings lh-1 text-white"><i class="ti ti-star-filled"></i>Result <span class="ms-1">:- {{ $result->result ?? 'Waiting for Result' }}</span></div>
                        @endif
                    </div>
                    <!-- Vendor Profile-->
                    <div class="vendor-profile shadow">
                        <figure class="m-0">
                            @if (isset($quizgame->post_image))
                            <img src="{{ publicPath($quizgame->post_image) }}" alt="game">
                            @else
                            <img src="../themeAssets/img/matka/matka.png" alt="game">
                            @endif
                        </figure>
                    </div>
                </div>
            </div>
            @else
            <div class="col-12">
                <div class="single-vendor-wrap bg-img p-4 bg-overlay" style="background-image: url('../themeAssets/img/bg-img/16.jpg')">
                    <h6 class="vendor-title text-white">Option Game Coming Soon...</h6>
                </div>
            </div>
            @endif
            @endforeach
        </div>

    </div>
</div>

<div class="weekly-best-seller-area py-3" style="margin-bottom: 100px;">
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
            <h6>Daily Satta</h6>
        </div>
        <div class="col-12">
    @foreach($sattaGame as $index => $satta)
    <!-- Single Vendor -->
    <div class="single-vendor-wrap bg-img p-4 bg-overlay" style="background-image: url('../themeAssets/img/bg-img/16.jpg')">
        <h6 class="vendor-title text-white">{{ $satta->post_title }}</h6>
        <div class="vendor-info">
            @if($satta['isMorningOpen'] || $satta['isEveningOpen'])
            <p class="mb-1 text-white"><i class="ti ti-clock me-1"></i>Market Status: <span class="text-success">Open</span></p>
            <p class="product-rating text-white">
                <i class="ti ti-clock"></i>
                <span id="time-left-{{ $index }}" data-time-left="{{ \Carbon\Carbon::parse($satta['extraFields']['close_time_evening'])->diffInSeconds(now()) }}">
                    Loading...
                </span>
            </p>
            @else
            <p class="mb-1 text-white"><i class="ti ti-clock me-1"></i>Market Status: <span class="text-danger">Closed</span></p>
            @endif
            
        </div>
        @if($satta['isMorningOpen'] || $satta['isEveningOpen'])
        <a class="btn btn-primary btn-sm mt-3" href="{{ route('single.post', ['post_type' => $satta->post_type, 'slug' => $satta->post_name]) }}">Play<i class="ti ti-arrow-right ms-1"></i></a>
        @endif
        
        <!-- Vendor Profile-->
        <div class="vendor-profile shadow">
            <figure class="m-0">
                @if (isset($satta->post_image))
                <img src="{{ publicPath($satta->post_image) }}" alt="game">
                @else
                <img src="../themeAssets/img/matka/matka.png" alt="game">
                @endif
            </figure>
        </div>
    </div>
    @endforeach
</div>

    </div>
</div>

@include('Include.FooterMenu')

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const timers = document.querySelectorAll("[id^='time-left-']");

        timers.forEach(timer => {
            let remainingTime = parseInt(timer.dataset.timeLeft);

            const updateTimer = () => {
                if (remainingTime > 0) {
                    remainingTime--;

                    // Calculate hours, minutes, and seconds
                    let hours = Math.floor(remainingTime / 3600);
                    let minutes = Math.floor((remainingTime % 3600) / 60);
                    let seconds = remainingTime % 60;

                    // Format time as HH:mm:ss
                    timer.innerText = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                } else {
                    timer.innerText = "Time's up!";
                }
            };

            updateTimer(); // Initialize the timer immediately
            setInterval(updateTimer, 1000);
        });
    });
</script>