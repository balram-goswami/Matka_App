<?php

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{Option, Terms};

function getThemeOptions($optionName){
    $options = Option::where('option_name',$optionName)->pluck('option_value')->first();
    return $optionData = maybe_decode($options);
    
}

function updateOption($optionKey = null, $optionValue = null){
    if ($option = Option::where('option_name', $optionKey)->get()->first()) {
        $option->option_value = maybe_encode($optionValue);
        $option->updated_at = new DateTime;
        $option->save();
    }else{
        $option = new Option;
        $option->option_name = $optionKey;
        $option->option_value = maybe_encode($optionValue);
        $option->created_at = new DateTime;
        $option->updated_at = new DateTime;
        $option->save();
    }
}
function themeFieldArray()
{
    $sliderCategories = \App\Models\Terms::select('slug', 'name')->where('term_group', 'slider_category')->get();
    $sliderCategoriesOptions = [];
    foreach ($sliderCategories as $sliderCategorie) {
        $sliderCategoriesOptions[$sliderCategorie->slug] = $sliderCategorie->name;
    }

    return [
        [
            'key' => 'header',
            'title' => 'Header',
            'icon' => '<i class="fa fa-cog" aria-hidden="true"></i>',
            'fields' => 
            [
                [
                    'title' =>'logo',
                    'id' => 'headerlogo',
                    'type' => 'FilesUpload',
                    'slug'=>'header',
                    'placeholder' => 'Upload Logo',
                    'default' => '',
                ], 
                [
                    'title' =>'Favicon',
                    'id' => 'headerfavicon',
                    'type' => 'FilesUpload',
                    'slug'=>'favicon',
                    'placeholder' => 'Upload Favicon',
                    'default' => '',
                ], 
                [
                    'title' =>'Meta Title',
                    'id' => 'meta_title',
                    'type' => 'text',
                    'placeholder' =>'Meta Title',
                    'default' => '',
                ],
                [
                    'title' =>'Meta Description',
                    'id' => 'meta_description',
                    'type' => 'text',
                    'placeholder' =>'Meta Description',
                    'default' => '',
                ],
            ]
        ],
        [
            'key' => 'payment',
            'title' => 'Payment Options',
            'icon' => '<i class="fa fa-cog" aria-hidden="true"></i>',
            'fields' =>
            [
                [
                    'title' =>'QR Pay',
                    'id' => 'qrpic',
                    'type' => 'FilesUpload',
                    'slug'=>'bannerLogo',
                    'placeholder' => 'QR for Payment',
                    'default' => '',
                ],
                [
                    'title' =>'UPI Id',
                    'id' => 'upiId',
                    'type' => 'text',
                    'placeholder' =>'UPI Id',
                    'default' => '',
                ],
                [
                    'title' =>'Bank Name',
                    'id' => 'bank_name',
                    'type' => 'text',
                    'placeholder' =>'Bank Name',
                    'default' => '',
                ],
                [
                    'title' =>'Account Holder Name',
                    'id' => 'holdername',
                    'type' => 'text',
                    'placeholder' =>'Account Holder Name',
                    'default' => '',
                ],
                [
                    'title' =>'Bank AC No',
                    'id' => 'account_no',
                    'type' => 'text',
                    'placeholder' =>'AC no',
                    'default' => '',
                ],
                [
                    'title' =>'IFSC Code',
                    'id' => 'ifsc',
                    'type' => 'text',
                    'placeholder' =>'IFSC Code',
                    'default' => '',
                ],
            ]
        ],
        [
            'key' => 'homePage',
            'title' => 'Home Page',
            'icon' => '<i class="fa fa-cog" aria-hidden="true"></i>',
            'fields' =>
            [
                // Banner Section
                [
                    'title' =>'Banner 1',
                    'id' => 'banner1',
                    'type' => 'FilesUpload',
                    'slug'=>'banner1',
                    'placeholder' => 'Banner',
                    'default' => '',
                ],
                [
                    'title' =>'Banner 2',
                    'id' => 'banner2',
                    'type' => 'FilesUpload',
                    'slug'=>'banner2',
                    'placeholder' => 'Banner',
                    'default' => '',
                ],
                [
                    'title' =>'Banner 3',
                    'id' => 'banner3',
                    'type' => 'FilesUpload',
                    'slug'=>'banner3',
                    'placeholder' => 'Banner',
                    'default' => '',
                ],
                [
                    'title' =>'Banner Text',
                    'id' => 'bannerText1',
                    'type' => 'text',
                    'placeholder' =>'Banner Text',
                    'default' => '',
                ], 
                [
                    'title' =>'Banner Text',
                    'id' => 'bannerText2',
                    'type' => 'text',
                    'placeholder' =>'Banner Text',
                    'default' => '',
                ], 
                
            ]
        ],
        [
            'key' => 'betSetting',
            'title' => 'Betting Min Price',
            'icon' => '<i class="fa fa-cog" aria-hidden="true"></i>',
            'fields' =>
            [
                [
                    'title' => 'Game Status',
                    'id' => 'status',
                    'type' => 'select',
                    'placeholder' => 'Game Status',
                    'default' => '',
                    'options' => [
                        'on' => 'Game On',
                        'off' => 'Game Off',
                    ],
                ],
                [
                    'title' =>'Choice Game min Bet',
                    'id' => 'choiceGameMin',
                    'type' => 'number',
                    'placeholder' =>'Enter Amount',
                    'default' => '',
                ], 
                [
                    'title' =>'Choice Game Max Bet',
                    'id' => 'choiceGameMax',
                    'type' => 'number',
                    'placeholder' =>'Enter Amount',
                    'default' => '',
                ], 
                [
                    'title' =>'Jodi Game Min Bet',
                    'id' => 'jodiGameMin',
                    'type' => 'number',
                    'placeholder' =>'Enter Amount',
                    'default' => '',
                ],
                [
                    'title' =>'Jodi Game Max Bet',
                    'id' => 'jodiGameMax',
                    'type' => 'number',
                    'placeholder' =>'Enter Amount',
                    'default' => '',
                ],
                [
                    'title' =>'HARF Game Min Bet',
                    'id' => 'harfGameMin',
                    'type' => 'number',
                    'placeholder' =>'Enter Amount',
                    'default' => '',
                ],
                [
                    'title' =>'HARF Game Max Bet',
                    'id' => 'harfGameMax',
                    'type' => 'number',
                    'placeholder' =>'Enter Amount',
                    'default' => '',
                ],
                [
                    'title' =>'Crossing Game Min Bet',
                    'id' => 'crossingGameMin',
                    'type' => 'number',
                    'placeholder' =>'Enter Amount',
                    'default' => '',
                ],
                [
                    'title' =>'Crossing Game Max Bet',
                    'id' => 'crossingGamemax',
                    'type' => 'number',
                    'placeholder' =>'Enter Amount',
                    'default' => '',
                ],
                [
                    'title' =>'ODD Even Game Min Bet',
                    'id' => 'oddevenGameMin',
                    'type' => 'number',
                    'placeholder' =>'Enter Amount',
                    'default' => '',
                ],
                [
                    'title' =>'ODD Even Game Max Bet',
                    'id' => 'oddevenGameMax',
                    'type' => 'number',
                    'placeholder' =>'Enter Amount',
                    'default' => '',
                ],
                                 
            ]
        ],
    ];
}

