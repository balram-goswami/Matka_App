<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB, DateTime, Session, Redirect, Auth;
use App\Models\Posts;
use App\Models\Terms;
use App\Models\Links;
use App\Models\PostMetas;
use App\Models\TermRelations;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index(Request $request)
    {
        $view = 'Admin.Post.Index';
        $postType = $request->get('postType');
        $postTitle = getPostType($postType);
        $userId = getCurrentUser();
        
        if (empty($postTitle)) {
            Session::flash ( 'warning', "Something went wrong, Please try after sometime." );
            return redirect()->route('dashboard.index');  
        }
        $posts = Posts::where('post_type', $postType)
                    ->where('user_id', $userId->user_id)
                    ->select('*', DB::raw("(SELECT name FROM users where users.user_id = posts.user_id LIMIT 0, 1) as post_author"))
                    ->where(function($query){
                        if (Request()->get('post_title')) {
                            $query->where('post_title', 'LIKE', '%'.Request()->get('post_title').'%');
                        }
                        if (Request()->get('post_status')) {
                            $query->where('post_status', 'LIKE', '%'.Request()->get('post_status').'%');
                        } else {
                            $query->where('post_status', '!=', 'trash');
                        }
                    })                    
                    ->orderBy('menu_order', 'ASC')
                    ->paginate(pagination());
        if (!empty($postTitle['taxonomy']) && is_array($postTitle['taxonomy'])) {
            foreach ($posts as $post) {
                $termCollections = [];
                foreach ($postTitle['taxonomy'] as $taxonomyKey => $taxonomyValue) {
                    $termRelations = TermRelations::where('object_id', $post->post_id)->select('term_id');
                    $terms = Terms::where('term_group', $taxonomyKey)->whereIn('id', $termRelations)->select('name')->get();
                    $termCollection = [];
                    foreach ($terms as $term) {
                        $termCollection[] = $term->name;
                    }
                    $termCollections[$taxonomyKey] = implode(',<br>', $termCollection);
                }   
                $post->category = $termCollections;
            }
        }    
        return view($postTitle['area'], compact('view','postTitle','postType','posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $view = 'Admin.Post.Create';
        $projectCategory=[];
        $postType = $request->get('postType');
        $postTitle = getPostType($postType);
        if (empty($postTitle)) {
            Session::flash ( 'warning', "Something went wrong, Please try after sometime." );
            return redirect()->route('dashboard.index');  
        }
        return view($postTitle['area'], compact('view','postTitle','postType','projectCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $langauge = $request->input('langauge');

        $postType = $request->get('postType');
        $postTitle = getPostType($postType);
        $title = ($request->input('post_title')?$request->input('post_title'):'draft');
        if (empty($postTitle)) {
            Session::flash ( 'warning', "Something went wrong, Please try after sometime." );
            return redirect()->route('dashboard.index');  
        }
        $postCount = Posts::where('post_title', $title)->get()->count();
        if ($postCount > 0) {
            $post_name = $title.' '.$postCount;
        }else{
            $post_name = $title;
        }
        if($request->input('createSiteMap') == 'yes'){
            $postUrl = '';
            if (in_array($postType, ['page'])) {
                $postUrl = siteUrl().'/'.$post_name;
            } else {
                $postUrl = siteUrl().'/'.$postType.'/'.$post_name;
            }
            createUpdateSiteMapXML($postUrl);
        }      
        if($request->input('createSiteMap') == 'no'){
            $postUrl = '';
            if (in_array($postType, ['page'])) {
                $postUrl = siteUrl().'/'.$post_name;
            } else {
                $postUrl = siteUrl().'/'.$postType.'/'.$post_name;
            }
            deleteSiteMapXML($postUrl);
        }   

        $post_name = str_slug($post_name, '-');
        $post = new Posts();
        $post->post_title = $title;
        $post->post_name = $post_name;
        $post->user_id = Auth::user()->user_id;
        $post->post_content = $request->input('post_content');
        $post->post_excerpt = $request->input('post_excerpt');
        $post->post_status = $request->input('post_status');
        $post->post_parent = 0;
        $post->comment_status = $request->input('comment_status');
        $post->guid = $request->input('guid');
        $post->post_template = $request->input('post_template');
        $post->menu_order = 0;
        $post->post_type = $postType;
        $post->comment_count = 0;
        $post->created_at = new DateTime;
        $post->updated_at = new DateTime;
        $post->save();

        updatePostMeta($post->post_id, 'meta_Keywords', $request->input('meta_Keywords'));
        updatePostMeta($post->post_id, 'createSiteMap', $request->input('createSiteMap'));
        updatePostMeta($post->post_id, 'meta_title', $request->input('meta_title'));
        updatePostMeta($post->post_id, 'meta_description', $request->input('meta_description'));
        
        self::insertUpdateTerms($post->post_id);
        insertUpdatePostMetaBox($postType, $request, $post->post_id);

        Session::flash ( 'success', $postTitle['title']." saved." );
        return Redirect::route('post.index', ['postType'=>$postType]);  
    }
    public static function insertUpdateTerms($post_id){
        $terms = Request()->input('terms');
        $notTermIn = [];
        if (!empty($terms) && is_array($terms)) {
            foreach ($terms as $term) {                
                if ($relation = TermRelations::where('term_id', $term)->where('object_id', $post_id)->get()->first()) {
                    $relation->created_at = new DateTime;
                    $relation->term_id = $term;
                    $relation->object_id = $post_id;
                    $relation->updated_at = new DateTime;
                    $relation->save();
                    $notTermIn[] = $relation->term_id;
                }else{
                    $relation = new TermRelations();
                    $relation->created_at = new DateTime;
                    $relation->term_id = $term;
                    $relation->object_id = $post_id;
                    $relation->updated_at = new DateTime;
                    $relation->save();
                    $notTermIn[] = $relation->term_id;
                }
            }
            TermRelations::wherenotIn('term_id', $notTermIn)->where('object_id', $post_id)->delete();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($post_id)
    {
        $view = 'Admin.Post.Edit';
        $post = Posts::find($post_id);
        $postTitle = getPostType($post->post_type);
        $postType = $post->post_type;
        $thumbnail = Posts::where('post_id', $post->guid)->select('media')->get()->pluck('media')->first();
        return view($postTitle['area'], compact('view','post_id','post','thumbnail','postTitle', 'postType'));
    }
    public function clone($post_id = null)
    {
        $clonePost = Posts::find($post_id);
        $title = $clonePost->post_title;
        $post = new Posts();

        $postCount = Posts::where('post_name', $clonePost->post_name)->get()->count();
        if ($postCount > 0) {
            $post_name = $title.' '.$postCount;
        }else{
            $post_name = $title;
        }

        $post_name = str_slug($post_name, '-');
        if (empty($post->post_name)) {
            $post->post_name = $post_name;
        }

        $post->post_title = $title;
        $post->user_id = $clonePost->user_id;
        $post->post_content = $clonePost->post_content;
        $post->post_excerpt = $clonePost->post_excerpt;
        $post->post_status = $clonePost->post_status;
        $post->post_parent = $clonePost->post_parent;
        $post->comment_status = $clonePost->comment_status;
        $post->guid = $clonePost->guid;
        $post->menu_order = 0;
        $post->post_type = $clonePost->post_type;
        $post->post_template = $clonePost->post_template;
        $post->comment_count = 0;
        $post->created_at = new DateTime;
        $post->updated_at = new DateTime;
        $post->save();
        updatePostMeta($post->post_id, 'meta_Keywords', getPostMeta($clonePost->post_id, 'meta_Keywords'));
        updatePostMeta($post->post_id, 'meta_title', getPostMeta($clonePost->post_id, 'meta_title'));
        updatePostMeta($post->post_id, 'meta_description', getPostMeta($clonePost->post_id, 'meta_description'));
        $postTitle = getPostType($post->post_type);
        Session::flash ( 'success', $postTitle['title']." Cloned." );
        return Redirect::route('post.index', ['postType'=>$post->post_type]);  
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $langauge = $request->input('langauge');

        $title = ($request->input('post_title')?$request->input('post_title'):'draft');
        $post = Posts::find($id);

        $postCount = Posts::where('post_title', $title)->get()->count();          

        if($request->input('createSiteMap') == 'yes'){
            $postUrl = '';
            if (in_array($post->post_type, ['page'])) {
                $postUrl = siteUrl().'/'.$post->post_name;
            } else {
                $postUrl = siteUrl().'/'.$post->post_type.'/'.$post->post_name;
            }
            createUpdateSiteMapXML($postUrl);
        }      
        if($request->input('createSiteMap') == 'no'){
            $postUrl = '';
            if (in_array($post->post_type, ['page'])) {
                $postUrl = siteUrl().'/'.$post->post_name;
            } else {
                $postUrl = siteUrl().'/'.$post->post_type.'/'.$post->post_name;
            }
            deleteSiteMapXML($postUrl);
        }

        $post->post_title = $title;
        $post->user_id = Auth::user()->user_id;
        $post->post_content = $request->input('post_content');
        $post->post_excerpt = $request->input('post_excerpt');
        $post->post_status = $request->input('post_status');
        $post->comment_status = $request->input('comment_status');
        $post->guid = $request->input('guid');
        $post->post_template = $request->input('post_template');
        $post->updated_at = new DateTime;
        $post->save();
        self::insertUpdateTerms($post->post_id);
        $post_parent = $post->post_id;
        updatePostMeta($post->post_id, 'meta_Keywords', $request->input('meta_Keywords'));
        updatePostMeta($post->post_id, 'createSiteMap', $request->input('createSiteMap'));
        updatePostMeta($post->post_id, 'meta_title', $request->input('meta_title'));
        updatePostMeta($post->post_id, 'meta_description', $request->input('meta_description'));

        insertUpdatePostMetaBox($post->post_type, $request, $post->post_id);

        $postTitle = getPostType($post->post_type);
        Session::flash ( 'success', $postTitle['title']." updated." );
        return Redirect::back();  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Posts::find($id);
        $post->post_status = 'trash';
        $post->save();
        $link = Links::where('post_id',$id)->update(['link_visible'=>'N']);
        $postTitle = getPostType($post->post_type);
        Session::flash ( 'success', $postTitle['title']." Trashed." );
        return Redirect::route('post.index', ['postType'=>$post->post_type]); 
    }
    public function deleteAll(Request $request)
    {
        $postIds = explode(',', $request->input('postIds'));
        Posts::whereIn('post_id', $postIds)->update(['post_status'=>'trash']);
    }
    public function updateOrder(Request $request){
        $orders = $request->input('order');
        if (!empty($orders) && is_array($orders)) {
            $index = 1;
            foreach ($orders as $order) {
                $post = Posts::find($order);
                $post->menu_order = $index;
                $post->save();
                $index++;
            }
        }
    }
    public function updatePostName(Request $request){
        $post_name = $request->input('post_name');
        $post_id = $request->input('post_id');

        $post = Posts::find($post_id);

        $postCount = Posts::where('post_name', $post_name)->where('post_id','!=',$post_id)->get()->count();
        if ($postCount > 0) {
            $post_name = $post_name.' '.$postCount;
        }
        $post->post_name = str_slug($post_name, '-');
        $post->save();
        return $post->post_name;
    }
    
}
