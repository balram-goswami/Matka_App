@include('Include.HeaderMenu')
@php
$news = getPostsByPostType('news', 0, 'new', true);
$gameStatus = getThemeOptions('betSetting');
@endphp

<style>
    .news-ticker {
        display: flex;
        align-items: center;
        width: 100%;
        background: #111;
        color: white;
        padding: 12px 15px;
        font-size: 16px;
        font-weight: 500;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        white-space: nowrap;
    }

    .news-icon {
        font-size: 22px;
        color: #FFC107;
        margin-right: 25px;
        animation: pulse 1.5s infinite alternate;
    }

    .ticker-wrapper {
        flex: 1;
        overflow: hidden;
        position: relative;
    }

    .ticker-content {
        display: inline-block;
        white-space: nowrap;
        animation: scroll 15s linear infinite;
    }

    @keyframes scroll {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(-100%);
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 0.8;
        }

        100% {
            transform: scale(1.1);
            opacity: 1;
        }
    }

    .stripSize {
        margin-top: 3%;
    }

    @media only screen and (max-width: 767px) {
        .stripSize {
            margin-top: 10%;
        }

    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="weekly-best-seller-area py-3 stripSize">
@if($news->count() > 1)
    <div class="container">
        <div class="news-ticker">
            <i class="fa-solid fa-bullhorn news-icon"></i>
            <div class="ticker-wrapper">
                <div class="ticker-content">
                    @foreach($news as $index => $newsItem)
                    <span>{{ $newsItem->post_excerpt }}</span>
                    @if(!$loop->last)
                    <span> || </span>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>


<div class="container">
    <div>
        <!-- Hero Slides-->
        <div class="hero-slides owl-carousel py-3">
            @if(isset($homePage['banner1']))
            <div class="single-hero-slide" style="background-image: url('{{ publicPath($homePage['banner1']) }}')">
                <div class="slide-content h-100 d-flex align-items-center">
                    <div class="slide-text">
                        <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms"
                            data-duration="1000ms">{{ $homePage['bannerText'] ?? '' }}</h4>
                        <p class="text-white" data-animation="fadeInUp" data-delay="400ms"
                            data-duration="1000ms">{{ $homePage['buttonText'] ?? '' }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="single-hero-slide" style="background-image: url('../themeAssets/img/bg-img/1.jpg')">
                <div class="slide-content h-100 d-flex align-items-center">
                    <div class="slide-text">
                        <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-duration="1000ms">Matka App</h4>
                        <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-duration="1000ms">Play Unlimited</p>
                    </div>
                </div>
            </div>
            @endif
            @if(isset($homePage['banner2']))
            <div class="single-hero-slide" style="background-image: url('{{ publicPath($homePage['banner2']) }}')">
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
            @if(isset($homePage['banner3']))
            <div class="single-hero-slide" style="background-image: url('{{ publicPath($homePage['banner3']) }}')">
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
        </div>
    </div>
</div>


<!-- @if(isset($gameStatus['status']) && $gameStatus['status'] === 'on')
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
@endisset -->

<div class="weekly-best-seller-area py-3">
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
            <h6>Toss Games</h6>
        </div>
        <div class="row g-2">
            <div class="col-12">
                <div class="single-vendor-wrap bg-img p-4 bg-overlay" style="background-image: url('../themeAssets/img/bg-img/16.jpg')">
                    @php
                    $option = count($optionGame);
                    @endphp
                    @if($option >= 1)
                    <h6 class="vendor-title text-white">Toss Games</h6>
                    <div class="vendor-info">
                        <p class="mb-1 text-white">
                            <i class="ti ti-map-pin me-1"></i> Toss Games: Choose one option and win big! Test your luck,<br>
                            make a choice, and claim your reward. Play now!
                        </p>
                        <a class="btn btn-primary btn-sm mt-3" href="{{ route('optionGameList') }}">
                            Play Now <i class="ti ti-arrow-right ms-1"></i>
                        </a>
                    </div>
                    @else
                    <h6 class="vendor-title text-white">Toss Game Coming Soon...</h6>
                    @endif
                    <!-- Vendor Profile-->
                    <div class="vendor-profile shadow">
                        <figure class="m-0">
                            <img src="../themeAssets/img/matka/matka.png" alt="game">
                        </figure>
                    </div>
                </div>
            </div>
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