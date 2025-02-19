<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left">Sub Admins</h4>
            <a class="text-muted float-end" href="{{ route('users.create') }}"><button type="button"
                    class="btn btn-primary">Add New Users/Sub Admin</button></a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>User Id </th>
                        <th>Wallet Balance </th>
                        <th>Total players </th>
                        <th>Status </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($users as $user)
                    <td><a class="dropdown-item" href="{{ route('viewSubadmin', $user->user_id) }}">{{ $user->name }}</a></td>
                    <td>{{ number_format($user->wallet->balance, 2) ?? 'No wallet found' }}</td>
                    <td>{{ $user->players->count() }}</td>
                    <td>{{ $user->status }}</td>
                    <td>
                        <div class="dropdown">
                            
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                
                                <a class="dropdown-item" href="{{ route('users.edit', $user->user_id) }}"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                                <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bx bx-trash me-1"></i> Delete
                                    </button>
                                </form>
                                @if($user->status === "Active")
                                <a class="dropdown-item" href="{{ route('blockUserbyadmin', $user->user_id) }}"><i class="bx bx-edit-alt me-1"></i>Block</a>
                                @else
                                <a class="dropdown-item" href="{{ route('blockUserbyadmin', $user->user_id) }}"><i class="bx bx-edit-alt me-1"></i>Active</a>
                                @endif
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