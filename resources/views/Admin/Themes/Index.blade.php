<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
        <div class="card">  
            <div class="card-body">  
                <div class="col-md-12">  
                    <div class="page-body">
                        <form class="ThemeOptionForm" novalidate>
                            <div class="theme-content">   
                                <nav class="theme_nav"style="display: inline-block; width: 100%;">
                                    <button type="submit" class="btn btn-success active" style="float: right;">Save</button>
                                </nav>   

                                <div class="col-md-12"><?php echo $option; ?></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">


<script>
jQuery(document).ready(function(){
    // CSRF Token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.ThemeOptionForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        $.ajax({
            url: '{{ route('themes.store') }}', // Laravel Blade URL generation
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status === true) {
                    window.alert('Data Saved Successfully.');
                } else {
                    window.alert('An unexpected response was received.');
                }
            },
            error: function(response) {
                console.error('Error:', response);
                window.alert('An error occurred while saving data. Please try again.');
            }
        });
    });
});
</script>
