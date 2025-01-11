<!-- Header Area-->
<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
        <!-- Back Button-->
        <div class="back-button me-2"><a href="{{ route('user-dashboard') }}"><i class="ti ti-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
            <h6 class="mb-0">Withdraw Money</h6>
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
                    <h5 class="mb-1">Withdraw Money</h5>
                </div>
            </div>
        </div>
        <div class="pb-3"></div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="contact-form mt-3">
                    <form action="{{ route('withdrawMoney') }}" method="POST">
                        @csrf
                        <input type="text" name="user_id" value="{{ $user->user_id }}" hidden>
                        <input type="text" name="wallet_id" value="{{ $wallet->id }}" hidden>
                        <input type="hidden" id="wallet_balance" value="{{ $wallet->balance }}" />

                        <input class="form-control border mb-3" id="withdraw_amount" placeholder="Enter Amount"
                            name="withdraw_amount" oninput="validateWithdrawAmount()" />

                        <span id="error-message" style="color: red; display: none;">Withdraw amount cannot be more
                            than your wallet balance.</span>

                        <button type="submit" id="submit-btn" class="btn btn-primary" disabled>Submit</button>
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
                                <th>Deposit Amount</th>
                                <th>Request Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $request)
                                <tr>
                                    <td><a class="product-title"
                                            href="single-product.html">{{ $request->withdraw_amount }}</a></td>
                                    <td><a class="product-title"
                                            href="single-product.html">{{ $request->request_status }}</a></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function validateWithdrawAmount() {
        const withdrawAmount = parseFloat(document.getElementById('withdraw_amount').value);
        const walletBalance = parseFloat(document.getElementById('wallet_balance').value);
        const errorMessage = document.getElementById('error-message');
        const submitButton = document.getElementById('submit-btn');

        // Check if withdraw amount is greater than the wallet balance
        if (withdrawAmount > walletBalance) {
            errorMessage.style.display = 'block'; // Show error message
            submitButton.disabled = true; // Disable submit button
        } else {
            errorMessage.style.display = 'none'; // Hide error message
            submitButton.disabled = false; // Enable submit button
        }
    }
</script>

@include('Include.FooterMenu')