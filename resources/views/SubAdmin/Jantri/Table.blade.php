@if($gameType === 'option')
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
                                <th>Options</th>
                                <th>My Earning (Total: {{ number_format($totalEarnings, 2) }})</th>
                                <th>Loss Amount (Total: {{ number_format($totalLoss, 2) }})</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($jantriData as $data)
                                <tr>
                                    <td>{{ $data->answer }}</td>
                                    <td>{{ number_format($data->total_bid, 2) }}</td>
                                    <td>
                                        @if($data->result_status === 'win')
                                            <span class="badge bg-label-primary me-1" style="color: #f41010 !important">
                                                {{ number_format($data->total_win, 2) }}
                                            </span>
                                        @else
                                            <span class="badge bg-label-primary me-1">00</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@else
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
                        $gameValue = $gameResult->result ?? 0;
                        $bidResult = ($gameValue % 2 === 0) ? 'EVEN' : 'ODD';

                        $oddTotalBid = $jantriData->where('answer', 'ODD')->sum('total_bid');
                        $evenTotalBid = $jantriData->where('answer', 'EVEN')->sum('total_bid');

                        $oddTotalWin = $jantriData->where('answer', 'ODD')->sum('total_win');
                        $evenTotalWin = $jantriData->where('answer', 'EVEN')->sum('total_win');
                    @endphp
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Numbers</th>
                                <th>My Earning (Total: {{ number_format($totalEarnings, 2) }})</th>
                                <th>Loss Amount (Total: {{ number_format($totalLoss, 2) }})</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @for ($i = 0; $i < 100; $i++)
                                @php
                                    $bid = $jantriData->where('answer', $i)->first();
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ number_format($bid ? $bid->total_bid : 0, 2) }}</td>
                                    <td>
                                        @if($bid && $bid->result_status === 'win')
                                            <span class="badge bg-label-primary me-1" style="color: #f41010 !important">
                                                {{ number_format($bid->total_win, 2) }}
                                            </span>
                                        @else
                                            <span class="badge bg-label-primary me-1">00</span>
                                        @endif
                                    </td>
                                </tr>
                            @endfor

                            <!-- ODD & EVEN Rows -->
                            <tr>
                                <td><strong>ODD</strong></td>
                                <td>{{ number_format($oddTotalBid, 2) }}</td>
                                <td>
                                    @if($bidResult === 'ODD')
                                        <span class="badge bg-label-primary me-1" style="color: #f41010 !important">
                                            {{ number_format($oddTotalWin, 2) }}
                                        </span>
                                    @else
                                        <span class="badge bg-label-primary me-1">00</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td><strong>EVEN</strong></td>
                                <td>{{ number_format($evenTotalBid, 2) }}</td>
                                <td>
                                    @if($bidResult === 'EVEN')
                                        <span class="badge bg-label-primary me-1" style="color: #f41010 !important">
                                            {{ number_format($evenTotalWin, 2) }}
                                        </span>
                                    @else
                                        <span class="badge bg-label-primary me-1">00</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
