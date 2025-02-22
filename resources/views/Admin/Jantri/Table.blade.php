<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-header">Jantri Table</h5>
                <h5 class="card-header">Result: {{ $gameResult->result ?? 'Result Not Declared' }}</h5>
            </div>
            <div class="table-responsive text-nowrap">
                @php
                $totalEarnings = $jantriData->sum('total_bid');
                $totalLoss = $jantriData->sum('total_win');
                @endphp
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>{{ $gameType === 'option' ? 'Options' : 'Numbers' }}</th>
                            <th>My Earning (Total: {{ number_format($totalEarnings, 2) }})</th>
                            <th>Loss Amount (Total: {{ number_format($totalLoss, 2) }})</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if($gameType === 'option')
                        @foreach($jantriData as $data)
                        <tr>
                            <td>{{ $data->answer }}</td>
                            <td>{{ number_format($data->total_bid, 2) }}</td>
                            <td>
                                <span class="badge bg-label-primary me-1"
                                    style="color: {{ $data->result_status === 'claimed' ? '#f41010' : '#000' }} !important">
                                    {{ $data->result_status === 'claimed' ? number_format($data->total_win, 2) : '00' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        @for ($i = 0; $i < 100; $i++)
                            @php $bid=$jantriData->where('answer', $i)->first(); @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $bid->total_bid ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-label-primary me-1"
                                        style="color: {{ ($bid && $bid->result_status === 'win') ? '#f41010' : '#000' }} !important">
                                        {{ ($bid && $bid->result_status === 'win') ? number_format($bid->total_win, 2) : '-' }}
                                    </span>
                                </td>
                            </tr>
                            @endfor

                            @php
                            $gameValue = $gameResult->result ?? 0;
                            $bidResult = ($gameValue % 2 === 0) ? 'EVEN' : 'ODD';

                            $oddTotalBid = $jantriData->where('answer', 'ODD')->sum('total_bid');
                            $evenTotalBid = $jantriData->where('answer', 'EVEN')->sum('total_bid');

                            $oddTotalWin = $jantriData->where('answer', 'ODD')->sum('total_win');
                            $evenTotalWin = $jantriData->where('answer', 'EVEN')->sum('total_win');
                            @endphp

                            <tr>
                                <td><strong>ODD</strong></td>
                                <td>{{ number_format($oddTotalBid, 2) }}</td>
                                <td>
                                    <span class="badge bg-label-primary me-1"
                                        style="color: {{ $bidResult === 'ODD' ? '#f41010' : '#000' }} !important">
                                        {{ $bidResult === 'ODD' ? number_format($oddTotalWin, 2) : '00' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>EVEN</strong></td>
                                <td>{{ number_format($evenTotalBid, 2) }}</td>
                                <td>
                                    <span class="badge bg-label-primary me-1"
                                        style="color: {{ $bidResult === 'EVEN' ? '#f41010' : '#000' }} !important">
                                        {{ $bidResult === 'EVEN' ? number_format($evenTotalWin, 2) : '00' }}
                                    </span>
                                </td>
                            </tr>
                            @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

