<!-- Core JS -->
<!-- build:js vendor/js/core.js -->
<script src="<?php echo assetPath('vendor/libs/popper/popper.js') ?>"></script>
<script src="<?php echo assetPath('vendor/js/bootstrap.js') ?>"></script>
<script src="<?php echo assetPath('vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

<script src="<?php echo assetPath('vendor/js/menu.js') ?>"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="<?php echo assetPath('vendor/libs/apex-charts/apexcharts.js') ?>"></script>

<!-- Main JS -->
<script src="<?php echo assetPath('js/main.js') ?>"></script>

<!-- Page JS -->
<script src="<?php echo assetPath('js/dashboards-analytics.js') ?>"></script>
<script type="text/javascript" src="https://cdn.ckeditor.com/4.10.1/full-all/ckeditor.js"></script>
<script type="text/javascript"> 
   $(function () { 
      if($('.ckeditor').length > 0)
      {
         CKEDITOR.replace( '.ckeditor' );
         CKEDITOR.config.allowedContent = true;

         /*var editor = CKEDITOR.replace('.ckeditor'); 
         editor.editorConfig = function( config ) { 
             config.allowedContent = true;
             config.removeFormatAttributes = '';
             config.toolbarGroups = [
                 { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
                 { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
                 { name: 'links' },
                 { name: 'insert' },
                 { name: 'forms' },
                 { name: 'tools' },
                 { name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
                 { name: 'others' },
                 '/',
                 { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                 { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                 { name: 'styles' },
                 { name: 'colors' },
                 { name: 'about' }
             ];

             config.removeButtons = 'Underline,Subscript,Superscript';

             config.format_tags = 'p;h1;h2;h3;pre;';

             config.removeDialogTabs = 'image:advanced;link:advanced';
         }; */
      }                                                            
   });
</script>