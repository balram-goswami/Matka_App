<!-- Header Area-->
<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
        <!-- Back Button-->
        <div class="back-button me-2"><a href="{{ url()->previous() }}"><i class="ti ti-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
            <h6 class="mb-0">Bids</h6>
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
                                <th>My Bid</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bids as $bid)
                            @php
                            $gameName = postName($bid->game_id);
                            @endphp
                            <tr>
                                <td>{{ $bid->updated_at }}</td>
                                <td>{{ $gameName->post_title }}</td>
                                <td>{{ $bid->answer }}</td>
                                <td>{{ $bid->bid_amount }}</td>
                                @if($bid->result_status === 'claimed')
                                <td style="color: green">Win</td>
                                @elseif($bid->bid_result == NULL)
                                <td style="color: Red">Wait For Result</td>
                                @else
                                <td style="color: red">{{$bid->result_status}}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination mt-3">
                    {{$bids->links()}}
                </div>
            </div>
        </div>
    </div>
</div>

@include('Include.FooterMenu')