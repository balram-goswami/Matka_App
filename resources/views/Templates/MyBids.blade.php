<!-- Header Area-->
<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
        <!-- Back Button-->
        <div class="back-button me-2"><a href="{{ route('user-dashboard') }}"><i class="ti ti-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
            <h6 class="mb-0">{{ $user->name }}</h6>
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
            <div class="cart-table card mb-3">
                <div class="table-responsive card-body">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bids as $bid)
                                <tr>
                                    <td>{{ $bid->updated_at }}</td>
                                    <td>{{ $bid->game_id }}</td>
                                    <td>{{ $bid->bid_amount }}</td>
                                    @if($bid->answer === $bid->bid_result)
                                        <td style="color: green">
                                            @if($bid->winning_amount == 'pending')
                                            <a href="{{ route('claimAmount', ['bid_id' => $bid->id]) }}">Get Amount</a>
                                            @else
                                            <b>Win</b>
                                            @endif
                                        </td>
                                    @elseif($bid->bid_result == NULL)
                                        <td style="color: yellow">Wait For Result</td>
                                    @else
                                        <td style="color: red">Loss</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Include.FooterMenu')