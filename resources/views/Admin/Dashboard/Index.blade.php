@php
    $currentUser = getCurrentUser();
@endphp

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Welcome {{ $currentUser->name }} 🎉</h5>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4" style="margin-bottom: 10px;">
                            <img src="../assets/img/illustrations/vdk_kndl.png" height="140" alt="View Badge User"
                                data-app-dark-img="illustrations/vdk_kndl.png"
                                data-app-light-img="illustrations/vdk_kndl.png" />
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
