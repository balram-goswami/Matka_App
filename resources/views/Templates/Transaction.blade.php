<!-- Header Area-->
<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between rtl-flex-d-row-r">
        <!-- Back Button-->
        <div class="back-button me-2"><a href="{{ route('playerDashboard') }}"><i class="ti ti-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
            <h6 class="mb-0">Transactions</h6>
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
        <div class="row mb-3">
            <div class="col">
                <label for="fromDate">From:</label>
                <input type="date" id="fromDate" class="form-control">
            </div>
            <div class="col">
                <label for="toDate">To:</label>
                <input type="date" id="toDate" class="form-control">
            </div>
            <div class="col">
                <button id="filterBtn" class="btn btn-primary mt-4">Filter</button>
            </div>
        </div>
        <!-- Cart Wrapper-->
        <div class="cart-wrapper-area py-3">
            <div class="cart-table card mb-3">
                <div class="table-responsive card-body">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Date</th>
                                <th>Credit</th>
                                <th>Debit</th>
                                <th>Balance</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $item)
                            @php
                            $userName = getUserName($item->tofrom_id);
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>{{ $item->credit }}</td>
                                <td>{{ $item->debit }}</td>
                                <td>{{ $item->balance }}</td>
                                <td>{{ $item->remark }} {{$userName}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#filterBtn').click(function() {
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();

            if (!fromDate || !toDate) {
                alert('Please select both dates');
                return;
            }

            $('.cart-table tbody tr').each(function() {
                let rowDate = $(this).find('td:nth-child(2)').text().trim();
                let rowDateFormatted = new Date(rowDate);
                let fromDateFormatted = new Date(fromDate);
                let toDateFormatted = new Date(toDate);

                if (rowDateFormatted >= fromDateFormatted && rowDateFormatted <= toDateFormatted) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>


@include('Include.FooterMenu')