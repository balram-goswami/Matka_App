<div class="container-xxl flex-grow-1 container-p-y">
   <!-- Basic Bootstrap Table -->
   <div class="card mb-4">

      <div class="card-header d-flex justify-content-between align-items-center">
         <h4 class="fw-bold py-3 mb-0 pull-left"><?php echo ($postTitle['title']) ?></h4>
         <a class="text-muted float-end" href="<?php echo route('post.create', ['postType'=>$postType]) ?>"><button type="button" class="btn btn-primary">Add</button></a>
      </div>
      <div class="card-body">
         <form action="" method="get">
            <div class="row">
               <input type="hidden" name="postType" class="form-control" value="<?php echo Request()->get('postType') ?>" >
               <div class="col-md-4">
                  <input type="text" name="post_title" class="form-control" value="<?php echo Request()->get('post_title') ?>" placeholder="Search Keyword" >
               </div>
               <div class="col-md-4">
                  <select class="form-control form-control-lg" name="post_status" id="post_status">
                     <option value="">Select Status</option>
                     <option value="publish" <?php echo (Request()->get('post_status')== 'publish'?'selected':'') ?>>Publish</option>
                     <option value="draft" <?php echo (Request()->get('post_status') == 'draft'?'selected':'') ?>>Draft</option>
                     <option value="trash" <?php echo (Request()->get('post_status') == 'trash'?'selected':'') ?>>Trash</option>
                  </select>
               </div>
               <div class="col-md-4">
                  <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Search</button>
               </div>
            </div>
         </form>
         <div class="table-responsive">
            <table class="table">
               <thead>
                  <tr>
                     <th>Title</th>
                     <th>Url</th>
                     <?php 
                     if (!empty($postTitle['taxonomy']) && is_array($postTitle['taxonomy'])) {
                        foreach ($postTitle['taxonomy'] as $taxonomyKey => $taxonomyValue) {
                           echo '<th>'.$taxonomyValue['title'].'</th>';
                        }
                     }
                     ?>
                     <th>Last Updated</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody id="sortable">
                  <?php 
                  foreach ($posts as $post) {
                     $post_type = getPostType($post->post_type);
                     if ($post->post_type == 'post' || $post->post_type == 'page') {
                        $permalink = siteUrl().$post->post_name;
                     } else {
                        $permalink = siteUrl().$post_type['slug'].'/'.$post->post_name;
                     }                              
                     ?>
                     <tr class="tr_rows" data-post_id="<?php echo $post->post_id; ?>">
                        <td style="white-space: normal;"><a href="<?php echo $permalink ?>" target="_blank"><?php echo $post->post_title ?></a></td>
                        <td style="white-space: normal;" onContextMenu="return false;" contenteditable data-post_id="<?php echo $post->post_id; ?>"><?php echo $post->post_name ?></td>
                        <?php 
                        if (!empty($postTitle['taxonomy']) && is_array($postTitle['taxonomy'])) {
                           foreach ($postTitle['taxonomy'] as $taxonomyKey => $taxonomyValue) {
                              echo '<td>'.(isset($post->category[$taxonomyKey])?$post->category[$taxonomyKey]:'').'</td>';
                           }
                        }
                        ?>
                        <td><?php echo dateFormat($post->updated_at); ?></td>
                        <td>
                           <a title="View" class="edit-button" href="<?php echo $permalink ?>" target="_blank"><button type="button" class="btn btn-success "><span class="pcoded-micon"><i class='bx bx-low-vision'></i></span></button></a> | 
                           <a title="Edit" class="edit-button" href="<?php echo route('post.edit', $post->post_id, $postType) ?>"><button type="button" class="btn btn-info "><span class="pcoded-micon"><i class='bx bx-edit-alt'></i></span></button></a> | 
                           <a title="Clone" href="<?php echo route('post.clone', $post->post_id) ?>"><button type="button" class="btn btn-warning"><span class="pcoded-micon"><i class='bx bx-copy'></i></span></button></a> | 
                           <?php echo Form::open(['route' => array('post.destroy', $post->post_id), 'method' => 'delete','style'=>'display: inline-block;']) ?>
                              <button title="Delete" type="submit" class="btn btn-danger"><span class="pcoded-micon"><i class='bx bx-trash-alt' ></i></span></button>
                           </form>
                        </td>
                     </tr>
                     <?php
                  }
                  ?>                           
               </tbody>
            </table>
         </div>
         <?php echo $posts->appends(request()->except('page'))->links(); ?>
      </div>
      
   </div>
</div>
<script type="text/javascript">
   jQuery(document).ready(function($) {
      $( "#sortable" ).sortable({
         update: function( ) {
            var sortIndex = [];
            $.each($('.tr_rows'), function(index, val) {
               sortIndex.push($(this).attr('data-post_id'));
            });
            $.ajax({
               url: '<?php echo route('post.updateOrder') ?>',
               type: 'GET',
               data: {order: sortIndex},
            });            
         }
      });
      $(document).on('blur', 'td[contenteditable]', function() {
         const $this = $(this);
         var post_name = $this[0].innerText;
         var post_id = $this.attr('data-post_id');
         $.ajax({
            url: '<?php echo route('post.updatePostName') ?>',
            type: 'GET',
            data: {post_name: post_name, post_id, post_id},
         })
         .done(function(result){
            $this[0].innerText = result;
         }); 
      });
   });
</script>