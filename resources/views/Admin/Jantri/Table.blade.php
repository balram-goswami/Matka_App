@if($gameType === 'option')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-header">Jantri Table</h5>
                <h5 class="card-header">Jantri Date: {{ $gameResult->result ?? 'Result Not Declared' }}</h5>
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
                                @if($data->result_status === 'claimed')
                                <span class="badge bg-label-primary me-1" style="color: #f41010 !important">
                                    {{ number_format($data->total_win, 2) }}
                                </span>
                                @else
                                <span class="badge bg-label-primary me-1">-</span>
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
                <h5 class="card-header">Result Date: {{ $date }}</h5>
            </div>
            <div class="table-responsive text-nowrap">
                @php
                $totalEarnings = $jantriData->sum('total_bid');
                $totalLoss = $jantriData->sum('total_win');
                @endphp
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Numbers</th>
                            <th>My Earning (Total: {{ number_format($totalEarnings, 2) }})</th>
                            <th>Loss Amount (Total: {{ number_format($totalLoss, 2) }})</th>
                            <th>Result</th>
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
                                    <span class="badge bg-label-secondary me-1">{{ number_format($bid ? $bid->total_win : 0, 2) }}</span>
                                    @endif
                                </td>
                                <td>{{ $bid->bid_result ?? '-' }}</td>
                            </tr>
                            @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-header">Odd Evven Jantri Table</h5>
            </div>
            <div class="table-responsive text-nowrap">
                @php
                $totalEarnings = $jantriOddEven->sum('total_bid');
                $totalLoss = $jantriOddEven->sum('total_win');
                @endphp

                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Type</th>
                            <th>My Earning (Total: {{ number_format($totalEarnings, 2) }})</th>
                            <th>Loss Amount (Total: {{ number_format($totalLoss, 2) }})</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($jantriOddEven as $data)
                        <tr>
                            <td><strong>{{ strtoupper($data->answer) }}</strong></td>
                            <td>{{ number_format($data->total_bid, 2) }}</td>
                            <td>
                                @if($data->result_status === 'claimed')
                                <span class="badge bg-label-danger me-1" style="color: #f41010 !important">
                                    {{ number_format($data->total_win, 2) }}
                                </span>
                                @else
                                <span class="badge bg-label-secondary me-1">{{ number_format($data ? $data->total_win: 0, 2) }}</span>
                                @endif
                            </td>
                            <td>{{ $data->bid_result ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-header">Hurf (Andar) Jantri Table</h5>
            </div>
            <div class="table-responsive text-nowrap">
                @php
                $totalEarnings = $jantriandar->sum('total_bid');
                $totalLoss = $jantriandar->sum('total_win');
                @endphp

                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Answer</th>
                            <th>My Earning (Total: {{ number_format($totalEarnings, 2) }})</th>
                            <th>Loss Amount (Total: {{ number_format($totalLoss, 2) }})</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($jantriandar as $data)
                        <tr>
                            <td><strong>{{ strtoupper($data->answer) }}</strong></td>
                            <td>{{ number_format($data->total_bid, 2) }}</td>
                            <td>
                                @if($data->result_status === 'claimed')
                                <span class="badge bg-label-danger me-1" style="color: #f41010 !important">
                                    {{ number_format($data->total_win, 2) }}
                                </span>
                                @else
                                <span class="badge bg-label-secondary me-1">{{ number_format($data ? $data->total_win: 0, 2) }}</span>
                                @endif
                            </td>
                            <td>{{ $data->bid_result ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-header">Hurf (Bahar) Jantri Table</h5>
            </div>
            <div class="table-responsive text-nowrap">
                @php
                $totalEarnings = $jantribahar->sum('total_bid');
                $totalLoss = $jantribahar->sum('total_win');
                @endphp

                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Answer</th>
                            <th>My Earning (Total: {{ number_format($totalEarnings, 2) }})</th>
                            <th>Loss Amount (Total: {{ number_format($totalLoss, 2) }})</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($jantribahar as $data)
                        <tr>
                            <td><strong>{{ strtoupper($data->answer) }}</strong></td>
                            <td>{{ number_format($data->total_bid, 2) }}</td>
                            <td>
                                @if($data->result_status === 'claimed')
                                <span class="badge bg-label-danger me-1" style="color: #f41010 !important">
                                    {{ number_format($data->total_win, 2) }}
                                </span>
                                @else
                                <span class="badge bg-label-secondary me-1">{{ number_format($data ? $data->total_win: 0, 2) }}</span>
                                @endif
                            </td>
                            <td>{{ $data->bid_result ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endif