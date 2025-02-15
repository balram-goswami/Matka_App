<!-- Header Area -->

<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
        <!-- Back Button -->
        <div class="back-button me-2">
            <a href="{{ route('user-dashboard') }}"><i class="ti ti-arrow-left"></i></a>
        </div>
        <!-- Page Title -->
        <div class="page-heading">
            <h6 class="mb-0">{{ $post->post_title}} Crossing Game</h6>
        </div>
        <!-- Navbar Toggler -->
        <div class="suha-navbar-toggler ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas"
            aria-controls="suhaOffcanvas">
            <div><span></span><span></span><span></span></div>
        </div>
    </div>
</div>

@include('Include.SideMenuOptions')

<div class="page-content-wrapper">
    <div class="container">
        <!-- Cart Wrapper -->
        <div class="cart-wrapper-area py-3">
            <div class="card cart-amount-area">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h5 class="total-price mb-0">Closed In</h5>
                    <a class="btn btn-primary" id="time-left" data-time-left="{{ \Carbon\Carbon::parse($post['extraFields']['close_time_evening'])->diffInSeconds(now()) }}">
                        00:00:00
                    </a>
                </div>

                <div class="card-body d-flex align-items-center justify-content-between">
                    <form action="{{ route('crossingGameEntry') }}" method="POST">
                        @csrf
                        <div class="input-group row">
                            <!-- Answer Input -->
                            <div class="col-md-12 col-12">
                                <input type="text" name="user_id" value="{{ $user->user_id }}" hidden>
                                <input type="text" name="game_id" value="{{ $post->post_id }}" hidden>
                                <label for="numbers">Enter Numbers (comma-separated, e.g., 0,1,2,3,6,9):</label>
                                <input type="text" name="numbers" id="numbers" value="{{ old('numbers') }}" required>
                            </div>
                            <!-- Submit Button -->
                            
                            <label for="numbers" style="color: red">Please review your bids carefully before submitting</label>
                            <div class="col-md-6 col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100">Place Bid</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <!-- Bid Table -->
            <div class="cart-table card mb-3">
                <div class="table-responsive card-body">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Ans</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bids as $bid)
                            <tr>
                                <td>{{ $bid->answer }}</td>
                                <td>{{ $bid->bid_amount }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>Total</td>
                                <td>{{ $totalAmount }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Cancel All and Submit All -->
                <div class="card-body d-flex align-items-center justify-content-between">
                    <form action="{{ route('cancelAllBid', ['game_id' => $post->post_id]) }}" method="POST" id="cancelAllBid">
                        @csrf
                        <button type="submit" class="btn btn-primary">Cancel</button>
                    </form>
                    @if($totalAmount >= $wallet->balance)
                    <a href="{{ route('addMoneyPage') }}" class="btn btn-primary">Add Balance</a>
                    @else
                    <form action="{{ route('submitAllBid') }}" method="POST" id="submitAllBid">
                        @csrf
                        <input type="text" name="user_id" value="{{ $user->user_id }}" hidden>
                        <input type="text" name="game_id" value="{{ $post->post_id }}" hidden>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Timer Script -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const timer = document.getElementById("time-left");

        if (timer) {
            let remainingTime = parseInt(timer.dataset.timeLeft);

            const updateTimer = () => {
                if (remainingTime > 0) {
                    remainingTime--;

                    const hours = Math.floor(remainingTime / 3600);
                    const minutes = Math.floor((remainingTime % 3600) / 60);
                    const seconds = remainingTime % 60;

                    timer.innerText = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                } else {
                    timer.innerText = "Time's up!";
                }
            };

            updateTimer();
            setInterval(updateTimer, 1000);
        }
    });
</script>

@include('Include.FooterMenu')