<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left">Voting Game Result </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <form method="POST" action="{{ route('gameResult') }}" id="game_result">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">
                                <select name="game_id" id="gameid" class="form-control">
                                    <option value="">Select Option</option>
                                    @foreach ($numberGame as $choice)
                                    @if (isset($choice['extraFields']['close_date']) && $choice['extraFields']['close_date'] >= dateonly())
                                    <option value="{{ $choice->post_id }}">{{ $choice->post_title }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <select name="result" id="result" class="form-control">
                                <option value="">Select Option</option>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    <br>
                </form>

            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</div>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left">Satta Result </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <form method="POST" action="{{ route('sattaResult') }}" id="satta_result">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">
                                <select name="game_id" id="game_id" class="form-control">
                                    <option value="">Select Game</option>
                                    @foreach ($sattaGame as $satta)
                                    <option value="{{ $satta->post_id }}">{{ $satta->post_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">
                                <select name="slot" id="slot" class="form-control">
                                    <option value="">Select Slot</option>
                                    <option value="morning">Morning</option>
                                    <option value="evening">Evening</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <input name="result" id="result" class="form-control" placeholder="Enter Result"></input>
                        </div>

                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</div>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
    <div class="card mb-4">
        <div class="card">
            <h5 class="card-header">Game Results</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>S.no</th>
                            <th>Game Name</th>
                            <th>Game Slot</th>
                            <th>Result</th>
                            <th>Time of Result</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($results as $result)
                        <tr>
                            <td>{{ $result->id }}</td>
                            <td>{{ $gameNames[$result->game_id] ?? 'Unknown Game' }}</td>
                            <td>{{ $result->slot ?? '-' }}</td>
                            <td>{{ $result->result }}</td>
                            <td>{{ $result->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</div>

<script>
    $(document).ready(function() {
        $('#gameid').change(function() {
            const gameId = $(this).val();
            const resultDropdown = $('#result');
            resultDropdown.empty(); // Clear previous options
            resultDropdown.append('<option value="">Select Option</option>');

            if (gameId) {
                $.ajax({
                    url: "{{ route('gameOptions') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        game_id: gameId
                    },
                    success: function(response) {
                        response.answers.forEach(function(answer) {
                            resultDropdown.append(
                                `<option value="${answer}">${answer}</option>`
                            );
                        });
                    }
                });
            }
        });
    });
</script>