@if($gameType === 'option')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-header">Jantri Table</h5>
                <h5 class="card-header">Result:- {{$gameResult->result}}</h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Options</th>
                            <th>My Earning</th>
                            <th>Loss Amount</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($jantriData as $data)
                        <tr>
                            <td><span>{{ $data->answer }}</span></td>
                            <td><span>{{ $data->total_bid }}</span></td>
                            <td>
                                @if($data->result_status === 'win')
                                <span class="badge bg-label-primary me-1" style="color: #f41010 !important">{{ $data->total_win }}</span>
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
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-header">Jantri Table</h5>
                <h5 class="card-header">Result:- {{$gameResult->result}}</h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Numbers</th>
                            <th>My Earning</th>
                            <th>Loss Amount</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @for ($i = 0; $i < 100; $i++)
                            @php
                            $bid=$jantriData->where('answer', $i)->first();
                            @endphp
                            <tr>
                                <td><span>{{ $i }}</span></td>
                                <td>{{ $bid ? $bid->total_bid : 0 }}</td>
                                <td>
                                    @if($bid && $bid->result_status === 'win')
                                    <span class="badge bg-label-primary me-1" style="color: #f41010 !important">
                                        {{ $bid->total_win }}
                                    </span>
                                    @else
                                    <span class="badge bg-label-primary me-1">00</span>
                                    @endif
                                </td>
                            </tr>
                            @endfor

                            <!-- ODD & EVEN Rows -->
                            @php
                            $gameValue = $gameResult->result; // Replace 'value' with the correct column name
                            $bidResult = ($gameValue % 2 === 0) ? 'EVEN' : 'ODD';

                            // Calculate ODD & EVEN totals correctly
                            $oddTotalBid = $jantriData->where('answer', 'ODD')->sum('total_bid');
                            $evenTotalBid = $jantriData->where('answer', 'EVEN')->sum('total_bid');

                            $oddTotalWin = $jantriData->where('answer', 'ODD')->sum('total_win');
                            $evenTotalWin = $jantriData->where('answer', 'EVEN')->sum('total_win');
                            @endphp
                            
                            <tr>
                                <td><strong>ODD</strong></td>
                                <td>{{ $oddTotalBid }}</td>
                                <td>
                                    @if( $bidResult === 'ODD')
                                    <span class="badge bg-label-primary me-1" style="color: #f41010 !important">
                                        {{ $oddTotalWin }}
                                    </span>
                                    @else
                                    <span class="badge bg-label-primary me-1">00</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td><strong>EVEN</strong></td>
                                <td>{{ $evenTotalBid }}</td>
                                <td>
                                @if( $bidResult === 'EVEN')
                                    <span class="badge bg-label-primary me-1" style="color: #f41010 !important">
                                        {{ $evenTotalWin }}
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