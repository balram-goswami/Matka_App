<!-- Fonts -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
  rel="stylesheet"
/>

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="<?php echo assetPath('vendor/fonts/boxicons.css') ?>" />

<!-- Core CSS -->
<link rel="stylesheet" href="<?php echo assetPath('vendor/css/core.css') ?>" class="template-customizer-core-css" />
<link rel="stylesheet" href="<?php echo assetPath('vendor/css/theme-default.css') ?>" class="template-customizer-theme-css" />
<link rel="stylesheet" href="<?php echo assetPath('css/demo.css') ?>" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="<?php echo assetPath('vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

<link rel="stylesheet" href="<?php echo assetPath('vendor/libs/apex-charts/apex-charts.css') ?>" />
<link rel="stylesheet" href="<?php echo assetPath('css/jquery.dataTables.min.css') ?>" />
<link rel="stylesheet" href="<?php echo assetPath('css/nestable.css') ?>" />

<style>
  .pull-left {
    float: left;
  }
  .pull-right {
    float: right;
  }
</style>

<!-- Page CSS -->

<!-- Helpers -->
<script src="<?php echo assetPath('vendor/js/helpers.js') ?>"></script>

<script src="<?php echo assetPath('js/config.js') ?>"></script>
<script src="<?php echo assetPath('vendor/libs/jquery/jquery.js') ?>"></script>
<script src="<?php echo assetPath('js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo assetPath('js/jquery.nestable.js') ?>"></script>
<script src="<?php echo assetPath('js/jquery-ui.min.js') ?>"></script>