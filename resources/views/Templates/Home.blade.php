@include('Include.HeaderMenu')
@php
$news = getPostsByPostType('news', 0, 'new', true);
$gameStatus = getThemeOptions('betSetting');
@endphp

<div class="weekly-best-seller-area py-3" style="margin-top: 3rem;">
    @if($news->count() > 0)
    <div class="container">
        <div class="news-ticker">
            <i class="fa-solid fa-bullhorn news-icon"></i>
            <div class="ticker-wrapper">
                <div class="ticker-content">
                    @foreach($news as $newsItem)
                    <span class="ticker-item">{{ $newsItem->post_excerpt }}</span>
                    @endforeach
                    @foreach($news as $newsItem)  <!-- Duplicate to create seamless loop -->
                    <span class="ticker-item">{{ $newsItem->post_excerpt }}</span>
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
                        <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-duration="1000ms"></h4>
                        <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-duration="1000ms"></p>
                    </div>
                </div>
            </div>
            @endif
            @if(isset($homePage['banner2']))
            <div class="single-hero-slide" style="background-image: url('{{ publicPath($homePage['banner2']) }}')">
                <div class="slide-content h-100 d-flex align-items-center">
                    <div class="slide-text">
                        <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms"
                            data-duration="1000ms">{{ $homePage['bannerText'] ?? '' }}</h4>
                        <p class="text-white" data-animation="fadeInUp" data-delay="400ms"
                            data-duration="1000ms">{{ $homePage['buttonText'] ?? '' }}</p>
                    </div>
                </div>
            </div>
            @endif
            @if(isset($homePage['banner3']))
            <div class="single-hero-slide" style="background-image: url('{{ publicPath($homePage['banner3']) }}')">
                <div class="slide-content h-100 d-flex align-items-center">
                    <div class="slide-text">
                        <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms"
                            data-duration="1000ms">{{ $homePage['bannerText'] ?? '' }}</h4>
                        <p class="text-white" data-animation="fadeInUp" data-delay="400ms"
                            data-duration="1000ms">{{ $homePage['buttonText'] ?? '' }}</p>
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

<div class="container mt-5" style="margin-top: 1rem !important;">
    @php
    $option = count($optionGame);
    @endphp
    @if($option >= 1)
    <div class="card custom-card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <img src="../themeAssets/img/matka/matka.png" alt="Game Logo">
                <div class="ms-3">
                    <h5 class="mb-0" style="color:rgb(0, 0, 0);"><b>Toss Game</b></h5>
                    <p class="market-status mb-0" style="color: green;">Market Open</p>
                </div>
            </div>
            <button class="play-btn"><a href="{{ route('optionGameList') }}">Play Now</a></button>
        </div>
        <div class="card-footer">
            <span style="color: black;">Test your luck, make a choice, and claim your reward. Play Now!</span>
        </div>
    </div>
    @else
    <div class="card custom-card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <img src="../themeAssets/img/matka/matka.png" alt="Game Logo">
                <div class="ms-3">
                    <h5 class="mb-0" style="color:rgb(0, 0, 0);"><b>Toss Game</b></h5>
                    <p class="market-status mb-0" style="color: green;">Toss Game Coming Soon...</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <span style="color: black;">Test your luck, make a choice, and claim your reward. Play Now!</span>
        </div>
    </div>
    @endif
</div>

<div class="container mt-5" style="margin-top: 1rem !important;">
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
                    <h5 class="mb-0" style="color:rgb(0, 0, 0);"><b>{{ $satta->post_title }}</b></h5>
                    @if($satta['isOpen'])
                    <p class="market-status mb-0" style="color: green;">Market Open</p>
                    @else
                    <p class="market-status mb-0">Market Closed</p>
                    @endif
                </div>
            </div>

            @if($satta['isOpen'])
            <a class="play-btn" href="{{ route('single.post', ['post_type' => $satta->post_type, 'slug' => $satta->post_name]) }}"
                id="play-btn-{{ $index }}">
                Play Now
            </a>
            @endif
        </div>

        <div class="card-footer" style="color: black;">
            @if($satta['isOpen'])
            <strong>Time Left:</strong>
            <span id="time-left-{{ $index }}"
                data-time-left="{{ $satta['timeLeft'] }}">
                Loading...
            </span>
            @else
            <strong></strong>
            <strong>
                <h4 style="color: black;">{{ $satta['result'] ?? 'XX' }}</h4>
            </strong>
            <strong></strong>
            @endif
        </div>
    </div>
    <br>
    @endforeach
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function startCountdown() {
            document.querySelectorAll('[id^="time-left-"]').forEach(function(element) {
                let timeLeft = parseInt(element.getAttribute("data-time-left"));
                let index = element.id.split('-')[2];
                let playBtn = document.getElementById(`play-btn-${index}`);

                if (timeLeft > 0) {
                    let countdown = setInterval(function() {
                        if (timeLeft <= 0) {
                            element.innerHTML = "Time's Up!";
                            clearInterval(countdown);
                            if (playBtn) {
                                playBtn.classList.add('disabled');
                                playBtn.setAttribute('onclick', 'return false;');
                            }
                            return;
                        }
                        let hours = Math.floor(timeLeft / 3600);
                        let minutes = Math.floor((timeLeft % 3600) / 60);
                        let seconds = timeLeft % 60;
                        element.innerHTML = `${hours}h ${minutes}m ${seconds}s`;
                        timeLeft--;
                    }, 1000);
                } else {
                    element.innerHTML = "Time's Up!";
                    if (playBtn) {
                        playBtn.classList.add('disabled');
                        playBtn.setAttribute('onclick', 'return false;');
                    }
                }
            });
        }

        startCountdown();
    });
</script>


<div class="weekly-best-seller-area py-3">
    <div class="container" style="margin-bottom: 10%;">
    </div>
</div>


@include('Include.FooterMenu')