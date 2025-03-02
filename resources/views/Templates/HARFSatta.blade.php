@php
$betPrice = getThemeOptions('betSetting');
@endphp

<!-- Header Area -->
<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
        <!-- Back Button -->
        <div class="back-button me-2">
            <a href="{{ url()->previous() }}"><i class="ti ti-arrow-left"></i></a>
        </div>
        <!-- Page Title -->
        <div class="page-heading">
            <h6 class="mb-0" style="color: black;">{{ $post->post_title}} HARF Game</h6>
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
                    <a class="btn btn-primary" id="time-left" data-time-left="{{ \Carbon\Carbon::parse($post['extraFields']['close_time'])->diffInSeconds(now()) }}">
                        00:00:00
                    </a>
                </div>
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h6>Win Rate: {{$user->harf_game_rate}}X </h6>
                    <h6>Min Bet Amount: {{$betPrice['harfGameMin'] ?? 'NA'}} </h6>
                </div>

                <div class="container mt-3">
                    <!-- Game Title & Timing -->
                    <div class="text-center mb-2">
                        <h5 class="fw-bold">{{ $post->post_title}}</h5>
                        <!-- <p class="text-primary fw-bold">(10:00 am to 10:50 pm)</p> -->
                    </div>

                    <form action="{{ route('harfGameEntry') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                        <input type="hidden" name="game_id" value="{{ $post->post_id }}">

                        <input type="text" name="adminrate" value="{{ $parentDetails->harf_game_rate }}" hidden>
                        <input type="text" name="subadmincommission" value="{{ $parentDetails->harf_commission }}" hidden>
                        <input type="text" name="userrate" value="{{ $user->harf_game_rate }}" hidden>
                        <input type="text" name="usercommission" value="{{ $user->harf_commission }}" hidden>

                        <!-- Ander Table -->
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr class="bg-info text-white">
                                    <th colspan="5">Ander</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="fw-bold bg-light">
                                    @for ($i = 0; $i < 5; $i++) <td>{{ $i }}</td> @endfor
                                </tr>
                                <tr>
                                    @for ($i = 0; $i < 5; $i++)
                                        <td><input type="number" class="form-control text-center bid-input" name="ander[{{ $i }}]" min="{{ $betPrice['harfGameMin'] ?? 0 }}" max="{{ $betPrice['harfGameMax'] ?? $wallet->balance }}" placeholder="Amount"></td>
                                        @endfor
                                </tr>
                                <tr class="fw-bold bg-light">
                                    @for ($i = 5; $i < 10; $i++) <td>{{ $i }}</td> @endfor
                                </tr>
                                <tr>
                                    @for ($i = 5; $i < 10; $i++)
                                        <td><input type="number" class="form-control text-center bid-input" name="ander[{{ $i }}]" min="{{ $betPrice['harfGameMin'] ?? 0 }}" max="{{ $betPrice['harfGameMax'] ?? $wallet->balance }}" placeholder="Amount"></td>
                                        @endfor
                                </tr>
                            </tbody>
                        </table>

                        <!-- bahar Table -->
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr class="bg-info text-white">
                                    <th colspan="5">Bahar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="fw-bold bg-light">
                                    @for ($i = 0; $i < 5; $i++) <td>{{ $i }}</td> @endfor
                                </tr>
                                <tr>
                                    @for ($i = 0; $i < 5; $i++)
                                        <td><input type="number" class="form-control text-center bid-input" name="bahar[{{ $i }}]" min="{{ $betPrice['harfGameMin'] ?? 0 }}" max="{{ $betPrice['harfGameMax'] ?? $wallet->balance }}" placeholder="Amount"></td>
                                        @endfor
                                </tr>
                                <tr class="fw-bold bg-light">
                                    @for ($i = 5; $i < 10; $i++) <td>{{ $i }}</td> @endfor
                                </tr>
                                <tr>
                                    @for ($i = 5; $i < 10; $i++)
                                        <td><input type="number" class="form-control text-center bid-input" name="bahar[{{ $i }}]" min="{{ $betPrice['harfGameMin'] ?? 0 }}" max="{{ $betPrice['harfGameMax'] ?? $wallet->balance }}" placeholder="Amount"></td>
                                        @endfor
                                </tr>
                            </tbody>
                        </table>

                        <!-- Submit Button -->
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Place Bid</button>
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
                                <td>{{$bid->harf_digit}}({{ $bid->answer }})</td>
                                <td>{{ $bid->bid_amount }}</td>
                                <td>{{ $bid->bid_amount*$user->harf_game_rate }}</td>
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
                        <input type="text" name="admin_cut" value="{{ $user->harf_game_rate}}" hidden>
                        <input type="text" name="subadmin_cut" value="{{ $user->harf_commission}}" hidden>
                        @if($wallet->balance >= $totalAmount)
                        <button type="submit" class="btn btn-primary">Submit</button>
                        @else
                        <label class="text-danger mt-2">Insufficient Balance</label>
                        @endif
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

@include('Include.FooterMenu')