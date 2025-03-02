@php
$headerOption = getThemeOptions('header');
$homePage = getThemeOptions('homePage');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    @laravelPWA
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    @if(isset($headerOption['meta_description']))
    <meta name="description" content="{{ $headerOption['meta_description'] ?? 'Matka App - Play Unlimited'}}">
    @endif
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#625AFA">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above tags *must* come first in the head, any other head content must come *after* these tags -->
    <!-- Title -->
    @if(isset($headerOption['meta_title']))
    <title>{{ $headerOption['meta_title'] ?? 'Matka App - Play Unlimited'}}</title>
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap"
        rel="stylesheet">
    <!-- Favicon -->
    @if(isset($headerOption['headerfavicon']))
    <link rel="icon" href="{{$headerOption['headerfavicon']}}">
    @endif
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" href="../themeAssets/img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../themeAssets/img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="../themeAssets/img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../themeAssets/img/icons/icon-180x180.png">

    @include('Include.Style')


</head>

<body>
    <!-- <div class="preloader" id="preloader">
        <div class="spinner-grow text-secondary" role="status">
            <div class="sr-only"></div>
        </div>
    </div> -->
    @if(session('danger'))
    <div class="alert alert-success" style="margin-top: 10%;">
        {{ session('danger') }}
    </div>
    @endif