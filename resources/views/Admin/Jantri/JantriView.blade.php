<div class="container">
    <h1>Jantri Table</h1>

    <!-- Game Selection -->
    <div class="mb-4">
        <label for="game_id">Select Game:</label>
        <select id="game_id" class="form-select">
            <option value="">-- Select a Game --</option>
            @foreach($games as $game)
            <option value="{{ $game->post_id }}">{{ $game->post_title }}</option>
            @endforeach
        </select>
    </div>

    <!-- Jantri Table -->
    <table class="table table-bordered" id="jantri-table">
        <thead>
            <tr>
                <th>Answer</th>
                <th>Total Bid Amount</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded here -->
        </tbody>
    </table>
</div>

<script>
    document.getElementById('game_id').addEventListener('change', function() {
        const gameId = this.value;
        const tableBody = document.querySelector('#jantri-table tbody');
        tableBody.innerHTML = ''; // Clear table data

        if (gameId) {
            fetch(`/jantri?game_id=${gameId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.answer}</td>
                            <td>${row.total_bid}</td>
                        `;
                        tableBody.appendChild(tr);
                    });
                })
                .catch(error => console.error('Error fetching Jantri data:', error));
        }
    });
</script>