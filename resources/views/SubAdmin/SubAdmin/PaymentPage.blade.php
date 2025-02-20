<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card">
            <h5 class="card-header">Admin Wallet Transactions</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Date</th>
                            <th>Credit</th>
                            <th>Debit</th>
                            <th>Balance</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($payment as $list)
                        @php
                        $userName = getUserName($list->tofrom_id);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $list->updated_at}}</td>
                            <td>{{ number_format($list->credit, 2)}}</td>
                            <td>{{ number_format($list->debit, 2)}}</td>
                            <td>{{ $list->balance ?? 'NA'}}</td>
                            <td>{{ $list->remark }} {{$userName->name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
