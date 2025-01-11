
            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="" target="_blank" class="footer-link fw-bolder">Array Blocks</a>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    @Include('Common.Script')
    <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
     jQuery(document).ready(function($) {
        $(document).on('click', '.ajax-pagination a', function(event) {
           event.preventDefault();
           var url = $(this).attr('href');
           var parameters = url.split('=');
           getMediaLibrary(parameters[1]);
        });
        $(document).on('click', '.nav-link-uploader', function(event) {
           event.preventDefault();
           $('.nav-link-uploader').removeClass('active');
           $('.tab-pane-uploader').removeClass('show active');
           var url = $(this).attr('href');
           $(url).addClass('show active');
           $(this).removeClass('active');
        });
        $(document).on('click', '.setFeaturedImage', function(event) {
           let attribute = '' 
           if($(this).data('eid')){
              attribute = $(this).data('eid');
           }
           $.ajax({
              url: '<?php echo route('media.gallery') ?>',
           })
           .done(function(response) {
              $('.mediaUploaderBody').html(response);
              $('#selectThumb').attr('data-eid',attribute)
              $('#mediaModal').modal('show');
           });               
        });
        $(document).on('click', '.mediaUploader .animation', function(event) {
           event.preventDefault();
           $('.mediaUploader .animation').removeClass('active');
           $(this).addClass('active');
        });
        $(document).on('click', '#selectThumb', function(event) {
           event.preventDefault();
           let id=$(this).data('eid')
           $('#'+id).closest('.imageUploadGroup').find('.setFeaturedImage').fadeOut();
           $('#'+id).closest('.imageUploadGroup').find('.removeFeaturedImage').fadeIn();
           var mediaID = $('.mediaUploader .animation.active').attr('data-media_id');
           var mediaURL = $('.mediaUploader .animation.active').attr('data-media_url');
           var media_show_url = $('.mediaUploader .animation.active').attr('data-media_show_url');
           if ($('#'+id).closest('.imageUploadGroup').find('#guid').length > 0) {
              $('#guid').val(mediaID);
           }               
           if(id){
              if ($('#'+id).closest('.imageUploadGroup').find('#guid').length == 0) {
                 $('#'+id).val(media_show_url);
              }
              $('#'+id+'-img').fadeIn().attr('src',mediaURL);
           }
           $('#mediaModal').modal('hide');
        });
        $(document).on('click', '.removeFeaturedImage', function(event) {
           event.preventDefault();
           let id=$(this).data('eid')
           $('#'+id).closest('.imageUploadGroup').find('.setFeaturedImage').fadeIn();
           $(this).fadeOut();
           if ($('#'+id).closest('.imageUploadGroup').find('#guid').length > 0) {
              $('#guid').removeAttr('value').attr('val','');
           } 
           
           if(id){
              $('#'+id).removeAttr('value').attr('val','');
              $('#'+id+'-img').fadeOut();
           }
           $('#mediaURL').fadeOut();
        });
        $(document).on('click', '.removeThumbanil', function(event) {
           event.preventDefault();
           var mediaID = $(this).attr('data-media_id');
           $.ajax({
              url: '<?php echo route('media.delete') ?>',
              method: 'GET',
              data: {
                 post_id: mediaID
              }
           })
           .done(function(response) {
              $('.mediaUploader').html(response);
           });
        });
        $(document).on('click', '.editThumbanil', function(event) {
           event.preventDefault();
           var mediaID = $(this).attr('data-media_id');
           $('#post_title_'+mediaID+'_popup').toggle();
        });
        $(document).on('click', '.saveMediaTitle', function(event) {
           event.preventDefault();
           var mediaID = $(this).attr('data-media_id');
           var post_title = $('#post_title_'+mediaID).val();
           var _wp_attachment_image_alt = $('#_wp_attachment_image_alt_'+mediaID).val();
           var post_content = $('#post_content_'+mediaID).val();
           var post_excerpt = $('#post_excerpt_'+mediaID).val();
           $.ajax({
              url: '<?php echo route('media.updateAlt') ?>',
              type: 'GET',
              data: {
                 post_id: mediaID, 
                 post_title: post_title,
                 _wp_attachment_image_alt: _wp_attachment_image_alt,
                 post_content: post_content,
                 post_excerpt: post_excerpt
              },
           })
           .done(function() {
              $('#post_title_'+mediaID+'_popup').toggle();
           });               
        });
        
        $(".InputNumber").keydown(function (e) {
             if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                 (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                 (e.keyCode >= 35 && e.keyCode <= 40)) {
                     return;
             }
             if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                 e.preventDefault();
             }
        });
     });
     </script>
  </body>
</html>
<div class="modal fade" id="mediaModal" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body mediaUploaderBody">

         </div>
      </div>
   </div>
</div>