function FilesUpload($slug,$id,$placeholder,$title,$default,$old){

    return '<div class="col-md-12 imageUploadGroup">
            <label class="col-form-label" for="'.$title.'">'.$title.'</label><br>
            <img src="'.publicPath($old).'" class="file-upload" id="'.$slug.'-img" style="width: 100px; height: 100px;">
            <button type="button" data-eid="'.$slug.'" class="btn btn-success setFeaturedImage">Select image</button>
            <button type="button" data-eid="'.$slug.'"  class="btn btn-warning removeFeaturedImage">Remove image</button>
            <input type="hidden" name="'.$id.'" id="'.$slug.'" value="'.$old.'">
        </div>';
}

function number($id,$placeholder,$title,$default,$old){
    return  '<div class="input-group row">
                <label class="col-form-label" for="'.$title.'">'.$title.'</label><br>
                    <input type="number" name="'.$id.'" required="" id="'.$id.'" class="form-control form-control-lg" placeholder="'.$placeholder.'" value="'.$old.'">
                    <span class="md-line"></span>
            </div>';
}

function text($id,$placeholder,$title,$default,$old){
    return  '<div class="input-group row">
                <label class="col-form-label" for="'.$title.'">'.$title.'</label><br>
                    <input type="text" name="'.$id.'" required="" id="'.$id.'" class="form-control form-control-lg" placeholder="'.$placeholder.'" value="'.$old.'">
                    <span class="md-line"></span>
            </div>';
}
function datebox($id,$placeholder,$title,$default,$old){
    return  '<div class="input-group row">
                <label class="col-form-label" for="'.$title.'">'.$title.'</label><br>
                    <input type="text" name="'.$id.'" required="" id="'.$id.'" class="form-control datePicker form-control-lg" placeholder="'.$placeholder.'" value="'.$old.'">
                    <span class="md-line"></span>
            </div>';
}
function email($id,$placeholder,$title,$old){
    return '<div class="input-group row">
                <label class="col-form-labemailel" for="'.$id.'">'.$title.'</label><br>
                    <input type="email" name="'.$id.'" required="" id="'.$id.'" class="form-control form-control-lg" placeholder="'.$placeholder.'" value="'.$old.'">
                    <span class="md-line"></span>
            </div>';

}

