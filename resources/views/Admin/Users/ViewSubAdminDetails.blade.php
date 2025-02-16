<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left">Sub Admin Details</h4>
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
                        <th>Sub Admn Name </th>
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
                                <a class="dropdown-item" href="{{ route('blockUserbyadmin', $list->user_id) }}"><i class="bx bx-edit-alt me-1"></i>Change Status</a>
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

<script>
    function confirmDelete(event) {
        if (!confirm("Are you sure you want to delete this user? This action cannot be undone.")) {
            event.preventDefault(); // Prevent form submission if the user cancels
            return false;
        }
        return true;
    }
</script>