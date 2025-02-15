
</div>

@include('Include.Script')
</body>

<script>
    const userId = @json(Auth::user() ? Auth::user()->user_id : null);
    const userRole = @json(Auth::user() ? Auth::user()->role : null);

    if (userId !== null && userRole !== 'player') {
        window.location.href = '/'; 
    }
</script>

</html>
