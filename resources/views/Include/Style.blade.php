<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ publicPath('/themeAssets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ publicPath('/themeAssets/css/tabler-icons.min.css') }}">
<link rel="stylesheet" href="{{ publicPath('/themeAssets/css/animate.css') }}">
<link rel="stylesheet" href="{{ publicPath('/themeAssets/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ publicPath('/themeAssets/css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ publicPath('/themeAssets/css/nice-select.css') }}">
<!-- Stylesheet -->
<link rel="stylesheet" href="{{ publicPath('/themeAssets/style.css') }}">
<!-- Web App Manifest -->
<link rel="manifest" href="{{ publicPath('/themeAssets/manifest.json') }}">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
   :root {
        --speed: 10s; /* Default speed */
    }

    .news-ticker {
        display: flex;
        align-items: center;
        width: 100%;
        background: #1d1d1d;
        color: white;
        padding: 12px 15px;
        font-size: 16px;
        font-weight: 500;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(2, 2, 2, 0.2);
        position: relative;
    }

    .news-icon {
        font-size: 22px;
        color: #FFC107;
        margin-right: 15px;
        animation: pulse 0.5s infinite alternate;
    }

    .ticker-wrapper {
        display: flex;
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .ticker-content {
        display: flex;
        white-space: nowrap;
        animation: scroll var(--speed) linear infinite;
        min-width: max-content; /* Ensures content fits properly */
    }

    .ticker-item {
        margin-right: 50px; /* Space between news items */
        display: inline-block;
    }

    /* Keyframe animation for smooth scrolling */
    @keyframes scroll {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(-50%);
        }
    }

    /* Mobile: Adjust speed */
    @media (max-width: 767px) {
        :root {
            --speed: 15s;
        }
    }



    .custom-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 8px #ffcc00;
    }

    .card-header {
        background: white;
        padding: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-header img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        box-shadow: 0 2px 5px #ffcc00;
    }

    .play-btn {
        background: green;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: bold;
    }

    .market-status {
        color: red;
        font-weight: bold;
    }

    .card-footer {
        background: #FFCC00;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
    }

    a {
        text-decoration: none;
    }
</style>