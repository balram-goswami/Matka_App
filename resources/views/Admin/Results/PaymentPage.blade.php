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
                        <tr>
                            <td>{{ $userName->name }}</td>
                            <td>{{ $list->utr_number}}</td>
                            <td>{{ $list->remark}}</td>
                            <td>{{ $list->deposit_amount}}</td>
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
                                <span class="badge bg-label-primary me-1">No Action </span>
                                @endif
                            </td>
                        </tr>
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
                        <tr>
                            <td>{{ $userName->name }}</td>
                            <td>{{ $list->utr_number}}</td>
                            <td>{{ $list->remark}}</td>
                            <td>{{ $list->deposit_amount}}</td>
                            <td>
                                @if($list->request_status === 'pending')
                                <span class="badge bg-label-success me-1">Pending</span>
                                @else
                                <span class="badge bg-label-primary me-1">Complete</span>
                                @endif
                            </td>
                            <td>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>