<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left">{{ $players->name }} Details</h4>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>Sub Admn User Id </th>
                        <th>{{ $players->name }} </th>
                    </tr>
                    <tr>
                        <th>Total Balance </th>
                        <th>{{ $players->wallet->balance }} </th>
                    </tr>
                    <tr>
                        <th>Exposer Balance </th>
                        <th>{{ $exposers->sum('subadmin_amount') }} </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left">Players Open Bids</h4>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>Sr. No. </th>
                        <th>Game Name </th>
                        <th>Bid On </th>
                        <th>Bid Amount </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($exposers as $list)
                    @php
                    $gameName = postName($list->game_id);
                    @endphp
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $gameName->post_title ?? 'NA' }}</td>
                    <td>{{ $list->answer }}</td>
                    <td>{{ $list->bid_amount }}</td>
                    <td><button
                            type="button"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#deletebid">
                            Delete This Bid
                        </button>
                        <div class="mt-4">
                            <div class="modal fade" id="deletebid" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('deleteBid', $list->id) }}" method="GET">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col mb-6">
                                                        <label for="deleteReason" class="form-label">
                                                            This option Coming soon....
                                                        </label>
                                                        <label for="deleteReason" class="form-label">
                                                            Please provide a reason for deleting this bid.
                                                        </label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="deleteReason"
                                                            name="delete_reason"
                                                            placeholder="Enter Reason"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Delete Now</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
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