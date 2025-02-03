<div class="content-wrapper">
  <!-- Content -->

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
            <div class="mt-4">
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addMoney">
                Add Money
              </button>
              <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#deleteMoney">
                Cut Money
              </button>

              <!-- Modal -->
              <div class="modal fade" id="addMoney" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addMoneyTitle">Add Money</h5>
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
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                          Close
                        </button>
                        <button type="submit" class="btn btn-primary">Add Now</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="deleteMoney" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteMoneyTitle">Cutt Money</h5>
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
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                          Close
                        </button>
                        <button type="submit" class="btn btn-primary">Add Now</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
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
                    <h6 class="mb-0">Toss Game</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $user->toss_game ?? 'NA' }}</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Crossing</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $user->crossing ?? 'NA' }}</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Harf</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $user->harf ?? 'NA' }}</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Jodi</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $user->jodi ?? 'NA' }}</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-football"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">ODD EVEN</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $user->odd_even ?? 'NA' }}</h6>
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
                    <h6 class="mb-0">Rs- {{ $wallet->balance ?? 'NA' }}</h6>
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

<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <!-- Order Statistics -->
      <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
            <div class="card-title mb-0">
              <h3 class="mb-1">Money Deposit Details</h3>
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
              @foreach($dipositwallet as $wallet)
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">{{ $wallet->transaction_type }}</h6>
                    <h6 class="mb-0">{{ $wallet->request_status }}</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $wallet->deposit_amount }}</h6>
                  </div>
                </div>
              </li>
              @endforeach

            </ul>


          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
            <div class="card-title mb-0">
              <h3 class="mb-1">Money Withdrawal Details</h3>
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
              @foreach($withdrawwallet as $wallet)
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">{{ $wallet->transaction_type }}</h6>
                    <h6 class="mb-0">{{ $wallet->request_status }}</h6>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $wallet->withdraw_amount }}</h6>
                  </div>
                </div>
              </li>
              @endforeach

            </ul>


          </div>
        </div>
      </div>

    </div>
  </div>
</div>