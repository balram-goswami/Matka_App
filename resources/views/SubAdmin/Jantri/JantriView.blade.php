<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left">View Jantri </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <form method="POST" action="{{ route('jantrisa.view') }}" id="game_result">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">
                                <select name="game_type" id="game_type" class="form-control">
                                    <option value="">Select Game Type</option>
                                    <option value="1">Toss Game</option>
                                    <option value="2">Satta Game</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 tossGameDiv" style="display: none;">
                            <div class="input-group input-group-merge">
                                <select name="tossGame" id="tossGame" class="form-control">
                                    <option value="">Select Game</option>
                                    @foreach($tossGame as $game)
                                    <option value="{{ $game->post_id }}">{{ $game->post_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 sattaGameDiv" style="display: none;">
                            <div class="input-group input-group-merge">
                                <select name="sattaGame" id="sattaGameType" class="form-control">
                                    <option value="">Select Game</option>
                                    @foreach($sattaGame as $game)
                                    <option value="{{ $game->post_id }}">{{ $game->post_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 sattaGameDiv" style="display: none;">
                            <div class="input-group input-group-merge">
                                <select name="slot" id="slot" class="form-control">
                                    <option value="">Select Game Time</option>
                                    <option value="morning">Morning</option>
                                    <option value="evening">Evening</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 sattaGameDiv" style="display: none;">
                            <div class="input-group input-group-merge">
                                <input class="form-control" name="gamedate" type="date">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary">Get Jantri</button>
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("game_type").addEventListener("change", function() {
        let selectedValue = this.value;
        let tossGameDiv = document.querySelector(".tossGameDiv");
        let sattaGameDivs = document.querySelectorAll(".sattaGameDiv");

        tossGameDiv.style.display = "none";
        sattaGameDivs.forEach(div => div.style.display = "none");

        if (selectedValue === "1") {
            tossGameDiv.style.display = "block";
        } else if (selectedValue === "2") {
            sattaGameDivs.forEach(div => div.style.display = "block");
        }
    });
</script>

<script>
    let sattaGames = @json($sattaGame);

    document.getElementById('sattaGameType').addEventListener('change', function() {
        let selectedGameId = this.value;
        let sattaGameTimeDropdown = document.getElementById('sattaGameTime');

        sattaGameTimeDropdown.innerHTML = '<option value="">Select Game Time</option>'; // Reset dropdown

        let selectedGame = sattaGames.find(game => game.post_id == selectedGameId);
        if (selectedGame && selectedGame.extraFields) {
            if (selectedGame.extraFields.close_time_morning) {
                sattaGameTimeDropdown.innerHTML += `<option value="${selectedGame.extraFields.close_time_morning}">Morning Game</option>`;
            }
            if (selectedGame.extraFields.close_time_evening) {
                sattaGameTimeDropdown.innerHTML += `<option value="${selectedGame.extraFields.close_time_evening}">Evening Game</option>`;
            }
        }
    });
</script>