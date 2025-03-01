@php
$betPrice = getThemeOptions('betSetting');
@endphp

<!-- Header Area-->
<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
        <!-- Back Button-->
        <div class="back-button me-2"><a href="{{ route('playerDashboard') }}"><i class="ti ti-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
            <h6 class="mb-0">{{ $post->post_title }}</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas"
            aria-controls="suhaOffcanvas">
            <div><span></span><span></span><span></span></div>
        </div>
    </div>
</div>

@include('Include.SideMenuOptions')

<div class="page-content-wrapper">
    <div class="container">
        <!-- Cart Wrapper-->
        <div class="cart-wrapper-area py-3">
            <div class="card cart-amount-area">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h5 class="total-price mb-0">Closed In</h5>
                    <a class="btn btn-primary"
                        id="time-left-1"
                        data-end-time="{{ \Carbon\Carbon::parse($post['extraFields']['close_date'] . ' ' .$post['extraFields']['close_time'])->timestamp }}"
                        data-market-id="market-status">
                        --
                    </a>

                </div>
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h6>Win Rate: {{$user->toss_game_rate}}X </h6>
                    <h6>Min Bet Amount: {{$betPrice['choiceGameMin'] ?? 'NA'}} </h6>
                </div>

                <div class="card-body d-flex align-items-center justify-content-between">
                    <form action="{{ route('optionGameEntry') }}" method="POST">
                        @csrf
                        <div class="input-group row">
                            <div class="col-md-6 col-6">
                                <input type="text" name="user_id" value="{{ $user->user_id }}" hidden>
                                <input type="text" name="game_id" value="{{ $post->post_id }}" hidden>

                                <input type="text" name="adminrate" value="{{ $parentDetails->toss_game_rate }}" hidden>
                                <input type="text" name="subadmincommission" value="{{ $parentDetails->toss_game_commission }}" hidden>
                                <input type="text" name="userrate" value="{{ $user->toss_game_rate }}" hidden>
                                <input type="text" name="usercommission" value="{{ $user->toss_game_commission }}" hidden>
                                <select class="form-control border mb-1" id="answer" name="answer" required>
                                    <option value="">Select Your Answer</option>
                                    <option value="{{ $post['extraFields']['answer_one'] }}">
                                        {{ $post['extraFields']['answer_one'] }}
                                    </option>
                                    <option value="{{ $post['extraFields']['answer_two'] }}">
                                        {{ $post['extraFields']['answer_two'] }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 col-6">
                                @php
                                $balance = $wallet->balance;
                                $availableBalance = $balance - $totalAmount;
                                @endphp
                                <input class="form-control border mb-1" id="bid_amount" name="bid_amount" type="number"
                                    placeholder="Bid Amount" min="{{$betPrice['choiceGameMin'] ?? '10'}}" max="{{ $betPrice['choiceGameMax'] ?? $availableBalance }}" step="0.01" required>
                            </div>
                            <br>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-lg w-100">Place Bid</button>
                            </div>
                    </form>
                </div>
            </div>
            <br>
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
                                <td>{{ $bid->bid_amount*$user->toss_game_rate }}</td>
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
                        <input type="text" name="admin_cut" value="{{ $user->toss_game_rate}}" hidden>
                        <input type="text" name="subadmin_cut" value="{{ $user->toss_game_commission}}" hidden>
                        @if($wallet->balance >= $totalAmount)
                        <button type="submit" id="submit-btn" class="btn btn-primary">Submit</button>
                        @else
                        <label class="text-danger mt-2">Insufficient Balance</label>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll("[id^='time-left']").forEach(timer => {
            let endTime = parseInt(timer.dataset.endTime, 10);
            let marketStatus = document.getElementById(timer.dataset.marketId);
            let submitButton = document.getElementById(`submit-btn-${timer.id.split('-').pop()}`);

            if (isNaN(endTime)) return; // Skip if no valid end time

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
                    if (submitButton) {
                        submitButton.style.display = "none"; // Hide submit button
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