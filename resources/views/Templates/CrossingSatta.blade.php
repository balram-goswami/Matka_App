@php
$betPrice = getThemeOptions('betSetting');
@endphp

<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
        <!-- Back Button -->
        <div class="back-button me-2">
            <a href="{{ route('playerDashboard') }}"><i class="ti ti-arrow-left"></i></a>
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
                <h6>Win Rate:- {{$user->admin_cut_crossing}}X </h6>
                <h6>Min Bet Amount:- {{$betPrice['crossingGame']}} </h6>
                </div>

                <div class="card-body d-flex align-items-center justify-content-between">
                    <form action="{{ route('crossingGameEntry') }}" method="POST">
                        @csrf
                        <div class="input-group row">
                            <!-- Answer Input -->
                            <div class="col-md-12 col-12">
                                <input type="text" name="user_id" value="{{ $user->user_id }}" hidden>
                                <input type="text" name="game_id" value="{{ $post->post_id }}" hidden>
                                
                                <input type="text" name="adminshare" value="{{ $parentDetails->admin_cut_crossing }}" hidden>
                                <input type="text" name="subadminshare" value="{{ $parentDetails->user_cut_crossing }}" hidden>
                                <input type="text" name="adminrate" value="{{ $user->admin_cut_crossing }}" hidden>
                                <input type="text" name="subadminrate" value="{{ $user->user_cut_crossing }}" hidden>

                                <label class="text-danger mt-2">Enter Bid Amount</label>
                                <input type="text" name="bid_amount" min="{{ $betPrice['crossingGame'] ?? '100'}}" placeholder="Bid Amount" value="{{ old('bid_amount') }}" required>
                            </div>

                            <!-- Number Buttons -->
                            <div class="col-md-12 mt-3">
                                <div class="btn-group w-100" role="group">
                                    <!-- Buttons for numbers 0-9 -->
                                    <button type="button" class="btn btn-outline-primary number-btn" data-number="0">0</button>
                                    <button type="button" class="btn btn-outline-primary number-btn" data-number="1">1</button>
                                    <button type="button" class="btn btn-outline-primary number-btn" data-number="2">2</button>
                                    <button type="button" class="btn btn-outline-primary number-btn" data-number="3">3</button>
                                    <button type="button" class="btn btn-outline-primary number-btn" data-number="4">4</button>
                                    <button type="button" class="btn btn-outline-primary number-btn" data-number="5">5</button>
                                    <button type="button" class="btn btn-outline-primary number-btn" data-number="6">6</button>
                                    <button type="button" class="btn btn-outline-primary number-btn" data-number="7">7</button>
                                    <button type="button" class="btn btn-outline-primary number-btn" data-number="8">8</button>
                                    <button type="button" class="btn btn-outline-primary number-btn" data-number="9">9</button>
                                </div>
                                <label class="text-danger mt-2">Selections</label>
                                <input type="text" name="numbers" id="numbers" value="{{ old('numbers') }}" required readonly>
                            </div>

                            <!-- Submit Button -->
                            <label class="text-danger mt-2">Please review your bids carefully before submitting</label>
                            <div class="col-md-6 col-12 mt-2">
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
                                <th>Win Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bids as $bid)
                            <tr>
                                <td>{{ $bid->answer }}</td>
                                <td>{{ $bid->bid_amount }}</td>
                                <td>{{ $bid->bid_amount*$user->admin_cut_crossing }}</td>
                                <th scope="row">
                                    <form action="{{ route('deleteBid', ['id' => $bid->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="remove-product"><i
                                                class="ti ti-x"></i></button>
                                        <form>
                                </th>
                            </tr>
                            @endforeach
                            <tr>
                                <td>Total</td>
                                <td>{{ $totalAmount }}</td>
                                <td>{{ $winAmount }}</td>
                                <th scope="row">

                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-body d-flex align-items-center justify-content-between">
                    <form action="{{ route('cancelAllBid', ['game_id' => $post->post_id]) }}" method="POST"
                        id="cancelAllBid">
                        @csrf
                        <button type="submit" class="btn btn-primary">Cancel</button>
                    </form>
                    <form action="{{ route('submitAllBid') }}" method="POST" id="submitAllBid">
                        @csrf
                        <input type="text" name="user_id" value="{{ $user->user_id }}" hidden>
                        <input type="text" name="game_id" value="{{ $post->post_id }}" hidden>
                        <input type="text" name="parent_id" value="{{ $user->parent }}" hidden>
                        <input type="text" name="admin_cut" value="{{ $user->admin_cut_crossing}}" hidden>
                        <input type="text" name="subadmin_cut" value="{{ $user->user_cut_crossing}}" hidden>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selectedNumbers = new Set();
        const inputField = document.getElementById("numbers");
        const buttons = document.querySelectorAll(".number-btn");

        buttons.forEach(button => {
            button.addEventListener("click", function() {
                const number = this.getAttribute("data-number");

                if (selectedNumbers.has(number)) {
                    selectedNumbers.delete(number);
                    this.classList.remove("btn-primary");
                    this.classList.add("btn-outline-primary");
                } else {
                    selectedNumbers.add(number);
                    this.classList.remove("btn-outline-primary");
                    this.classList.add("btn-primary");
                }

                inputField.value = Array.from(selectedNumbers).sort().join(",");
            });
        });
    });
</script>

@include('Include.FooterMenu')