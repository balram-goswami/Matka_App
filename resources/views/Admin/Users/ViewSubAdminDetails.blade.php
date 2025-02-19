<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a class="btn btn-primary" href="{{ route('users.index')}}">Back</a>
        </div>
        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="fw-bold py-3 mb-0 pull-left">Sub Admin Details</h4>
            <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addMoney">
                Credit Balance
            </button>
            <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#deleteMoney">
                Debit Balance
            </button>
        </div>
        <div class="mt-4">
            <div class="modal fade" id="addMoney" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMoneyTitle">Credit Balance</h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form method="post" action="{{ route('addbalancebyadmin') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-6">
                                        <label for="nameWithTitle" class="form-label">Enter Amount</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="balance"
                                            placeholder="Enter Amount" />
                                        <input
                                            hidden
                                            name="user_id"
                                            value="{{ $user->user_id }}"
                                            placeholder="Enter Amount" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">Credit Balance Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteMoney" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteMoneyTitle">Debit Balance</h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form method="post" action="{{ route('deletebalancebyadmin') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-6">
                                        <label for="nameWithTitle" class="form-label">Enter Amount</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="balance"
                                            placeholder="Enter Amount" />
                                        <input
                                            hidden
                                            name="user_id"
                                            value="{{ $user->user_id }}"
                                            placeholder="Enter Amount" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">Debit Balance Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>Sub Admn User Id </th>
                        <th>{{$user->name}} </th>
                    </tr>
                    <tr>
                        <th>Total Balance </th>
                        <th>{{ number_format($user->wallet->balance, 2) }} </th>
                    </tr>
                    <tr>
                        <th>Total Active Players </th>
                        <th>{{ $user->activePlayers->count() }} </th>
                    </tr>
                    <tr>
                        <th>Total Blocked Players </th>
                        <th>{{ $user->blockPlayers->count() }} </th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left">Players List</h4>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>Player Name </th>
                        <th>Wallet Balance </th>
                        <th>Exposer Balance </th>
                        <th>Status </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($players as $list)
                    <td>{{ $list->name }}</td>
                    <td>{{ $list->wallet->balance ?? 'No wallet found' }}</td>
                    <td>{{ $exposer->sum('bid_amount') }}</td>
                    <td>{{ $list->status }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <!-- <a class="dropdown-item" href="{{ route('users.edit', $list->user_id) }}"><i class="bx bx-edit-alt me-1"></i>Edit</a> -->
                                @if($list->status === "Active")
                                <a class="dropdown-item" href="{{ route('blockUserbyadmin', $list->user_id) }}"><i class="bx bx-edit-alt me-1"></i>Block</a>
                                @else
                                <a class="dropdown-item" href="{{ route('blockUserbyadmin', $list->user_id) }}"><i class="bx bx-edit-alt me-1"></i>Active</a>
                                @endif
                                <form action="{{ route('users.destroy', $list->user_id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bx bx-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card">
            <h5 class="card-header">SubAdmin Wallet Transactions</h5>
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
                        @foreach($payment->where('user_id', $user->user_id) as $list)
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


<script>
    function confirmDelete(event) {
        if (!confirm("Are you sure you want to delete this user? This action cannot be undone.")) {
            event.preventDefault(); // Prevent form submission if the user cancels
            return false;
        }
        return true;
    }
</script>