function checkbox($id,$placeholder,$title, $options,$old){
    $checkBox = '<div class="input-group row">
    <label class="col-form-label col-md-12" style="padding-left:0px;" for="">'.$title.'</label><br>';
    $count = 0;
    foreach($options as $key => $value){
        $checkBox .='
            <label for="'.str_slug($id, '-').'-'.$count.'" class="col-form-label col-md-1 " style="padding-left:0px;">'.$value.'&nbsp;<input '.(is_array($old) && in_array($value, $old)?'checked':'').' type="checkbox" name="'.$id.'[]" style="width:auto;float:right; margin-top: 6px;" required="" id="'.str_slug($id, '-').'-'.$count.'" value="'.$value.'"></label>';
            $count++;
    }
    $checkBox .= '<span class="md-line"></span> </div>';
    return  $checkBox;
}
function radio($id,$placeholder,$title, $options,$old){
    $radioButtonArrayData='';
    foreach($options as $key=>$value){
        $count= $key+1;
        $radioButtonArrayData.='<div class="input-group row">
                                    <label class="col-form-label" for="'.$value["id"].'">'.$value["title"].'</label><br>
                                    <input type="radio" name="'.$value["id"].'[]" required="" id="'.$value["id"].'_'.$count.'" class="form-control form-control-lg" value="">
                                    <span class="md-line"></span>
                                </div>';
    }
    return  $radioButtonArrayData;
}
function select($id,$placeholder,$title, $selectOptions,$old){
    $options='';
    foreach($selectOptions as $key=>$value){
        $options.='<option value="'.$key.'" '.($old == $key?'selected':'').'>'.$value.'</option>';
    }

    return '<div class="input-group row">
                 <label class="col-form-label" for="'.str_slug($id, '-').'">'.$title.'</label><br>
                    <select required="" id="'.str_slug($id, '-').'" class="form-control form-control-lg" name="'.$id.'">
                    <option value="">Select</option>
                    '.$options.'
                    </select>
                    <span class="md-line"></span>
            </div>';

}
function selectMultiple($id,$placeholder,$title, $selectOptions,$old){
    $options='';
    if (!$old) {
        $old = [];
    }
    foreach($selectOptions as $key=>$value){
        $options.='<option value="'.$key.'" '.(in_array($key, $old)?'selected':'').'>'.$value.'</option>';
    }

    return '<div class="input-group row">
                 <label class="col-form-label" for="'.str_slug($id, '-').'">'.$title.'</label><br>
                    <select required="" id="'.str_slug($id, '-').'" multiple class="form-control form-control-lg" name="'.$id.'[]">
                    <option value="">Select</option>
                    '.$options.'
                    </select>
                    <span class="md-line"></span>
            </div>';

}
function textarea($id,$placeholder,$title,$old){
    return '<div class="input-group row">
                <label class="col-form-label" for="'.$id.'">'.$title.'</label><br>
                <textarea name="'.$id.'" required="" id="'.$id.'" class="form-control form-control-lg" placeholder="'.$placeholder.'" rows="5">'.$old.'</textarea>
                <span class="md-line"></span>
            </div>';
}
function textareaBig($id,$placeholder,$title,$old){
    return '<div class="input-group row">
                <label class="col-form-label" for="'.$id.'">'.$title.'</label><br>
                <textarea name="'.$id.'" rows="60" required="" id="'.$id.'" class="form-control form-control-lg" placeholder="'.$placeholder.'" rows="5">'.$old.'</textarea>
                <span class="md-line"></span>
            </div>';
}

