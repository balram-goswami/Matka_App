<script src="{{ publicPath('/themeAssets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/jquery.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/waypoints.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/jquery.easing.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/owl.carousel.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/jquery.counterup.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/jquery.countdown.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/jquery.passwordstrength.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/theme-switching.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/active.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/pwa.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const timer = document.getElementById("time-left");
        let submitButton = document.getElementById("submit-btn");

        if (timer) {
            // Get times from dataset
            const openTime = timer.dataset.openTime;
            const closeTime = timer.dataset.closeTime;
            const currentTime = timer.dataset.currentTime;

            // Convert times to minutes for easier comparison
            const timeToMinutes = (time) => {
                const [hours, minutes] = time.split(":").map(Number);
                return hours * 60 + minutes;
            };

            const openMinutes = timeToMinutes(openTime);
            let closeMinutes = timeToMinutes(closeTime);
            let currentMinutes = timeToMinutes(currentTime);

            // Handle scenario where close time is past midnight (next day)
            if (closeMinutes < openMinutes) {
                closeMinutes += 1440; // Add 24 hours (1440 minutes) to close time
                if (currentMinutes < openMinutes) {
                    currentMinutes += 1440; // Adjust current time if it's past midnight
                }
            }

            // Determine if the game is open
            if (currentMinutes >= openMinutes && currentMinutes < closeMinutes) {
                let remainingTime = (closeMinutes - currentMinutes) * 60; // Convert back to seconds

                const updateTimer = () => {
                    if (remainingTime > 0) {
                        const hours = Math.floor(remainingTime / 3600);
                        const minutes = Math.floor((remainingTime % 3600) / 60);
                        const seconds = remainingTime % 60;

                        timer.innerText = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                        remainingTime--;
                    } else {
                        timer.innerText = "Time's up!";
                        if (submitButton) {
                            submitButton.style.display = "none"; // Hide submit button when time is up
                        }
                        clearInterval(interval);
                    }
                };

                updateTimer();
                let interval = setInterval(updateTimer, 1000);
            } else {
                timer.innerText = "Time's up!";
                if (submitButton) {
                    submitButton.style.display = "none"; // Hide submit button if game is closed
                }
            }
        }
    });
</script>
