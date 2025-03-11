@php
$currentUser = getCurrentUser();
$homePage = getThemeOptions('header');
@endphp

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">

                        <div class="card-body">
                            <h5 class="card-title text-primary">User Name: {{ $currentUser->name }} 🎉</h5>
                            <h5 class="card-title text-primary">Wallet Balance: {{ number_format($balance->balance, 2) }}</h5>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4" style="margin-bottom: 10px;">
                            @if(isset($homePage['headerlogo']))
                            <img src="{{ publicPath($homePage['headerlogo']) }}" height="140" alt="View Badge User"
                                data-app-dark-img="{{ publicPath($homePage['headerlogo']) }}"
                                data-app-light-img="{{ publicPath($homePage['headerlogo']) }}" />
                            @else
                            <img src="..\themeAssets\img\King\King.png" height="140" alt="View Badge User"
                                data-app-dark-img="..\themeAssets\img\King\King.png"
                                data-app-light-img="..\themeAssets\img\King\King.png" />
                            @endif
                        </div>
                    </div>
                    <div class="mt-4">
                        <!-- Button trigger modal -->
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#Deposit">
                            Deposit To Admin
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#withdrawal">
                            Withdrawal from Admin
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="Deposit" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="DepositTitle">Deposit Money</h5>
                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="{{ route('depositToAdmin') }}">
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
                                                        value="1"
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
                        <div class="modal fade" id="withdrawal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="withdrawalTitle">Withdrawal Money</h5>
                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="{{ route('withdrawalToAdmin') }}">
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
                                                        value="1"
                                                        placeholder="Enter Amount" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Withdrawal Now</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 order-1">
            <div class="row">

                <div class="col-lg-6 col-md-6 col-6 mb-6">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Users (<small
                                    class="text-success fw-semibold">{{ $userCount }}</small>)</span>
                            <a href="{{ route('users.index') }}">View More</a>
                        </div>
                    </div>
                </div>
                @foreach ($postCounts as $postCount)
                <div class="col-lg-6 col-md-6 col-6 mb-6" style="margin-bottom: 10px;">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">{{ $postCount['postTitle'] }} (<small
                                    class="text-success fw-semibold">{{ $postCount['postCount'] }}</small>)</span>
                            <a href="<?php echo route('post.index', ['postType' => $postCount['postType']]); ?>">View More</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
