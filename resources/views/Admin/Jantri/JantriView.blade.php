<style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .highlight {
            background-color: yellow;
            font-weight: bold;
        }
        .highest-bid {
            background-color: red;
            color: white;
            font-weight: bold;
        }
    </style>

<h2 align="center">Jantri View - Satta Game</h2>

<!-- Dropdown to Select Game -->
<form method="GET" action="{{ route('jantri.view') }}" style="text-align:center; margin-bottom: 20px;">

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-email">Select Game</label>
        <div class="col-sm-10">
            <div class="input-group input-group-merge">
                <select name="game_id" id="game_id" onchange="this.form.submit()" class="form-control">
                    <option value="">Select Game</option>
                    @foreach ($games as $id)
                    <option value="{{ $id->post_id}}">Game {{$id->post_title}} </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</form>

<!-- Jantri Table -->
<table>
        <tr>
            <th>Number</th>
            <th>Total Bid Amount</th>
        </tr>

        @php
            $totalBidAmount = 0;
            $maxBidAmount = $jantriData->max('total_amount') ?? 0; // Get highest bid amount
        @endphp

        @for ($i = 0; $i < 100; $i++)
            @php
                $amount = isset($jantriData[$i]) ? $jantriData[$i]->total_amount : 0;
                $totalBidAmount += $amount;
            @endphp
            <tr class="{{ isset($jantriData[$i]) ? 'highlight' : '' }}">
                <td>{{ $i }}</td>
                <td class="{{ $amount == $maxBidAmount ? 'highest-bid' : '' }}">
                    {{ $amount > 0 ? number_format($amount, 2) : '00' }}
                </td>
            </tr>
        @endfor

        <!-- Total Bid Amount Row -->
        <tr>
            <th>Total</th>
            <th>{{ number_format($totalBidAmount, 2) }}</th>
        </tr>
    </table>