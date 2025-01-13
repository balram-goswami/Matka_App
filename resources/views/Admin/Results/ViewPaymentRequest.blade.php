<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
    <div class="card mb-4">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left">Payment Requests of RS {{ $payment['withdraw_amount']}}</h4>
        </div>
        
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <form method="POST" action="{{ route('withdralRequest') }}" id="withdralRequest">
                    @csrf
                    <div class="row mb-3">
                        <input hidden name="id" value="{{ $payment->id }}">
                        <input hidden name="wallet_id" value="{{ $payment->wallet_id }}">
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">
                                <select name="transaction_type" id="transaction_type" class="form-control" required>
                                    <option value="">Payment Option</option>
                                    <option value="{{ $user->bank_name}}">{{ $user->bank_name}}</option>
                                    <option value="{{ $user->upi_one}}">{{ $user->upi_one}}</option>
                                    <option value="{{ $user->upi_two}}">{{ $user->upi_two}}</option>
                                    <option value="{{ $user->upi_three}}">{{ $user->upi_three}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="utr_number" placeholder="Enter UTR no" required>
                        </div>

                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary">Pay Now</button>
                        </div>
                    </div>
                    <br>
                </form>

            </div>
        </div>
        <br>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12" id="DivIdToPrint">
                    <div class="card">
                        <div class="card-body">
                            <h4>User Details</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $user->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $user->email}}</td>
                                        </tr>
                                        <tr>
                                            <th>Mobile</th>
                                            <td>{{ $user->phone}}</td>
                                        </tr>
                                        <tr>
                                            <th>Bank Name</th>
                                            <td>{{ $user->bank_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Account Holder Name</th>
                                            <td>{{ $user->ac_holder_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>AC Number</th>
                                            <td>{{ $user->ac_number}}</td>
                                        </tr>
                                        <tr>
                                            <th>IFSC Code</th>
                                            <td>{{ $user->ifsc_code}}</td>
                                        </tr>
                                        <tr>
                                            <th>UPI's</th>
                                            <td>{{ $user->upi_one}}, {{ $user->upi_two}}, {{ $user->upi_three}}</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>