function ThemeSidebarOptions(){
    $tabs = themeFieldArray();
	$activeTab = 'active';
	$activeTabContent = 'in active';
	$sidebarTabList = '';
	$sidebarTabContent = '';
	foreach ($tabs as $row) {
        $sidebarTabList .= '<li class="nav-item">
                                <button
                                  type="button"
                                  class="nav-link '.$activeTab.'"
                                  role="tab"
                                  data-bs-toggle="tab"
                                  data-bs-target="#'.$row['key'].'"
                                  aria-controls="'.$row['key'].'"
                                  aria-selected="true"
                                >
                                  '.$row['title'].'
                                </button>
                          </li>';

        $sidebarTabContent .= '<div class="tab-pane fade show '.$activeTabContent.'" id="'.$row['key'].'" role="tabpanel">
            <h3>'.$row['title'].'</h3>';
                foreach($row['fields'] as $key => $value)
                {
                    $oldData = getThemeOptions($row['key']);
                    $id = $value['id'];
                    $passingOldData = (isset($oldData[$id])?$oldData[$id]:'');
                    $sidebarTabContent .=inputFields($row['key'],$value['type'],$value,$passingOldData);
                }   
                                 
        $sidebarTabContent.='</div>';

		$activeTab = '';
		$activeTabContent = '';
    }
    return '<div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">'.$sidebarTabList.'</ul>            
                <div class="tab-content">
                    '.$sidebarTabContent.'
                </div>
            </div>';

}

function inputFields($key,$field,$fieldOptions,$oldData){
    $inputName=$key.'['.$fieldOptions['id'].']';
    $inputSlug=$fieldOptions['id'];
    switch($field){
        case 'text':
            return text($inputName,$fieldOptions['placeholder'],$fieldOptions['title'],$fieldOptions['default'],$oldData);
            break;
        case 'datebox':
            return datebox($inputName,$fieldOptions['placeholder'],$fieldOptions['title'],$fieldOptions['default'],$oldData);
            break;
        case 'email':
            return email($inputName,$fieldOptions['placeholder'],$fieldOptions['title'],$fieldOptions['default'],$oldData);
            break;
        
        case 'textarea':
            return textarea($inputName,$fieldOptions['placeholder'],$fieldOptions['title'],$oldData);    
            break; 

        case 'textareaBig':
            return textareaBig($inputName,$fieldOptions['placeholder'],$fieldOptions['title'],$oldData);    
            break; 

        case 'FilesUpload':
            return FilesUpload($inputSlug,$inputName,$fieldOptions['placeholder'],$fieldOptions['title'],$fieldOptions['default'],$oldData);
            break;
        case 'number':
            return number($inputName,$fieldOptions['placeholder'],$fieldOptions['title'],$fieldOptions['default'],$oldData);
            break;
        case 'checkbox':
            return checkbox($inputName,$fieldOptions['placeholder'],$fieldOptions['title'], $fieldOptions['options'],$oldData);    
            break;

        case 'select':
            return select($inputName,$fieldOptions['placeholder'],$fieldOptions['title'], $fieldOptions['options'],$oldData);
        case 'selectMultiple':
            return selectMultiple($inputName,$fieldOptions['placeholder'],$fieldOptions['title'], $fieldOptions['options'],$oldData);  
        case 'radio':
            return;
        default:
            return;                
    }
}