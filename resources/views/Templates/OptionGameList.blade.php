<!-- Header Area-->
<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
        <!-- Back Button-->
        <div class="back-button me-2"><a href="{{ url()->previous() }}"><i class="ti ti-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
            <h6 class="mb-0"></h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas"
            aria-controls="suhaOffcanvas">
            <div><span></span><span></span><span></span></div>
        </div>
    </div>
</div>

@include('Include.SideMenuOptions')
<br>

<div class="container mt-5">
    @php
    $option = count($optionGame);
    @endphp

    @if($option >= 1)
    @foreach($optionGame as $index => $quizgame)
    @php
    $closeDateTime = strtotime($quizgame['extraFields']['close_date'] . ' ' . $quizgame['extraFields']['close_time']);
    $currentTimestamp = time();
    $result = DB::table('game_results')->where('game_id', $quizgame->post_id)->first();
    $marketClosed = $closeDateTime < $currentTimestamp;

        $resultTime=$result ? strtotime($result->created_at) : null;
        $excludeGame = $marketClosed && $result && ($currentTimestamp - $resultTime > 5 * 3600);
        @endphp

        @if(!$excludeGame) 
        <div class="card custom-card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <img src="{{ isset($quizgame->post_image) ? publicPath($quizgame->post_image) : '../themeAssets/img/matka/matka.png' }}" alt="Game Logo">
                    <div class="ms-3">
                        <h5 class="mb-0" style="color:rgb(0, 0, 0);"><b>{{ $quizgame->post_title }}</b></h5>
                        @if(!$marketClosed)
                        <p class="market-status mb-0" style="color: green;">MARKET OPEN</p>
                        @else
                        <p class="market-status mb-0" style="color: red;">MARKET CLOSED</p>
                        <p class="market-status mb-0" style="color: black;">{{ $result->result ?? 'Waiting for Result' }}</p>
                        @endif
                    </div>
                </div>
                @if(!$marketClosed)
                <button class="play-btn">
                    <a href="{{ route('single.post', ['post_type' => $quizgame->post_type, 'slug' => $quizgame->post_name]) }}">PLAY NOW</a>
                </button>
                @endif
            </div>

            @if(!$marketClosed)
            <div class="card-footer">
                <strong style="color: black;"></strong>
                <strong style="color: black;">XX</strong>
                <span style="color: black;" id="time-left-{{ $index }}"
                    data-end-time="{{ \Carbon\Carbon::parse($quizgame['extraFields']['close_date'] . ' ' . $quizgame['extraFields']['close_time'])->timestamp }}"
                    data-market-id="market-status-{{ $index }}">
                    Loading...
                </span>
            </div>
            @else
            <div class="card-footer">
                <strong style="color: black;"></strong>
                <strong style="color: black;">{{ $result->result ?? 'XX' }}</strong>
                <strong style="color: black;"></strong>
            </div>
            @endif
        </div>
        <br>
        @endif
        @endforeach
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

<div class="weekly-best-seller-area py-3">
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll("[id^='time-left-']").forEach(timer => {
            let endTime = parseInt(timer.dataset.endTime);
            let marketStatus = document.getElementById(timer.dataset.marketId);

            if (isNaN(endTime)) return; // Skip invalid timestamps

            let updateTimer = () => {
                let now = Math.floor(Date.now() / 1000);
                let remainingTime = endTime - now;

                if (remainingTime > 0) {
                    let hours = Math.floor(remainingTime / 3600);
                    let minutes = Math.floor((remainingTime % 3600) / 60);
                    let seconds = remainingTime % 60;
                    timer.innerText = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                } else {
                    timer.innerText = "Time's up!";
                    if (marketStatus) {
                        marketStatus.innerHTML = `<i class="ti ti-star-filled"></i> Market: <span class="ms-1">( Closed )</span>`;
                    }
                    clearInterval(interval);
                }
            };

            updateTimer(); // Run immediately
            let interval = setInterval(updateTimer, 1000);
        });
    });
</script>

@include('Include.FooterMenu')