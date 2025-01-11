<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left">Admin Users</h4>
            <a class="text-muted float-end" href="{{ route('users.create') }}"><button type="button"
                    class="btn btn-primary">Add New Users</button></a>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-striped yajra-datatable" id="userDatatable">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>name</th>
                            <th>email</th>
                            <th>role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left">Our Players</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-striped yajra-datatable" id="customersDatatable">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>name</th>
                            <th>email</th>
                            <th>role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        $('#userDatatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            columns: [{
                    data: 'photo',
                    name: 'photo'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>

<script>
    jQuery(document).ready(function($) {
        $('#customersDatatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.customers') }}",
            columns: [{
                    data: 'photo',
                    name: 'photo'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>
