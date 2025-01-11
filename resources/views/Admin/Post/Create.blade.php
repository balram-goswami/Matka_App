<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
    <div class="card mb-4">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left"><?php echo $postTitle['title']; ?></h4>
        </div>
        <div class="card-body">
            <?php echo Form::open(['route' => ['post.store', 'postType=' . $postType], 'method' => 'post', 'class' => 'md-float-material']); ?>
            <div class="row">
                <div class="col-md-9 padding-right">

                    <div class="">
                        <div class="card-block accordion-block color-accordion-block">
                            <div class="card-block">
                                <div class="">
                                    <div class="input-group row">
                                        <label class="col-form-label" for="post_title>">Title</label><br>
                                        <input type="text" name="post_title" required id="post_title"
                                            class="form-control form-control-lg" placeholder="Title"
                                            value="<?php echo old('post_title'); ?>">
                                        <span class="md-line"></span>
                                    </div>
                                    <?php 
                              if (isset($postTitle['support']) && is_array($postTitle['support']) && in_array('content', $postTitle['support'])) {
                              ?>
                                    <div class="input-group row">
                                        <label class="col-form-label" for="post_content">Content</label><br>
                                        <textarea name="post_content" id="post_content" class="form-control form-control-lg ckeditor" placeholder="Content"><?php echo old('post_content'); ?></textarea>
                                        <span class="md-line"></span>
                                    </div>
                                    <?php } ?>
                                    <?php 
                              if (isset($postTitle['support']) && is_array($postTitle['support']) && in_array('excerpt', $postTitle['support'])) {
                              ?>
                                    <div class="input-group row">
                                        <label class="col-form-label" for="post_excerpt">Excerpt</label><br>
                                        <textarea rows="7" name="post_excerpt" id="post_excerpt" class="form-control form-control-lg"
                                            placeholder="Excerpt"><?php echo old('post_excerpt'); ?></textarea>
                                        <span class="md-line"></span>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="">
                                    <?php 
                              if (isset($postTitle['support']) && is_array($postTitle['support']) && in_array('seo', $postTitle['support'])) {
                              ?>
                                    <div class="input-group row">
                                        <label class="col-form-label" for="meta_Keywords">Meta Keywords</label><br>
                                        <input type="text" name="meta_Keywords" id="meta_Keywords"
                                            class="form-control form-control-lg" placeholder="Meta Keywords"
                                            value="<?php echo old('meta_Keywords'); ?>">
                                        <span class="md-line"></span>
                                    </div>
                                    <div class="input-group row">
                                        <label class="col-form-label" for="meta_title">Meta Title</label><br>
                                        <input type="text" name="meta_title" id="meta_title"
                                            class="form-control form-control-lg" placeholder="Meta Title"
                                            value="<?php echo old('meta_title'); ?>">
                                        <span class="md-line"></span>
                                    </div>
                                    <div class="input-group row">
                                        <label class="col-form-label" for="meta_description">Meta
                                            Description</label><br>
                                        <textarea rows="4" name="meta_description" id="meta_description" class="form-control form-control-lg"
                                            placeholder="Meta Description"><?php echo old('meta_description'); ?></textarea>
                                        <span class="md-line"></span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="card-block accordion-block color-accordion-block">
                            <?php addPostMetaBox($postType, 0); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class=" ">
                        <div class="card-block">
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="post_status">Status</label><br>
                                    <select class="form-control form-control-lg" name="post_status" id="post_status">
                                        <option value="publish" <?php echo old('post_status') == 'publish' ? 'selected' : ''; ?>>Publish</option>
                                        <option value="draft" <?php echo old('post_status') == 'draft' ? 'selected' : ''; ?>>Draft</option>
                                        <option value="trash" <?php echo old('post_status') == 'trash' ? 'selected' : ''; ?>>Trash</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="comment_status">Comments</label><br>
                                    <select class="form-control form-control-lg" name="comment_status"
                                        id="comment_status">
                                        <option value="close" <?php echo old('comment_status') == 'close' ? 'selected' : ''; ?>>Close</option>
                                        <option value="open" <?php echo old('comment_status') == 'open' ? 'selected' : ''; ?>>Open</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="createSiteMap">Create This Page In
                                        SiteMap</label><br>
                                    <select class="form-control form-control-lg" name="createSiteMap"
                                        id="createSiteMap">
                                        <option value="no" <?php echo old('createSiteMap') == 'no' ? 'selected' : ''; ?>>No</option>
                                        <option value="yes" <?php echo old('createSiteMap') == 'yes' ? 'selected' : ''; ?>>Yes</option>
                                    </select>
                                </div>
                            </div>
                            <?php 
                        if (isset($postTitle['templateOption']) && is_array($postTitle['templateOption']))
                        {
                           ?>
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="post_template">Template</label><br>
                                    <select class="form-control form-control-lg" name="post_template"
                                        id="post_template">
                                        <?php 
                                    foreach ($postTitle['templateOption'] as $templateKey => $templateValue) {
                                       ?>
                                        <option value="<?php echo $templateKey; ?>" <?php echo $templateKey == old('post_template') ? 'selected' : ''; ?>><?php echo $templateValue; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                            <?php 
                        if (isset($postTitle['support']) && is_array($postTitle['support']) && in_array('featured', $postTitle['support'])) {
                        ?>
                            <div class="row m-t-30">
                                <div class="col-md-12 imageUploadGroup">
                                    <img src="" id="guid-img" style="width: 100%;height: 200px;">
                                    <button type="button" data-eid="guid"
                                        class="btn btn-success setFeaturedImage">Select image</button>
                                    <button type="button" data-eid="guid"
                                        class="btn btn-warning removeFeaturedImage">Remove image</button>
                                    <input type="hidden" name="guid" id="guid" value="">
                                </div>
                            </div>
                            <?php } ?>
                            <?php 
                        if (!empty($postTitle['taxonomy'])) {
                           foreach ($postTitle['taxonomy'] as $taxonomyKey => $taxonomyValue) {
                              if ($taxonomyValue['hasVariations'] == false) {
                                 ?>
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <label class="col-form-label"
                                        for="terms_<?php echo $taxonomyKey; ?>"><?php echo $taxonomyValue['title']; ?></label><br>
                                    <div class="checkbox-group">
                                        <?php
                                        $terms = \App\Models\Terms::where('term_group', $taxonomyKey)->get();
                                        foreach ($terms as $term) {
                                            echo '<label for="term_' . $term->id . '">' . $term->name . '<input type="checkbox" name="terms[]" id="term_' . $term->id . '" value="' . $term->id . '" ' . (is_array(old('terms')) && in_array($term->id, old('terms')) ? 'checked' : '') . '></label>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                              }
                           }
                        }
                        ?>
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <button type="submit"
                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
