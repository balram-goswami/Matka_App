@php 
$homePage = getThemeOptions('homePage');
@endphp

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left">Game Chart</h4>
            @if(isset($homePage['chartUrl']))
            <a class="text-muted float-end" href="{{$homePage['chartUrl']}}" target="_blank"><button type="button"
                    class="btn btn-primary">Go To Chart Website</button></a>
                    @endif
        </div>
        <div class="table-responsive text-nowrap">
        @if(isset($homePage['chartUrl']))
            <iframe src="{{$homePage['chartUrl']}}" width="100%" height="500px" style="border: none;"></iframe>
            @endif
        </div>
    </div>
</div>
