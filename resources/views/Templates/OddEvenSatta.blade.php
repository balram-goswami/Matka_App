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
            <h6 class="mb-0" style="color: black;">{{ $post->post_title}} Odd/Even Game</h6>
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
                    <a class="btn btn-primary" id="time-left"
                        data-open-time="{{ \Carbon\Carbon::parse($post['extraFields']['open_time'])->format('H:i') }}"
                        data-close-time="{{ \Carbon\Carbon::parse($post['extraFields']['close_time'])->format('H:i') }}"
                        data-current-time="{{ now()->format('H:i') }}">
                        00:00:00
                    </a>
                </div>
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h6>Win Rate: {{$user->oddEven_game_rate}}X </h6>
                    <h6>Min Bet Amount: {{$betPrice['oddevenGameMin'] ?? 'NA'}} </h6>
                </div>

                <div class="card-body d-flex align-items-center justify-content-between">
                    <form action="{{ route('optionGameEntry') }}" method="POST">
                        @csrf
                        <div class="input-group row">
                            <!-- Answer Input -->
                            <div class="col-md-6 col-6">
                                <input type="text" name="user_id" value="{{ $user->user_id }}" hidden>
                                <input type="text" name="game_id" value="{{ $post->post_id }}" hidden>

                                <input type="text" name="adminrate" value="{{ $parentDetails->oddEven_game_rate }}" hidden>
                                <input type="text" name="subadmincommission" value="{{ $parentDetails->oddEven_commission }}" hidden>
                                <input type="text" name="userrate" value="{{ $user->oddEven_game_rate }}" hidden>
                                <input type="text" name="usercommission" value="{{ $user->oddEven_commission }}" hidden>

                                <input type="text" name="harf_digit" value="oddEven" hidden>
                                <select class="form-control border mb-1" id="answer" name="answer" required>
                                    <option value="">Select Your Answer</option>
                                    <option value="ODD">ODD</option>
                                    <option value="EVEN">EVEN</option>
                                </select>
                            </div>
                            <!-- Bid Amount Input -->
                            <div class="col-md-6 col-6">
                                @php
                                $balance = $wallet->balance;
                                $availableBalance = $balance - $totalAmount;
                                @endphp
                                <input class="form-control border mb-1" id="bid_amount" name="bid_amount" type="number"
                                    placeholder="Bid Amount" min="{{$betPrice['oddevenGameMin'] ?? '10'}}" max="{{ $betPrice['oddevenGameMax'] ?? $availableBalance }}" step="0.01" required>
                            </div>
                            <!-- Submit Button -->
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
                                <th>Win Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bids as $bid)
                            <tr>
                                <td>{{ $bid->answer }}</td>
                                <td>{{ $bid->bid_amount }}</td>
                                <td>{{ $bid->bid_amount*$user->oddEven_game_rate }}</td>
                                <th scope="row">
                                    <form action="{{ route('deleteBid', ['id' => $bid->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="remove-product"><i
                                                class="ti ti-x"></i></button>
                                    </form>
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
                        <input type="text" name="admin_cut" value="{{ $user->oddEven_game_rate}}" hidden>
                        <input type="text" name="subadmin_cut" value="{{ $user->oddEven_commission}}" hidden>
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

@include('Include.FooterMenu')