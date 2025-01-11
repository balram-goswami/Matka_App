<div class="container-xxl flex-grow-1 container-p-y">
   <!-- Basic Bootstrap Table -->
   <div class="card mb-4">

      <div class="card-header d-flex justify-content-between align-items-center">
         <h4 class="fw-bold py-3 mb-0 pull-left"><?php echo ($taxonomyTitle) ?></h4>
      </div>
      <div class="card-body">
         <div class="row">
            <div class="col-md-5">
               <?php echo Form::open(['route' => array('taxonomy.store', 'postType='.$postType.'&taxonomy='.$taxonomy), 'method' => 'post', 'class' => 'md-float-material']) ?>
                  <div class="input-group row">
                     <label class="col-form-label" for="name">Name</label><br>
                     <input type="text" name="name" id="name" required="" class="form-control form-control-lg" placeholder="Name" value="<?php echo old('name') ?>">
                     <span class="md-line"></span>
                  </div>
                  <div class="input-group row">
                     <label class="col-form-label" for="parent">Parent</label><br>
                     <select name="parent" id="parent" class="form-control form-control-lg">
                        <option value="0">Select</option>
                        <?php 
                        foreach ($parentTerms as $parentTerm) {
                           ?>
                           <option value="<?php echo $parentTerm->term_id ?>" <?php echo ($parentTerm->term_id == old('parent')?'selected':'') ?>><?php echo $parentTerm->name ?></option>
                           <?php
                        }
                        ?>
                     </select>
                     <span class="md-line"></span>
                  </div>
                  <?php
                  if($posts){
                     ?>
                        <div class="input-group row">
                           <label class="col-form-label" for="link_post">Link Post</label><br>
                           <select name="link_post" id="link_post" class="form-control form-control-lg">
                              <option value="0">Select</option>
                              <?php 
                              foreach ($posts as $post) {
                                 ?>
                                 <option value="<?php echo $post['post_id'] ?>" <?php echo ($post['post_id'] == old('link_post')?'selected':'') ?>><?php echo $post['post_title'] ?></option>
                                 <?php
                              }
                              ?>
                           </select>
                           <span class="md-line"></span>
                        </div> 
                     <?php  
                  }
                  ?>                           
                  <div class="input-group row">
                     <label class="col-form-label" for="description">Description</label><br>
                     <textarea name="description" id="description" class="form-control form-control-lg" placeholder="Description"><?php echo old('description') ?></textarea>
                     <span class="md-line"></span>
                  </div>
                  <div class="input-group row">
                     <label class="col-form-label" for="meta_Keywords">Meta Title</label><br>
                     <input type="text" name="meta_title" id="meta_title" class="form-control form-control-lg" placeholder="Meta Title" value="<?php echo old('meta_title') ?>">
                     <span class="md-line"></span>
                  </div>
                  <div class="input-group row">
                     <label class="col-form-label" for="meta_Keywords">Meta Keywords</label><br>
                     <input type="text" name="meta_Keywords" id="meta_Keywords" class="form-control form-control-lg" placeholder="Meta Keywords" value="<?php echo old('meta_Keywords') ?>">
                     <span class="md-line"></span>
                  </div>
                  <div class="input-group row">
                     <label class="col-form-label" for="meta_description">Meta Description</label><br>
                     <textarea rows="4" name="meta_description" id="meta_description" class="form-control form-control-lg" placeholder="Meta Description"><?php echo old('meta_description') ?></textarea>
                     <span class="md-line"></span>
                  </div>
                  <div class="input-group row">
                     <label class="col-form-label" for="createSiteMap">Create This Taxonomy In SiteMap</label><br>
                     <select class="form-control form-control-lg" name="createSiteMap" id="createSiteMap">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                     </select>
                  </div>
                  <?php addTermMetaBox($taxonomy,  0); ?>
                  <div class="row m-t-30">
                     <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Save</button>
                     </div>
                  </div>
               </form>
            </div>
            <div class="col-md-7">
               <?php 
               $hasVariations = (isset($postTitle['taxonomy'][$taxonomy]['hasVariations'])?$postTitle['taxonomy'][$taxonomy]['hasVariations']:false);
               ?>
            <div class="table-responsive">
               <table class="table">
                  <thead>
                     <tr>
                        <th>Title</th>
                        <th>Parent</th>
                        <th>Date</th>
                        <th>Count</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                     foreach ($terms as $term) {
                        ?>
                        <tr>
                           <td><?php echo $term->name ?></td>
                           <td><?php echo $term->parent_term ?></td>
                           <td><?php echo dateFormat($term->updated_at); ?></td>
                           <td><?php echo $term->count ?></td>
                           <td> 
                              <?php 
                              if ($hasVariations) {
                                 ?>
                                 <a href="<?php echo route('taxonomy.configureTerms', ['taxonomy'=>$term->slug,'postType'=>$term->post_type]) ?>">Configure Terms</a> |
                                 <?php
                              }
                              ?>                                       
                              <a title="Edit" href="<?php echo route('taxonomy.edit', $term->id) ?>"><button type="button" class="btn btn-success"><span class="pcoded-micon"><i class='bx bx-edit-alt'></i></span></button></a> | 
                              <?php echo Form::open(['route' => array('taxonomy.destroy', $term->id), 'method' => 'delete','style'=>'display: inline-block;']) ?>
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
            <?php echo $terms->appends(request()->except('page'))->links(); ?>                     
         </div>
      </div>
   </div>
</div>