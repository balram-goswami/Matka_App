<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card">
            <h5 class="card-header">Deposit Request</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>UTR No.</th>
                            <th>Message</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($payment as $list)
                        @php
                        $userName = getUserName($list->user_id);
                        @endphp
                        @if($list->withdraw_amount == NULL)
                        <tr>
                            <td>{{ $userName->name }}</td>
                            <td>{{ $list->utr_number}}</td>
                            <td>{{ $list->remark}}</td>
                            <td>{{ number_format($list->deposit_amount, 2)}}</td>
                            <td>
                                @if($list->request_status === 'pending')
                                <span class="badge bg-label-success me-1">Pending</span>
                                @else
                                <span class="badge bg-label-primary me-1">Complete</span>
                                @endif
                            </td>
                            <td>
                                @if($list->request_status === 'pending')
                                <a href="{{ route('confermPayment', $list->id) }}">Conferm</a>
                                @else
                                <span class="badge bg-label-primary me-1">No Action Needed</span>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card">
            <h5 class="card-header">Withdral Request</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Wallet Balance</th>
                            <th>Amount</th>
                            <th>Remark</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($payment as $list)
                        @php
                        $userName = getUserName($list->user_id);
                        $walletBalance = DB::table('wallets')->where('user_id', $list->user_id)->get()->first();
                        @endphp

                        @if($list->deposit_amount == NULL)
                        <tr>
                            <td>{{ $userName->name }}</td>
                            <td>{{ $walletBalance->balance }}</td>
                            <td>{{ number_format($list->withdraw_amount, 2)}}</td>
                            <td>{{ $list->remark}}</td>
                            <td>
                                @if($list->request_status === 'pending')
                                <span class="badge bg-label-success me-1">Pending</span>
                                @else
                                <span class="badge bg-label-primary me-1">Complete</span>
                                @endif
                            </td>
                            <td>
                                @if($list->request_status === 'pending')
                                <a href="{{ route('viewPayment', $list->id)}}"> View </a>
                                @else
                                <span class="badge bg-label-primary me-1">Payment Done</span>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>