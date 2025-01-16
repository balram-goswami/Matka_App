@php
$payment = getThemeOptions('payment');
@endphp

<!-- Header Area-->
<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
        <!-- Back Button-->
        <div class="back-button me-2"><a href="{{ route('user-dashboard') }}"><i class="ti ti-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
            <h6 class="mb-0">Add Money</h6>
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


<div class="page-content-wrapper">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="rtl-text-right">
                    <h5 class="mb-1">Add Money</h5>
                    <p class="mb-4">Scan the provided QR code to make a payment, and fill in the required details to
                        add money to your account. (Note: Please review all fields before saving.)</p>
                    @if(isset($payment['qrpic']))
                    <img src="{{ publicPath($payment['qrpic'])}}">
                    @endif

                    @if(isset($payment['upiId']))
                    <h5 class="mb-1">UPI ID:- {{ $payment['upiId'] }}</h5>
                    @endif
                </div>
            </div>
        </div>
        <div class="pb-3"></div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="contact-form mt-3">
                    <form action="{{ route('moneyRequest') }}" method="POST">
                        @csrf
                        <input type="text" name="user_id" value="{{ $user->user_id }}" hidden>
                        <input type="text" name="wallet_id" value="{{ $wallet->id }}" hidden>
                        <input class="form-control border mb-3" id="utr_number" name="utr_number" type="text"
                            placeholder="Payment UTR Number">
                        <input class="form-control border mb-3" id="img" type="text" name="diposit_image"
                            placeholder="Enter ScreenShoot">
                            
                        <input class="form-control border mb-3" id="username" type="text" name="remark"
                            placeholder="Remark">
                        <input class="form-control border mb-3" id="deposit_amount" name="deposit_amount"
                            placeholder="Diposited Amount"></input>
                        <button type="submit" class="btn btn-primary btn-lg w-100">Send Request</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="pb-3"></div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="container">
        <!-- Cart Wrapper-->
        <div class="cart-wrapper-area py-3">
            <div class="cart-table card mb-3">
                <div class="table-responsive card-body">
                    <table class="table mb-0">
                        <div class="card">
                            <div class="card-body">
                                <div class="rtl-text-right">
                                    <h5 class="mb-1">Payment Status</h5>
                                </div>
                            </div>
                        </div>
                        <thead>
                            <tr>
                                <th>UTR Number & Deposit Amount</th>
                                <th>Request Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                            <tr>
                                <td><a class="product-title" href="single-product.html">{{ $request->utr_number}}<span
                                            class="mt-1">{{ $request->deposit_amount}}</span></a></td>
                                <td><a class="product-title" href="single-product.html">{{ $request->request_status}}</a></td>
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