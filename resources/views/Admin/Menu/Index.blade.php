<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
    <div class="card mb-4">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0 pull-left">Menus</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <!-- Tab panes -->
                    <div class="tab-content tabs card-block">
                        <div class="tab-pane active" id="home1" role="tabpanel" aria-expanded="true">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="">
                                        <div class="card-block accordion-block">
                                            <div class="accordion mt-3" id="accordionExample_post">
                                            <?php 
                                            foreach($menu_data as $menuKey => $menuValue) {
                                                $postTitle = getPostType($menuKey);
                                                ?>
                                                <div class="card accordion-item">
                                                  <h2 class="accordion-header" id="headingOne_<?php echo $menuKey ?>">
                                                    <button
                                                      type="button"
                                                      class="accordion-button"
                                                      data-bs-toggle="collapse"
                                                      data-bs-target="#<?php echo $menuKey ?>"
                                                      aria-expanded="true"
                                                      aria-controls="<?php echo $menuKey ?>"
                                                    >
                                                      <?php echo $postTitle['title'] ?>
                                                    </button>
                                                  </h2>

                                                  <div
                                                    id="<?php echo $menuKey ?>"
                                                    class="accordion-collapse collapse"
                                                    data-bs-parent="#accordionExample"
                                                  >
                                                    <div class="accordion-body">
                                                      <form class="formAddMenu">
                                                          <div class="accordion-content accordion-desc">
                                                              <?php foreach ( $menuValue as $menu){ ?>
                                                                    <li>
                                                                        <input class="menuCheckBox" type="checkbox"
                                                                            value="<?php echo $menu['post_id'] ?>" 
                                                                            data-name="<?php echo $menu['post_title'] ?>" 
                                                                            data-url="<?php echo $menu['post_name'] ?>"                                                                                       
                                                                            data-target="post"
                                                                            data-targetType="<?php echo $menu['post_type'] ?>"  
                                                                            id="<?php echo $menu['post_id'] ?>"
                                                                        > 
                                                                        <?php echo $menu['post_title'] ?>
                                                                    </li>   
                                                                <?php } ?>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-lg-6 pull-right">
                                                                  <button type="submit" class="btn btn-mat btn-primary btn-sm">Add to Menu</button>
                                                              </div>   
                                                          </div>
                                                      </form>
                                                    </div>
                                                  </div>
                                                </div>

                                                <?php
                                            }     
                                            ?>                                                   

                                            </div>

                                            <div class="accordion mt-3" id="accordionExample">
                                                <?php 
                                                foreach($category_data as $categoryKey => $categoryValue) {
                                                ?>
                                                      <div class="card accordion-item">
                                                        <h2 class="accordion-header" id="headingOne_<?php echo $categoryKey ?>">
                                                          <button
                                                            type="button"
                                                            class="accordion-button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#<?php echo $categoryKey ?>"
                                                            aria-expanded="true"
                                                            aria-controls="<?php echo $categoryKey ?>"
                                                          >
                                                            <?php echo $categoryValue['title'] ?>
                                                          </button>
                                                        </h2>

                                                        <div
                                                          id="<?php echo $categoryKey ?>"
                                                          class="accordion-collapse collapse "
                                                          data-bs-parent="#accordionExample"
                                                        >
                                                          <div class="accordion-body">
                                                            <form class="formAddMenu">
                                                                <div class="accordion-content accordion-desc">
                                                                    <?php foreach ( $categoryValue['menus'] as $termMenu){ ?>
                                                                        <li>
                                                                            <input class="menuCheckBox" type="checkbox"
                                                                                value="<?php echo $termMenu['id'] ?>" 
                                                                                data-name="<?php echo $termMenu['name'] ?>" 
                                                                                data-target="term"
                                                                                data-targetType="<?php echo $termMenu['term_group'] ?>" 
                                                                                id="<?php echo $termMenu['id'] ?>"
                                                                            > 
                                                                            <?php echo $termMenu['name'] ?>
                                                                        </li>   
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6 pull-right">
                                                                        <button type="submit" class="btn btn-mat btn-primary btn-sm">Add to Menu</button>
                                                                    </div>   
                                                                </div>
                                                            </form>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    <?php
                                                }     
                                                ?> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">                                    
                                    <form class="submitForm">
                                        <div class="nav-align-top mb-4">
                                        <!-- Nav tabs -->
                                        <?php
                                        $menuContent = '';
                                        $menuTab = ''; 
                                        $tabContentActive = $tabActive = 'active';
                                        
                                        foreach(registerNavBarMenu() as $menuKey => $menuValue)
                                        {
                                            $menuTab .= '
                                            <li class="nav-item">
                                              <button
                                                type="button"
                                                class="nav-link '.$tabActive.'"
                                                role="tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#'.$menuKey.'"
                                                aria-controls="'.$menuKey.'"
                                                aria-selected="true"
                                              >
                                                '.$menuValue.'
                                              </button>
                                            </li>';
                                            $menuID = $menuKey.'List';
                                            $nestedID = $menuKey.'Nested';
                                            ob_start();
                                                ?>
                                                <div class="tab-pane fade show getActive <?php echo $tabContentActive ?>" id="<?php echo $menuKey ?>" role="tabpanel">
                                                    <div class="row">
                                                        <div class="dd" id="<?php echo $nestedID ?>">
                                                            <ol class="dd-list" id="<?php echo $menuID; ?>">
                                                                <?php echo (isset($menusHtml[$menuKey])?$menusHtml[$menuKey]:'') ?>
                                                            </ol>
                                                        </div>
                                                    </div>
                                                    <script>
                                                        jQuery(document).ready(function($){
                                                            var updateOutput = function (e) {
                                                                var list = e.length ? e : $(e.target), output = list.data('output');      
                                                            };
                                                            $('#<?php echo $nestedID ?>').nestable({
                                                                group: 1,
                                                                maxDepth: 3,
                                                            });  
                                                        });
                                                    </script>
                                                </div>
                                                <?php
                                            $menuContent .= ob_get_clean();
                                            $tabContentActive = $tabActive = '';
                                        }    
                                        ?>                                            
                                        <ul class="nav nav-tabs" role="tablist">                                       
                                            <?php echo $menuTab; ?>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">                                          
                                                <?php echo $menuContent; ?>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-footer text-muted">
                                            <div class="row pull-right">
                                                <button type="submit" class="btn btn-primary">Save Menu</button> 
                                            </div>    
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    jQuery(document).ready(function(){
        $('.close-assoc-file').on('mousedown', function(event) {
            event.preventDefault();
            var parentli = $(this).closest('li.dd-item');
            var dataAttr = parentli.data();
            var id =$('.getActive.active').attr('id');
            $.ajax({
                url: '<?php echo route('delete.menu') ?>',
                type: 'GET',
                data: {
                    targettype: dataAttr.targettype,
                    target: dataAttr.target,
                    post_id: dataAttr.post_id,
                    link_id: dataAttr.link_id,
                    relation: id,
                },
            });        
            if (parentli.find('ol.dd-list').length > 0) {
                var innerHtml = parentli.find('ol.dd-list').html();
                parentli.after(innerHtml);
            }
            parentli.remove();
            return false;
        });
        $('.formAddMenu').on('submit',function(event){
            event.preventDefault()
            var id =$('.getActive.active').attr('id');
            let selectedArray = [];
            var form = $(this).closest('.formAddMenu').find('.menuCheckBox:checked');
            $(form).each(function () {
                var target = $(this).attr('data-target')
                var targetType = $(this).attr('data-targetType');
                let Items = '<li class="dd-item" data-link_id="0" data-target="'+target+'" data-targetType="'+targetType+'" data-post_id="'+$(this).val()+'" data-id="'+$(this).val()+'">'+
                                '<div class="dd-handle">'+$(this).data('name')+'</div>'+
                            '</li>'
                $('#'+id+'List').append(Items)
            });
        });  
   
        $('.submitForm').on('submit',function(event){
            event.preventDefault();
            var id =$('.getActive.active').attr('id');
            var menuOrder = $('.getActive.active .dd').nestable('serialize');
            
            $.ajax({
                url:'<?php echo route('add.menu') ?>',
                method:'POST',
                data:{
                    'relation' : id,
                    'menuOrder' : menuOrder 
                },
                success:function(response){
                    window.location.reload();
                }
            });
        })
    });

</script>