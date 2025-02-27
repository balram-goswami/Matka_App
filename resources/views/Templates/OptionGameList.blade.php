<!-- Header Area-->
<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
        <!-- Back Button-->
        <div class="back-button me-2"><a href="{{ route('playerDashboard') }}"><i class="ti ti-arrow-left"></i></a></div>
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
<br><br><br>
<div class="weekly-best-seller-area py-3">
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
            <h6>Toss Games</h6>
        </div>
        <div class="row g-2">
            @if($optionGame->isNotEmpty())
            @foreach($optionGame as $index => $quizgame)
            @if($quizgame['extraFields']['close_date'] >= now()->toDateString())
            <div class="col-12">
                <div class="single-vendor-wrap bg-img p-4 bg-overlay" style="background-image: url('../themeAssets/img/bg-img/16.jpg')">
                    <h6 class="vendor-title text-white">{{ $quizgame->post_title }}</h6>
                    <div class="vendor-info">
                        @php
                        $closeDate = $quizgame['extraFields']['close_date'] ?? null;
                        $currentDate = dateonly();
                        $currentTime = timeonly();
                        $closeTime = $quizgame['extraFields']['close_time'] ?? null;
                        $result = DB::table('game_results')->where('game_id', $quizgame->post_id)->first();
                        @endphp

                        @if($closeDate >= $currentDate)
                        <p class="product-rating text-white"><i class="ti ti-clock"></i>
                            <span id="time-left-{{ $index }}"
                                data-end-time="{{ \Carbon\Carbon::parse($quizgame['extraFields']['close_date'] . ' ' . $quizgame['extraFields']['close_time'])->timestamp }}"
                                data-market-id="market-status-{{ $index }}">
                                Loading...
                            </span>
                        </p>
                        @php
                        // Convert close_date and close_time into a single timestamp
                        $closeDateTime = strtotime($quizgame['extraFields']['close_date'] . ' ' . $quizgame['extraFields']['close_time']);
                        $currentTimestamp = time(); // Current timestamp
                        @endphp

                        @if($closeDateTime >= $currentTimestamp)
                        <div class="ratings lh-1 text-white" id="market-status-{{ $index }}">
                            <i class="ti ti-star-filled"></i> Market <span class="ms-1">( Open )</span>
                        </div>
                        <a class="btn btn-primary btn-sm mt-3" href="{{ route('single.post', ['post_type' => $quizgame->post_type, 'slug' => $quizgame->post_name]) }}">
                            Play Now<i class="ti ti-arrow-right ms-1"></i>
                        </a>
                        @else
                        <div class="ratings lh-1 text-white">
                            <i class="ti ti-star-filled"></i> Market: <span class="ms-1">( Closed )</span>
                        </div>
                        <div class="ratings lh-1 text-white">
                            <i class="ti ti-star-filled"></i> Result: <span class="ms-1"> {{ $result->result ?? 'Waiting for Result' }}</span>
                        </div>
                        @endif
                        @endif
                    </div>
                    <div class="vendor-profile shadow">
                        <figure class="m-0">
                            @if(isset($quizgame->post_image))
                            <img src="{{ publicPath($quizgame->post_image) }}" alt="game">
                            @else
                            <img src="../themeAssets/img/matka/matka.png" alt="game">
                            @endif
                        </figure>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @endif
        </div>
    </div>
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