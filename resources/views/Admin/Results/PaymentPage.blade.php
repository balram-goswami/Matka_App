<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="row mb-3 d-flex align-items-end">
            <div class="col">
                <label for="fromDate">From:</label>
                <input type="date" id="fromDate" class="form-control">
            </div>
            <div class="col">
                <label for="toDate">To:</label>
                <input type="date" id="toDate" class="form-control">
            </div>
            <div class="col d-flex">
                <button id="filterBtn" class="btn btn-primary">Filter</button>
            </div>
        </div>
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
                        @foreach($payment->where('user_id', 1) as $list)
                        @php
                        $userName = getUserName($list->tofrom_id);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $list->updated_at}}</td>
                            <td style="color: green;">{{ number_format($list->credit, 2)}}</td>
                            <td style="color: red;">{{ number_format($list->debit, 2)}}</td>
                            <td style="color: green;">{{ $list->balance ?? 'NA'}}</td>
                            <td>{{ $list->remark }} {{$userName}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#filterBtn').click(function() {
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();

            if (!fromDate || !toDate) {
                alert('Please select both dates');
                return;
            }

            let fromDateFormatted = new Date(fromDate);
            let toDateFormatted = new Date(toDate);

            $('.table tbody tr').each(function() {
                let rowDate = $(this).find('td:nth-child(2)').text().trim();
                let rowDateFormatted = new Date(rowDate);

                if (!isNaN(rowDateFormatted) && rowDateFormatted >= fromDateFormatted && rowDateFormatted <= toDateFormatted) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>