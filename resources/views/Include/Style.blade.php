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
    .news-ticker {
        display: flex;
        align-items: center;
        width: 100%;
        background: #2e2e2e;
        color: white;
        padding: 12px 15px;
        font-size: 16px;
        font-weight: 500;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        white-space: nowrap;
    }

    .news-icon {
        font-size: 22px;
        color: #FFC107;
        margin-right: 25px;
        animation: pulse 1.5s infinite alternate;
    }

    .ticker-wrapper {
        flex: 1;
        overflow: hidden;
        position: relative;
    }

    .ticker-content {
        display: inline-block;
        white-space: nowrap;
        animation: scroll 15s linear infinite;
    }

    @keyframes scroll {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(-100%);
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 0.8;
        }

        100% {
            transform: scale(1.1);
            opacity: 1;
        }
    }

    .stripSize {
        margin-top: 3%;
    }

    @media only screen and (max-width: 767px) {
        .stripSize {
            margin-top: 10%;
        }

    }

    .custom-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(227, 167, 36, 0.2);
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
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .play-btn {
        background: red;
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
        background: #FFB80C;
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