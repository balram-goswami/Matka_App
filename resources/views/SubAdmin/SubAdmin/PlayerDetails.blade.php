<div class="content-wrapper">
  <!-- Content -->
  <div class="card-header d-flex justify-content-between align-items-center">
    <a class="btn btn-primary" href="{{ route('viewPlayers')}}">Back</a>
  </div>

  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <!-- Order Statistics -->
      <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
            <div class="card-title mb-0">
              <h3 class="mb-1">{{ $user->name }}</h3>
            </div>
          </div>

          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-6">
              <div class="d-flex flex-column align-items-center gap-1">
                <h3 class="mb-1"></h3>
              </div>
              <br>
            </div>
            <ul class="p-0 m-0">
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Bank Details</h6>
                    <small>Bank Name:- {{ $user->bank_name}}</small><br>
                    <small>Bank Holder Name:- {{ $user->ac_holder_name}}</small><br>
                    <small>AC no.:- {{ $user->ac_number}}</small><br>
                    <small>{{ $user->ifsc_code}}</small>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">UPI Details</h6>
                    <small>UPI 1 :- {{ $user->upi_one}}</small><br>
                    <small>UPI 1 :- {{ $user->upi_two}}</small><br>
                    <small>UPI 1 :- {{ $user->upi_three}}</small><br>
                  </div>
                </div>
              </li>
            </ul>
            @if($user->status === "BlockByAdmin")
            @else
            <div class="mt-4">
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addMoney">
                Deposit
              </button>
              <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#deleteMoney">
                Withdrawl
              </button>

              <!-- Modal -->
              <div class="modal fade" id="addMoney" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addMoneyTitle">Deposit Money</h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    </div>
                    <form method="post" action="{{ route('addbalance') }}">
                      @csrf
                      <div class="modal-body">
                        <div class="row">
                          <div class="col mb-6">
                            <label for="nameWithTitle" class="form-label">Enter Amount</label>
                            <input
                              type="text"
                              class="form-control"
                              name="balance"
                              placeholder="Enter Amount" />
                            <input
                              hidden
                              name="user_id"
                              value="{{ $user->user_id }}"
                              placeholder="Enter Amount" />

                            <textarea
                              class="form-control"
                              id="deleteReason"
                              name="delete_reason"
                              placeholder="Enter Reason"
                              required
                              rows="3"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                          Close
                        </button>
                        <button type="submit" class="btn btn-primary">Deposit Now</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="deleteMoney" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteMoneyTitle">Withdrawl Money</h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    </div>
                    <form method="post" action="{{ route('deletebalance') }}">
                      @csrf
                      <div class="modal-body">
                        <div class="row">
                          <div class="col mb-6">
                            <label for="nameWithTitle" class="form-label">Enter Amount</label>
                            <input
                              type="text"
                              class="form-control"
                              name="balance"
                              placeholder="Enter Amount" />
                            <input
                              hidden
                              name="user_id"
                              value="{{ $user->user_id }}"
                              placeholder="Enter Amount" />

                            <textarea
                              class="form-control"
                              id="deleteReason"
                              name="delete_reason"
                              placeholder="Enter Reason"
                              required
                              rows="3"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                          Close
                        </button>
                        <button type="submit" class="btn btn-primary">Withdrawl Now</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
            <div class="card-title mb-0">
              <h3 class="mb-1">Game Ratio</h3>
            </div>
          </div>

          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-6">
              <div class="d-flex flex-column align-items-center gap-1">
                <h3 class="mb-1"></h3>
              </div>
              <br>
            </div>
            <ul class="p-0 m-0">
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Toss Game Rate</h6>
                    <h6 class="mb-0">Commission %</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $user->toss_game_rate ?? 'NA' }} X</h6>
                    <h6 class="mb-0">{{ $user->toss_game_commission ?? 'NA' }} %</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Crossing Rate</h6>
                    <h6 class="mb-0">Commission %</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $user->crossing_game_rate ?? 'NA' }} X</h6>
                    <h6 class="mb-0">{{ $user->crossing_commission ?? 'NA' }} %</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Harf Rate</h6>
                    <h6 class="mb-0">Commission %</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $user->harf_game_rate ?? 'NA' }} X</h6>
                    <h6 class="mb-0">{{ $user->harf_commission ?? 'NA' }} %</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Jodi Rate</h6>
                    <h6 class="mb-0">Commission %</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $user->jodi_game_rate ?? 'NA' }} X</h6>
                    <h6 class="mb-0">{{ $user->jodi_commission ?? 'NA' }} %</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-football"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">ODD EVEN Rate</h6>
                    <h6 class="mb-0">Commission %</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $user->oddEven_game_rate ?? 'NA' }} X</h6>
                    <h6 class="mb-0">{{ $user->oddEven_commission ?? 'NA' }} %</h6>
                  </div>
                </div>
              </li>

            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
            <div class="card-title mb-0">
              <h3 class="mb-1">Wallet Details</h3>
            </div>
          </div>

          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-6">
              <div class="d-flex flex-column align-items-center gap-1">
                <h3 class="mb-1"></h3>
              </div>
              <br>
            </div>
            <ul class="p-0 m-0">
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Wallet Balance</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $wallet->balance ?? 'NA' }}</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Exposure Balance</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $exposer->sum('bid_amount') }}</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Total bids</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ count($bids) ?? 'NA' }}</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Total bids win</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ count($win) ?? 'NA' }}</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Total bids loss</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ count($loss) ?? 'NA' }}</h6>
                  </div>
                </div>
              </li>

              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Result Panding</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ count($panding) ?? 'NA' }}</h6>
                  </div>
                </div>
              </li>

            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-4">
    <div class="card">
      <h5 class="card-header">Player Open Bids</h5>
      <div class="table-responsive text-nowrap">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Sr No.</th>
              <th>Game</th>
              <th>Bid On</th>
              <th>Bid Amount</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach($panding as $open)
            @php
            $game = postName($open->game_id);
            @endphp
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $game->post_title }}</td>
              <td>{{ $open->answer }}</td>
              <td>{{ $open->bid_amount }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="pagination mt-3">
        {{$panding->links()}}
      </div>
    </div>
  </div>
</div>

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-4">
    <div class="card">
      <h5 class="card-header">Player Wallet Transactions</h5>
      <div class="table-responsive text-nowrap">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Sr No.</th>
              <th>Date</th>
              <th>Credit</th>
              <th>Debit</th>
              <th>Balance</th>
              <th>Remark</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach($payment as $list)
            @php
            $userName = getUserName($list->tofrom_id);
            @endphp
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $list->updated_at}}</td>
              <td>{{ number_format($list->credit, 2)}}</td>
              <td>{{ number_format($list->debit, 2)}}</td>
              <td>{{ $list->balance ?? 'NA'}}</td>
              <td>{{ $list->remark }} {{$userName}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
      <div class="pagination mt-3">
        {{$payment->links()}}
      </div>
    </div>
  </div>
</div>