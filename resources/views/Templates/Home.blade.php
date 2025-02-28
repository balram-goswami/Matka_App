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


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .custom-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .card-header {
        background: white;
        padding: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-header img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .play-btn {
        background: red;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: bold;
    }

    .market-status {
        color: red;
        font-weight: bold;
    }

    .card-footer {
        background: #FFB80C;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
    }

    a {
        text-decoration: none;
    }
</style>

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

<div class="container mt-5">
    @php
    $option = count($optionGame);
    @endphp
    @if($option >= 1)
    <div class="card custom-card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <img src="../themeAssets/img/matka/matka.png" alt="Game Logo">
                <div class="ms-3">
                    <h5 class="mb-0" style="color: #FFC107;">TOSS GAME</h5>
                    <p class="market-status mb-0" style="color: green;">MARKET OPEN</p>
                </div>
            </div>
            <button class="play-btn"><a href="{{ route('optionGameList') }}">PLAY NOW</a></button>
        </div>
        <div class="card-footer">
            <span style="color: black;">Test your luck, make a choice, and claim your reward. Play now!</span>
        </div>
    </div>
    @else
    <div class="card custom-card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <img src="../themeAssets/img/matka/matka.png" alt="Game Logo">
                <div class="ms-3">
                    <h5 class="mb-0" style="color: #FFC107;">TOSS GAME</h5>
                    <p class="market-status mb-0" style="color: green;">Toss Game Coming Soon...</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <span style="color: black;">Test your luck, make a choice, and claim your reward. Play now!</span>
        </div>
    </div>
    @endif
</div>

<div class="container mt-5">
    @foreach($sattaGame as $index => $satta)
    <div class="card custom-card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                @if (isset($satta->post_image))
                <img src="{{ publicPath($satta->post_image) }}" alt="Game Logo">
                @else
                <img src="../themeAssets/img/matka/matka.png" alt="Game Logo">
                @endif
                <div class="ms-3">
                    <h5 class="mb-0" style="color: #FFC107;">{{ $satta->post_title }}</h5>
                    @if($satta['isMorningOpen'] || $satta['isEveningOpen'])
                    <p class="market-status mb-0" style="color: green;">MARKET OPEN</p>
                    @else
                    <p class="market-status mb-0">MARKET CLOSED</p>
                    @endif
                </div>
            </div>
            @if($satta['isMorningOpen'] || $satta['isEveningOpen'])
            <a class="play-btn" href="{{ route('single.post', ['post_type' => $satta->post_type, 'slug' => $satta->post_name]) }}">PLAY NOW</a>
            @endif
        </div>
        @if($satta['isMorningOpen'] || $satta['isEveningOpen'])
        <div class="card-footer">
            <strong style="color: black;">XX</strong>
            <span style="color: black;" id="time-left-{{ $index }}" data-time-left="{{ \Carbon\Carbon::parse($satta['extraFields']['close_time_evening'])->diffInSeconds(now()) }}">
                Loading...
            </span>
        </div>
        @else
        <div class="card-footer">
            <strong style="color: black;">Result: {{ $result->result ?? 'NA' }} {{ $result->slot ?? 'NA' }}</strong>
        </div>
        @endif
    </div>
    @endforeach
</div>

<div class="weekly-best-seller-area py-3">
    <div class="container" style="margin-bottom: 10%;">
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