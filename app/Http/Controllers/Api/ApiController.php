<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Posts,
    Comment,
    Option,
    Links,
    Terms,
    TermRelations,
    Enquiry,
    Subscibers,
    ProductOrder,
    ApplyNow
};

use Validator, DateTime, Config, Helpers, Hash, DB, Session, Auth, Redirect;

use App\Services\{CommunicationService, ApiService};

class ApiController extends Controller
{
    protected $communicationService;
    protected $apiService;
    public function __construct(CommunicationService $communicationService , ApiService $apiService) {
        $this->communicationService = $communicationService;
        $this->apiService = $apiService;
    }

    public function index(ApiService $apiService)
    {
        $data = $apiService->fetchDataFromPasswordProtectedAPI();
        $view = 'Templates.ApiData';
        
        return view('Front', compact('view','data'));
    }


    public function getCommonData(){
        $headerOptions = getThemeOptions('header');
        $footerOption = getThemeOptions('footer'); 
        $headerMenus = self::getChildMenus('primary_menu'); 
        $footerMenus = self::getChildMenus('footer_main_menu'); 
        $servicesMenus = self::getChildMenus('footer_service_menu'); 
        return Response()->json(compact('headerMenus','headerOptions','footerOption','footerMenus','servicesMenus'),200);
    } 
    public function getContactData() {
        $contactUs = getThemeOptions('contact_us');
        return Response()->json(compact('contactUs'),200);
    }
    public static function getChildMenus($menufor) {  
        $menuOptions = Links::where('link_visible','Y')->where('link_parent', 0)->where('links.link_rel',$menufor)->orderBy('link_order', 'ASC')->get();
        $menus = [];
        foreach($menuOptions as $menuOption) {
            if (in_array($menuOption->target_type, ['page'])) {
               $menuOption->target_type = '';
            }
            if (in_array($menuOption->target_type, ['post'])) {
               $menuOption->target_type = 'blog';
            }
            if (in_array($menuOption->target_type, ['category','tag'])) {
               $menuOption->link_target = 'blog';
            }
            if (in_array($menuOption->link_target, ['post'])) {
               $menuOption->link_target = '';
            }
            if (in_array($menuOption->target_type, ['gallery_category'])) {
               $menuOption->link_target = 'gallery';
               $menuOption->target_type = 'gallery-category';
            }

            $childMenuOptions = Links::where('link_visible','Y')->where('link_parent', $menuOption->id)->where('links.link_rel',$menufor)->orderBy('link_order', 'ASC')->get();

            $menus[] = [
                'link_name' => $menuOption->link_name,
                'link_url' => ($menuOption->link_target?'/'.$menuOption->link_target.'/'.$menuOption->target_type:($menuOption->target_type?'/'.$menuOption->target_type:'')).'/'.$menuOption->link_url,
                'childMenus' => self::getInnerChildMenu($childMenuOptions)
            ];  
        }
        return $menus;
    }
    public static function getInnerChildMenu($menuOptions)
    {
        $menus = [];
        foreach($menuOptions as $menuOption) {
            if (in_array($menuOption->target_type, ['page'])) {
               $menuOption->target_type = '';
            }
            if (in_array($menuOption->target_type, ['post'])) {
               $menuOption->target_type = 'blog';
            }
            if (in_array($menuOption->target_type, ['category','tag'])) {
               $menuOption->link_target = 'blog';
            }
            if (in_array($menuOption->link_target, ['post'])) {
               $menuOption->link_target = '';
            }
            if (in_array($menuOption->target_type, ['gallery_category'])) {
               $menuOption->link_target = 'gallery';
               $menuOption->target_type = 'gallery-category';
            }
            $menus[] = [
                'link_name' => $menuOption->link_name,
                'link_url' => ($menuOption->link_target?'/'.$menuOption->link_target.'/'.$menuOption->target_type:($menuOption->target_type?'/'.$menuOption->target_type:'')).'/'.$menuOption->link_url
            ];   
        }
        return $menus;
    }
    public function getHomeData() {
        $homePage = getThemeOptions('homePage');

        $categoryCount = (isset($homePage['categoryCount'])?$homePage['categoryCount']:3);
        $galleryCount = (isset($homePage['galleryCount'])?$homePage['galleryCount']:3);
        $funFactCount = (isset($homePage['funFactCount'])?$homePage['funFactCount']:3);
        $testimonialsCount = (isset($homePage['testimonialsCount'])?$homePage['testimonialsCount']:3);
        $instructorsCount = (isset($homePage['instructorsCount'])?$homePage['instructorsCount']:3);
        $partnersCount = (isset($homePage['partnersCount'])?$homePage['partnersCount']:3);
        $blogCount = (isset($homePage['blogCount'])?$homePage['blogCount']:3);

        $sliders = getPostsByPostType('slider', 5, 'order', false);
        $categories = getTerms('category', 'post', $categoryCount);
        $galleries = getPostsByPostType('gallery', $galleryCount, 'new', false);
        $funfacts = getPostsByPostType('funfacts', $funFactCount, 'new', false);
        $testimonials = getPostsByPostType('testimonials', $testimonialsCount, 'new', false);
        $instructors = getPostsByPostType('instructors', $instructorsCount, 'new', false);
        $patners = getPostsByPostType('patners', $partnersCount, 'new', false);
        $blogs = getPostsByPostType('post', $blogCount, 'new', false);

        return Response()->json(compact('homePage','sliders','categories','galleries','funfacts','testimonials','instructors','patners','blogs'), 200);
    }
    public function singleTemplate($page) {
        $page = Posts::where('posts.post_name', $page)
                    ->leftJoin('posts as getImage','getImage.post_id','posts.guid')
                    ->leftJoin('users as user','user.user_id','posts.user_id')
                    ->select('posts.*','getImage.media as post_image', 'user.name as user_name','getImage.post_title as post_image_alt')
                    ->where('posts.post_status', 'publish')
                    ->get()->first();
        if ($page) {
            $page->extraFields = getPostMeta($page->post_id);
            $page->posted_date = date('M d, Y', strtotime($page->created_at));
            $page->posted_time = date('h:i A', strtotime($page->created_at));
        }                
        return Response()->json($page, 200);
    }
    public function getPosts(Request $request) {
        $posts = getPostsByPostType($request->post_type, $request->limit, null, ($request->extraData == 'yes'?true:false), ($request->page?true:false));
        return Response()->json(compact('posts'), 200);
    }
    public function getTerms(Request $request) {
        $terms = getTerms($request->term_group, $request->post_type, $request->limit);
        return Response()->json(compact('terms'), 200);
    }
    public function getTerm($termSlug) {
        $term = \App\Models\Terms::where('slug', $termSlug)->first();
        return Response()->json(compact('term'), 200);
    }
    public function saveContactFormData(Request $request){       
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'mobile' => 'required|numeric',
                'email' => 'required|email',
                'message' => 'required|string',
            ]);       
        if($validator->fails()){
            return Response()->json(['message'=>$validator->getMessageBag()->first()], 422);
        }       
        $form  = new Enquiry;
        $form->name = $request->name;
        $form->email = $request->email;
        $form->mobile = $request->mobile;
        $form->message = $request->message;
        $form->save();
        $emailBody = view('Email.EnquiryRequest', compact('enquiry'));

        $this->communicationService->mail(adminEmail(), 'Enquiry (Matka)', $emailBody, [], '', '', '', '');
        return Response()->json(['message' => 'Thanks for connecting'],200);
    }
    public function subscribeUs(Request $request){       
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email'
            ]);      
        if($validator->fails()){
            return Response()->json(['message'=>$validator->getMessageBag()->first()], 422);
        }       
        $form  = new Subscibers;
        $form->email = $request->email;
        $form->save();

        $emailBody = view('Email.SubscribeRequestAdmin', compact('subsciber'));

        $this->communicationService->mail(adminEmail(), 'New Subscription', $emailBody, [], '', '', '', '');

        $emailBody2 = view('Email.SubscribeRequest', compact('subsciber'));

        $this->communicationService->mail($subsciber->email, 'Subscriptions (Matka)', $emailBody2, [], '', '', '', '');

        return Response()->json(['message' => 'Thanks for subscribing'],200);
    }
    public function saveApplyNowFormData(Request $request){       
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'phone' => 'required|numeric|unique:apply_nows',
                'email' => 'nullable|email|unique:apply_nows',
                'class' => 'required|string',
                'address' => 'required|string',
            ]);       
        if($validator->fails()){
            return Response()->json(['message'=>$validator->getMessageBag()->first()], 422);
        }      
        $enquiry  = new ApplyNow;
        $enquiry->name = $request->name;
        $enquiry->email = $request->email;
        $enquiry->phone = $request->phone;
        $enquiry->class = $request->class;
        $enquiry->address = $request->address;
        $enquiry->save();

        $emailBody = view('Email.ApplyNowRequestAdmin', compact('enquiry'));

        $this->communicationService->mail(adminEmail(), 'New Applied Request', $emailBody, [], '', '', '', '');

        return Response()->json(['message' => 'Thanks for connecting'],200);
    }
}
