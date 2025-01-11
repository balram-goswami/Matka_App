
</div>

@include('Include.Script')
</body>

<script>
    // Pass the user_id and role from Laravel to JavaScript
    const userId = @json(Auth::user() ? Auth::user()->user_id : null);
    const userRole = @json(Auth::user() ? Auth::user()->role : null);

    // Check if user_id is not null and user_role is not 'user'
    if (userId !== null && userRole !== 'user') {
        // Redirect to the welcome page
        window.location.href = '/'; 
    }
</script>

</html>
