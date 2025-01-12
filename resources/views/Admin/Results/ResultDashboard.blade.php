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
                                <select name="game_id" id="game_id" class="form-control">
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

<script>
    $(document).ready(function() {
        $('#game_id').change(function() {
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