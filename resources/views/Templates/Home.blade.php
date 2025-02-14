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
        margin-top: -19px;
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
                @endif
            @endforeach
        </div>
    </div>
</div>


@if($gameStatus['status'] === 'on')
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

                            <p class="product-rating"><i class="ti ti-clock"></i>
                                <span id="time-left-{{ $index }}" data-time-left="{{ \Carbon\Carbon::parse($quizgame['extraFields']['close_time'])->diffInSeconds(now()) }}">
                                    Loading...
                                </span>
                            </p>
                            <div class="product-rating"><i class="ti ti-star-filled"></i>Market <span
                                    class="ms-1">( Open )</span></div>
                            <div class="sale-price"><i class="ti ti-arrow-right"></i><a
                                    href="{{ route('single.post', ['post_type' => $quizgame->post_type, 'slug' => $quizgame->post_name]) }}">Play</a>
                            </div>
                            @else
                            <div class="product-rating"><i class="ti ti-star-filled"></i>Market <span
                                    class="ms-1">( Closed )</span></div>
                            @php
                            $result = DB::table('game_results')->where('game_id', $quizgame->post_id)->get()->first();
                            @endphp
                            <div class="product-rating"><i class="ti ti-star-filled"></i>Result <span
                                    class="ms-1">:- {{ $result->result ?? 'Waiting for Result' }}</span></div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="col-12">
                <div class="card horizontal-product-card">
                    <div class="d-flex align-items-center">
                        <div class="product-thumbnail-side">
                            <a class="product-thumbnail d-block" href="void('0')"><img
                                    src="..\themeAssets\img\matka\matka.png" alt="game"></a>

                        </div>
                        <div class="product-description">
                            <!-- Product Title -->
                            <p class="product-title d-block">Option Game Coming Soon...</p>

                        </div>
                    </div>
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
        <div class="row g-2">
            @foreach($sattaGame as $index => $satta)
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
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <h5>{{ $satta->post_title }}</h5>
                                @if($satta['isMorningOpen'] || $satta['isEveningOpen'])
                                <p class="product-rating">
                                    <i class="ti ti-clock"></i>
                                    <span id="time-left-{{ $index }}" data-time-left="{{ \Carbon\Carbon::parse($satta['extraFields']['close_time_evening'])->diffInSeconds(now()) }}">
                                        Loading...
                                    </span>
                                </p>@endif
                            </div>

                            <!-- Check if morning or evening market is open -->
                            @if($satta['isMorningOpen'] || $satta['isEveningOpen'])
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