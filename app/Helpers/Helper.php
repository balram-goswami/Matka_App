<?php

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{
	Countries,
	States,
	Cities,
	Option,
	User,
	WalletCredit,
	WalletTransactions,
	Links,
	Terms,
	Posts,
	VisitorData
};

function appName()
{
	return config('app.name');
}
function siteUrl()
{
	return 'http://127.0.0.1:8000/';
}
function publicPath($url = null)
{
	return asset($url);
}
function assetPath($url = null)
{
	return asset('assets/' . $url);
}
function publicbasePath()
{
	return '/public';
}
function basePath()
{
	return base_path('/public/');
}

function pagination($per_page = 20)
{
	return $per_page ?? 20;
}
function adminBasePath()
{
	return 'admin';
}
function adminEmail()
{
	$admin_settings = getThemeOptions('admin_settings');
	return (isset($admin_settings['admin_email']) ? $admin_settings['admin_email'] : 'admin@gmail.com');
}
function CleanHtml($html = null)
{
	return preg_replace(
		array(
			'/ {2,}/',
			'/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'
		),
		array(
			' ',
			''
		),
		$html
	);
}

function maybe_decode($original)
{
	if (is_serialized($original))
		return @unserialize($original);
	return $original;
}
function is_serialized($data, $strict = true)
{
	if (! is_string($data)) {
		return false;
	}
	$data = trim($data);
	if ('N;' == $data) {
		return true;
	}
	if (strlen($data) < 4) {
		return false;
	}
	if (':' !== $data[1]) {
		return false;
	}
	if ($strict) {
		$lastc = substr($data, -1);
		if (';' !== $lastc && '}' !== $lastc) {
			return false;
		}
	} else {
		$semicolon = strpos($data, ';');
		$brace     = strpos($data, '}');
		if (false === $semicolon && false === $brace)
			return false;
		if (false !== $semicolon && $semicolon < 3)
			return false;
		if (false !== $brace && $brace < 4)
			return false;
	}
	$token = $data[0];
	switch ($token) {
		case 's':
			if ($strict) {
				if ('"' !== substr($data, -2, 1)) {
					return false;
				}
			} elseif (false === strpos($data, '"')) {
				return false;
			}
		case 'a':
		case 'O':
			return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
		case 'b':
		case 'i':
		case 'd':
			$end = $strict ? '$' : '';
			return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
	}
	return false;
}

function maybe_encode($data)
{
	if (is_array($data) || is_object($data))
		return serialize($data);
	if (is_serialized($data, false))
		return serialize($data);
	return $data;
}

function fileuploadmultiple($request)
{
	$files = $request->file('attachments');
	$uploaded_file = [];
	$destinationPath = 'uploads/' . date('Y') . '/' . date('M');
	notExistsCreateDir($destinationPath);
	foreach ($files as $file) {
		$filename = str_replace(array(' ', '-', '`', ','), '_', time() . '_' . $file->getClientOriginalName());
		$upload_success = $file->move($destinationPath, $filename);
		$uploaded_file[] = 'uploads/' . date('Y') . '/' . date('M') . '/' . $filename;
	}
	return $uploaded_file;
}
function fileupload($request)
{
	$file = $request->file('image');
	$destinationPath = 'uploads/' . date('Y') . '/' . date('M');
	// notExistsCreateDir($destinationPath);
	$filename = time() . '_' . $file->getClientOriginalName();
	$upload_success = $file->move($destinationPath, $filename);
	$uploaded_file = 'uploads/' . date('Y') . '/' . date('M') . '/' . $filename;
	return $uploaded_file;
}
function fileuploadExtra($request, $key)
{
	$file = $request->file($key);
	$destinationPath = 'uploads/' . date('Y') . '/' . date('M');
	// notExistsCreateDir($destinationPath);
	$filename = time() . '_' . $file->getClientOriginalName();
	$upload_success = $file->move($destinationPath, $filename);
	$uploaded_file = 'uploads/' . date('Y') . '/' . date('M') . '/' . $filename;
	return $uploaded_file;
}
function fileuploadArray($file)
{
	$destinationPath = 'uploads/' . date('Y') . '/' . date('M');
	// notExistsCreateDir($destinationPath);
	$filename = time() . '_' . $file->getClientOriginalName();
	$upload_success = $file->move($destinationPath, $filename);
	$uploaded_file = 'uploads/' . date('Y') . '/' . date('M') . '/' . $filename;
	return $uploaded_file;
}
function fileuploadUrl($url)
{
	$destinationPath = 'uploads/' . date('Y') . '/' . date('M');
	// notExistsCreateDir($destinationPath);
	$data = str_replace('data:image/jpeg;base64,', '', $url);
	$data = str_replace(' ', '+', $data);
	$data = base64_decode($data); // Decode image using base64_decode
	$file = $destinationPath . '/' . uniqid() . '.jpeg'; // Now you can put this image data to your desired file using file_put_contents function like below:
	$success = file_put_contents($file, $data);
	return $file;
}
function fileuploadLink($url)
{
	$destinationPath = 'uploads/' . date('Y') . '/' . date('M');
	// notExistsCreateDir($destinationPath);
	$data = file_get_contents($url);
	$file = $destinationPath . '/' . uniqid() . '.jpeg';
	$success = file_put_contents($file, $data);
	return $file;
}
function notExistsCreateDir($destinationPath)
{
	if (!file_exists(public_path() . '/' . $destinationPath)) {
		mkdir(public_path() . '/' . $destinationPath);
	}
}
function randomPassword()
{
	return mt_rand(100000, 999999);
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass); //turn the array into a string
}

function getImgAltName($imgUrl)
{
	$postalt = Posts::select('post_name')->where('media', $imgUrl)->first();
	if ($postalt) {
		return $postalt->post_name;
	} else {
		return 'Image';
	}
}
function getApiCurrentUser()
{
	if (Request()->get('Authorization')) {
		request()->headers->set('Authorization', 'Bearer ' . Request()->get('Authorization'));
		return JWTAuth::parseToken()->authenticate();
	}
	if (Request()->header('Authorization')) {
		return JWTAuth::parseToken()->authenticate();
	}
	return new \App\Models\User();
}
function getCurrentUser()
{
	if (Auth::user()) {
		return Auth::user();
	}
	return new \App\Models\User();
}
function getCurrentUserByKey($key)
{
	$user = getApiCurrentUser();
	if (!empty($key)) {
		return isset($user->$key) ? $user->$key : 0;
	}
	return $user;
}
function getCurrentVisitor()
{
	$visitorIp = request()->ip();
	return VisitorData::where('ip_address', $visitorIp)->first();
}
function getUser($user_id)
{
	return DB::table('users')->where('user_id', $user_id)->select('*')->get()->first();
}

function getUserName($user_id)
{
	return DB::table('users')->where('user_id', $user_id)->select('name')->get()->first();
}

function postName($post_id)
{
	return DB::table('posts')->where('post_id', $post_id)->select('post_title')->get()->first();
}

function createUuid($name = 'vendorP')
{
	return Uuid::generate(5, $name, Uuid::NS_DNS);
}
function getPercantageAmount($amount, $percent)
{
	return $amount / 100 * $percent;
}
function getDuration($date)
{
	$time = '';
	$t1 = \Carbon\Carbon::parse($date);
	$t2 = \Carbon\Carbon::parse();
	$diff = $t1->diff($t2);
	if ($diff->format('%y') != 0) {
		$time .= $diff->format('%y') . " Year ";
	}
	if ($diff->format('%m') != 0) {
		$time .= $diff->format('%m') . " Month ";
	}
	if ($diff->format('%d') && $diff->format('%m') == 0) {
		$time .= $diff->format('%d') . " Days ";
	}
	if ($diff->format('%h') != 0 && $diff->format('%m') == 0) {
		$time .= $diff->format('%h') . " Hours ";
	}
	if ($diff->format('%i') != 0 && $diff->format('%d') == 0) {
		$time .= $diff->format('%i') . " Minutes ";
	}
	if ($diff->format('%s') != 0 && $diff->format('%h') == 0) {
		$time .= $diff->format('%s') . " Seconds ";
	}
	return $time;
}
function getDays($startDate = null, $endDate = null)
{
	$time = '';
	$t1 = \Carbon\Carbon::parse($startDate);
	$t2 = \Carbon\Carbon::parse($endDate);
	$diff = $t1->diff($t2);
	return $diff->format('%d');
}
function addDays($date = null, $days = 0)
{
	$date = $date ?? date('Y-m-d');
	return date('Y-m-d', strtotime($date . ' + ' . $days . ' days'));
}
function minusDays($date = null, $days = 0)
{
	$date = $date ?? date('Y-m-d');
	return date('Y-m-d', strtotime('-' . $days . ' days', strtotime($date)));
}
function weekOfMonth($currentMonth)
{
	$stdate = $currentMonth . '-01';
	$enddate = $currentMonth . '-31'; //get end date of month
	$begin = new \DateTime('first day of ' . $stdate);
	$end = new \DateTime('last day of ' . $enddate);
	$interval = new \DateInterval('P1W');
	$daterange = new \DatePeriod($begin, $interval, $end);

	$dates = array();
	foreach ($daterange as $key => $date) {
		$check = ($date->format('W') != $end->modify('last day of this month')->format('W')) ? '+6 days' : 'last day of this week';
		$dates[$key + 1] = array(
			'start' => $date->format('Y-m-d'),
			'end' => ($date->modify($check)->format('Y-m-d')),
		);
		if ($dates[$key + 1]['end'] > date('Y-m-d', strtotime($enddate))) {
			$dates[$key + 1]['end'] = date('Y-m-d', strtotime($enddate));
		}
	}
	return $dates;
}
function datesRange($first, $last, $diffDays = 1, $output_format = 'd-m-Y')
{
	$step = '+' . $diffDays . ' day';
	$dates = array();
	$current = strtotime($first);
	$last = strtotime($last);

	while ($current <= $last) {

		$dates[] = date($output_format, $current);
		$current = strtotime($step, $current);
	}

	return $dates;
}
function getLatLong($address = null)
{
	$latLong = [];
	$latLong['lattitude'] = '';
	$latLong['longitude'] = '';
	if (!empty($address)) {
		$address = str_replace(" ", "+", $address);
		$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=AIzaSyCjEHaWgv-lmblYJ-m0fp3lwfrWrgzQEPE&address=" . urlencode($address) . "&sensor=false");
		$json = json_decode($json);
		if ($json->status == 'OK') {
			$latLong['lattitude'] = $json->results[0]->geometry->location->lat;
			$latLong['longitude'] = $json->results[0]->geometry->location->lng;
		}
	}
	return $latLong;
}
function address($user)
{
	$address = [];
	if (isset($user->address) && !empty($user->address)) {
		$address[] = $user->address;
	}
	if (isset($user->city) && !empty($user->city)) {
		$address[] = $user->city;
	}
	if (isset($user->state) && !empty($user->state)) {
		$address[] = $user->state;
	}
	if (isset($user->country) && !empty($user->country)) {
		$address[] = $user->country;
	}
	return implode(',', $address);
}
function bindAddress($user)
{
	$address = [];
	if (isset($user->address) && !empty($user->address)) {
		$address[] = $user->address;
	}
	if (isset($user->city) && !empty($user->city)) {
		$address[] = $user->city;
	}
	if (isset($user->state) && !empty($user->state)) {
		$address[] = $user->state;
	}
	if (isset($user->country) && !empty($user->country)) {
		$address[] = $user->country;
	}
	$address = implode(' ', $address);
	echo str_replace(" ", "+", $address);
}
function get_client_ip()
{
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if (isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if (isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if (isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}
function ip_info($purpose = "location", $deep_detect = TRUE)
{
	$output = NULL;
	$ip = $_SERVER['REMOTE_ADDR'];
	if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
		$ip = $_SERVER["REMOTE_ADDR"];
		if ($deep_detect) {
			if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
				$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
	}
	$purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
	$support    = array("country", "countrycode", "state", "region", "city", "location", "address");
	$continents = array(
		"AF" => "Africa",
		"AN" => "Antarctica",
		"AS" => "Asia",
		"EU" => "Europe",
		"OC" => "Australia (Oceania)",
		"NA" => "North America",
		"SA" => "South America"
	);
	if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
		$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

		if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
			switch ($purpose) {
				case "location":
					$output = array(
						"city"           => @$ipdat->geoplugin_city,
						"state"          => @$ipdat->geoplugin_regionName,
						"country"        => @$ipdat->geoplugin_countryName,
						"country_code"   => @$ipdat->geoplugin_countryCode,
						"continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
						"continent_code" => @$ipdat->geoplugin_continentCode
					);
					break;
				case "address":
					$address = array($ipdat->geoplugin_countryName);
					if (@strlen($ipdat->geoplugin_regionName) >= 1)
						$address[] = $ipdat->geoplugin_regionName;
					if (@strlen($ipdat->geoplugin_city) >= 1)
						$address[] = $ipdat->geoplugin_city;
					$output = implode(", ", array_reverse($address));
					break;
				case "city":
					$output = @$ipdat->geoplugin_city;
					break;
				case "state":
					$output = @$ipdat->geoplugin_regionName;
					break;
				case "region":
					$output = @$ipdat->geoplugin_regionName;
					break;
				case "country":
					$output = @$ipdat->geoplugin_countryName;
					break;
				case "countrycode":
					$output = @$ipdat->geoplugin_countryCode;
					break;
			}
		}
	}
	return $output;
}

function getSettings()
{
	$settingQs = \App\Models\Settings::select('key', 'value')->get();
	$settings = [];
	foreach ($settingQs as $setting) {
		$settings[$setting->key] = maybe_decode($setting->value);
	}
	global $settings;
}

//getSettings();

function calculateDaysAccTime($days, $start_time, $end_time)
{
	$start_time_h = strtotime($start_time);
	$end_time_h = strtotime($end_time);
	if ($end_time_h < $start_time_h) {
		$end_time_h += 24 * 60 * 60;
	}
	$total_min = ($end_time_h - $start_time_h) / 60;
	if ($total_min < 300) {
		$days = $days / 2;
	}
	return $days;
}
function dateTime()
{
	return date('Y-m-d H:i:s');
}

function dateonly()
{
	return date('Y-m-d');
}
function timeonly()
{
	return date('H:i:s');
}

function dateFormat($date)
{
	return date('F d Y', strtotime($date));
}
function dateTimeFormat($date)
{
	return date('F d Y h:i A', strtotime($date));
}
function timeFormat($date)
{
	return date('h:i A', strtotime($date));
}

function userTypes()
{
	return [
		User::ADMIN => 'Admin',
		User::SUBADMIN => 'SubAdmin',
		// User::USER => 'User',
		// User::PLAYER => 'Player',
	];
}
function daysName()
{
	return [
		'monday' => 'Monday',
		'tuesday' => 'Tuesday',
		'wednesday' => 'Wednesday',
		'thursday' => 'Thursday',
		'friday' => 'Friday',
		'saturday' => 'Saturday',
		'sunday' => 'Sunday'
	];
}

function priceFormat($price)
{
	return '$ ' . number_format($price, 2);
}

function generateUsername() {
	$randomNumber = rand(100000, 999999);
	return "MG" . $randomNumber;
}

function genders()
{
	return [
		'male' => 'Male',
		'female' => 'Female'
	];
}
function filterData(&$str)
{
	$str = preg_replace("/\t/", "\\t", $str);
	$str = preg_replace("/\r?\n/", "\\n", $str);
	if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}
function getCountryName($countryId)
{
	return Countries::where('id', $countryId)->get()->pluck('name')->first();
}
function getStateName($stateId)
{
	return States::where('id', $stateId)->get()->pluck('name')->first();
}
function getCityName($cityId)
{
	return Cities::where('id', $cityId)->get()->pluck('name')->first();
}
function getMenus()
{
	return [
		[
			'title' => 'Dashboard',
			'route' => 'dashboard.index',
			'icon' => 'tf-icons bx bx-home-circle',
			'role' => [User::ADMIN],
		], 
		[
			'title' => 'Users',
			'route' => 'users.index',
			'icon' => 'menu-icon tf-icons bx bx-group',
			'role' => [User::ADMIN],
		],
		[
			'title' => 'Media',
			'route' => 'media.index',
			'icon' => 'menu-icon tf-icons bx bxs-file-image',
			'role' => [User::ADMIN],
		],
		[
			'title' => 'Settings',
			'route' => 'themes.index',
			'icon' => 'tf-icons bx bx-cog',
			'role' => [User::ADMIN],
		],
		[
			'title' => 'Declare Results',
			'route' => 'resultDashboard',
			'icon' => 'tf-icons bx bx-cog',
			'role' => [User::ADMIN],
		],
		[
			'title' => 'Tansactions',
			'route' => 'paymentRequest',
			'icon' => 'tf-icons bx bx-cog',
			'role' => [User::ADMIN],
		],
		[
			'title' => 'Jantri Table',
			'route' => 'jantriTable',
			'icon' => 'tf-icons bx bx-cog',
			'role' => [User::ADMIN],
		],
		
		// Sub Admin
		[
			'title' => 'Dashboard',
			'route' => 'subadminDashboard',
			'icon' => 'tf-icons bx bx-home-circle',
			'role' => [User::SUBADMIN],
		], 
		[
			'title' => 'My Players',
			'route' => 'viewPlayers',
			'icon' => 'tf-icons bx bx-home-circle',
			'role' => [User::SUBADMIN],
		],
		[
			'title' => 'Tansactions',
			'route' => 'userPayment',
			'icon' => 'tf-icons bx bx-cog',
			'role' => [User::SUBADMIN],
		],
		[
			'title' => 'Jantri Table',
			'route' => 'jantriTablesa',
			'icon' => 'tf-icons bx bx-cog',
			'role' => [User::SUBADMIN],
		],
	];
}
function postTypes()
{
	return [
		// 'page' => [
		// 	'area' => 'Admin',
		// 	'title' => 'Page',
		// 	'icon' => 'tf-icons bx bx-book-content',
		// 	'slug' => 'page',
		// 	'role' => [User::ADMIN],
		// 	'showMenu' => true,
		// 	'multilng' => false,
		// 	'support' => ['content', 'excerpt', 'seo', 'featured'],
		// 	'templateOption' => [
		// 		'PostDefault' => 'Default Template',
		// 		'Home' => 'Home Template',
		// 	],
		// 	'taxonomy' => []
		// ],
		
		'optiongame' => [
			'area' => 'Admin',
			'title' => 'Toss Games',
			'icon' => 'tf-icons bx bxl-blogger',
			'slug' => 'optiongame',
			'role' => [User::ADMIN],
			'showMenu' => false,
			'multilng' => false,
			'support' => [],
			'templateOption' => [
				'OptionGame' => 'Option Games',
			],
			'taxonomy' => []
		],

		'numberGame' => [
			'area' => 'Admin',
			'title' => 'Satta Games',
			'icon' => 'tf-icons bx bxl-blogger',
			'slug' => 'numberGame',
			'role' => [User::ADMIN],
			'showMenu' => false,
			'multilng' => false,
			'support' => [],
			'templateOption' => [
				'DailySatta' => 'Number Games',
			],
			'taxonomy' => []
		],
		'news' => [
			'area' => 'Admin',
			'title' => 'Game News',
			'icon' => 'tf-icons bx bxl-blogger',
			'slug' => 'news',
			'role' => [User::ADMIN],
			'showMenu' => false,
			'multilng' => false,
			'support' => ['excerpt'],
			'templateOption' => [
				'News' => 'News',
			],
			'taxonomy' => []
		],

	];
}
function getPostsByPostTypebyTerm($postType = null, $limit = 0, $order_by = '', $extraFields = false, $pagination = false, $faqCategoryId = null)
{
	if ($limit == 0) {
		$limit = pagination();
	}
	$orderColumn = 'posts.menu_order';
	$orderBy = 'ASC';
	if ($order_by == 'new') {
		$orderColumn = 'posts.post_id';
		$orderBy = 'DESC';
	} else if ($order_by == 'old') {
		$orderColumn = 'posts.post_id';
		$orderBy = 'ASC';
	} else if ($order_by == 'order') {
		$orderColumn = 'posts.menu_order';
		$orderBy = 'ASC';
	}
	$posts = \App\Models\Posts::where('posts.post_type', $postType)
		->leftJoin('posts as getImage', 'getImage.post_id', 'posts.guid')
		->leftJoin('users as user', 'user.user_id', 'posts.user_id')
		->select('posts.*', 'getImage.media as post_image', 'user.name as user_name', 'getImage.post_title as post_image_alt')
		->where('posts.post_status', 'publish')
		->where(function ($query) use ($faqCategoryId) {
			if ($faqCategoryId) {
				$termIDs = \App\Models\Terms::where('id', $faqCategoryId)->pluck('id')->toArray();
				$termRelations = \App\Models\TermRelations::whereIn('term_id', $termIDs)->pluck('object_id')->toArray();
				$query->whereIn('posts.post_id', $termRelations);
			}
		})
		->orderBy($orderColumn, $orderBy);
	if ($pagination == true) {
		$posts = $posts->paginate($limit);
	} else {
		$posts = $posts->limit($limit)->get();
	}
	if (!$extraFields) {
		return $posts;
	}
	foreach ($posts as &$post) {
		$postTypes = getPostType($post->post_type);
		$post->extraFields = getPostMeta($post->post_id);
		$post->posted_date = date('M d, Y', strtotime($post->created_at));
		$post->posted_time = date('h:i A', strtotime($post->created_at));
		$termRelations = \App\Models\TermRelations::where('object_id', $post->post_id)->select('term_id');
		if (!empty($postTypes['taxonomy'])) {
			$termsSelected = [];
			foreach ($postTypes['taxonomy'] as $key => $value) {
				$termsSelected[$key] = \App\Models\Terms::whereIn('id', $termRelations)->where('term_group', $key)->get();
			}
			$post->category = $termsSelected;
		}
		$postedComments = \App\Models\Comment::where('post_id', $post->post_id)->where('comment_approved', 1)->get();
		foreach ($postedComments as &$postedComment) {
			$postedComment->rating = getCommentMeta($postedComment->comment_ID, 'comment_rating');
		}
		$post->postedComments = $postedComments;
	}
	return $posts;
}
function getPostsByPostType($postType = null, $limit = 0, $order_by = '', $extraFields = false, $pagination = false)
{
	if ($limit == 0) {
		$limit = pagination();
	}
	$orderColumn = 'posts.menu_order';
	$orderBy = 'ASC';
	if ($order_by == 'new') {
		$orderColumn = 'posts.post_id';
		$orderBy = 'DESC';
	} else if ($order_by == 'old') {
		$orderColumn = 'posts.post_id';
		$orderBy = 'ASC';
	} else if ($order_by == 'order') {
		$orderColumn = 'posts.menu_order';
		$orderBy = 'ASC';
	}
	$posts = \App\Models\Posts::where('posts.post_type', $postType)
		->leftJoin('posts as getImage', 'getImage.post_id', 'posts.guid')
		->leftJoin('users as user', 'user.user_id', 'posts.user_id')
		->select('posts.*', 'getImage.media as post_image', 'user.name as user_name', 'getImage.post_title as post_image_alt')
		->where('posts.post_status', 'publish')
		->where(function ($query) {
			if (request()->get('term')) {
				$termIDs = \App\Models\Terms::where('slug', request()->get('term'))->pluck('id')->toArray();
				$termRelations = \App\Models\TermRelations::whereIn('term_id', $termIDs)->pluck('object_id')->toArray();
				$query->whereIn('posts.post_id', $termRelations);
			}
		})
		->orderBy($orderColumn, $orderBy);
	if ($pagination == true) {
		$posts = $posts->paginate($limit);
	} else {
		$posts = $posts->limit($limit)->get();
	}
	if (!$extraFields) {
		return $posts;
	}
	foreach ($posts as &$post) {
		$postTypes = getPostType($post->post_type);
		$post->extraFields = getPostMeta($post->post_id);
		$post->posted_date = date('M d, Y', strtotime($post->created_at));
		$post->posted_time = date('h:i A', strtotime($post->created_at));
		$termRelations = \App\Models\TermRelations::where('object_id', $post->post_id)->select('term_id');
		if (!empty($postTypes['taxonomy'])) {
			$termsSelected = [];
			foreach ($postTypes['taxonomy'] as $key => $value) {
				$termsSelected[$key] = \App\Models\Terms::whereIn('id', $termRelations)->where('term_group', $key)->get();
			}
			$post->category = $termsSelected;
		}
		$postedComments = \App\Models\Comment::where('post_id', $post->post_id)->where('comment_approved', 1)->get();
		foreach ($postedComments as &$postedComment) {
			$postedComment->rating = getCommentMeta($postedComment->comment_ID, 'comment_rating');
		}
		$post->postedComments = $postedComments;
	}
	return $posts;
}
function getTerms($termGroup = null, $postType = null, $limit = 3)
{
	$terms = \App\Models\Terms::where('term_group', $termGroup)
		->where('post_type', $postType)
		->limit($limit)
		->get();
	foreach ($terms as $term) {
		$term->category_icon = getTermMeta($term->id, 'category_icon');
	}
	return $terms;
}
function getPostType($postType = null)
{
	$posts = postTypes();
	if (isset($posts[$postType]) && !empty($posts[$postType])) {
		return (isset($posts[$postType]) ? $posts[$postType] : '');
	}
	return;
}
function getTaxonomyType($postType = null, $taxonomy = null)
{
	$posts = postTypes();
	if (isset($posts[$postType]) && !empty($posts[$postType])) {
		if (isset($posts[$postType]['taxonomy'][$taxonomy]['title'])) {
			return ($posts[$postType]['taxonomy'][$taxonomy]['title']);
		}
	}
	return;
}
function getTaxonomyArray($postType = null, $taxonomy = null)
{
	$posts = postTypes();
	if (isset($posts[$postType]) && !empty($posts[$postType])) {
		if (isset($posts[$postType]['taxonomy'][$taxonomy])) {
			return ($posts[$postType]['taxonomy'][$taxonomy]);
		}
	}
	return;
}
function getPostTypeByTax($taxonomy = null)
{
	$posts = postTypes();
	foreach ($posts as $postKey => $postValue) {
		if (isset($postValue['taxonomy'][$taxonomy])) {
			return $postValue['slug'];
		}
	}
	return;
}
function getTermSlugByTax($taxonomy = null)
{
	$posts = postTypes();
	foreach ($posts as $postKey => $postValue) {
		if (isset($postValue['taxonomy'][$taxonomy])) {
			return $postValue['taxonomy'][$taxonomy]['slug'];
		}
	}
	return;
}
function getTermTaxBySlug($taxonomy = null)
{
	$posts = postTypes();
	foreach ($posts as $postKey => $postValue) {
		if (isset($postValue['taxonomy']) && is_array($postValue['taxonomy'])) {
			foreach ($postValue['taxonomy'] as $key => $value) {
				if (isset($value['slug']) && $value['slug'] == $taxonomy) {
					return $key;
				}
			}
		}
	}
	return;
}

/*****post meta action******/
function addPostMetaBox($post_type,  $post_id)
{
	$postBoxHtml = '';
	switch ($post_type) {
		case 'post':
			$postBoxHtml = postPostMetaBox($post_id);
			break;
		case 'optiongame':
			$postBoxHtml = postoptiongameMetaBox($post_id);
			break;
		case 'numberGame':
			$postBoxHtml = postnumberGameMetaBox($post_id);
			break;
		
		default:
			$postBoxHtml = '';
			break;
	}
	echo $postBoxHtml;
}
function insertUpdatePostMetaBox($post_type, $request, $post_id)
{
	switch ($post_type) {
		case 'post':
			insertUpdatePostPostMetaBox($request, $post_id);
			break;
		case 'optiongame':
			insertUpdateoptiongamePostMetaBox($request, $post_id);
			break;
		case 'numberGame':
			insertUpdatenumberGamePostMetaBox($request, $post_id);
			break;
		default:
			return;
			break;
	}
}

/*****Post post meta action******/
function postPostMetaBox($post_id)
{
	ob_start();
?>

<?php
	return ob_get_clean();
}
function insertUpdatePostPostMetaBox($request, $post_id) {}

/*****Post optiongame meta action******/
function postoptiongameMetaBox($post_id)
{
	ob_start();
?>
<br>
	<div class="input-group row">
		<h5 style="color: red;">Game Details</h5>
		<div class="col-md-6">
			<label class="col-form-label" for="answer_one">Answer 1</label><br>
			<input type="text" name="answer_one" id="answer_one" class="form-control form-control-lg" value="<?php echo getPostMeta($post_id, 'answer_one') ?>">
			<span class="md-line"></span>
		</div>
		<div class="col-md-6">
			<label class="col-form-label" for="answer_two">Answer 2</label><br>
			<input type="text" name="answer_two" id="answer_two" class="form-control form-control-lg" value="<?php echo getPostMeta($post_id, 'answer_two') ?>">
			<span class="md-line"></span>
		</div>
		<div class="col-md-6">
			<label class="col-form-label" for="close_date">Game Closing Date</label><br>
			<input type="date" name="close_date" id="close_date" class="form-control form-control-lg" value="<?php echo getPostMeta($post_id, 'close_date') ?>">
			<span class="md-line"></span>
		</div>
		<div class="col-md-6">
			<label class="col-form-label" for="close_time">Game Closing Time</label><br>
			<input type="time" name="close_time" id="close_time" class="form-control form-control-lg" value="<?php echo getPostMeta($post_id, 'close_time') ?>">
			<span class="md-line"></span>
		</div>
	</div>
<?php
	return ob_get_clean();
}
function insertUpdateoptiongamePostMetaBox($request, $post_id)
{
	updatePostMeta($post_id, 'answer_one', $request->answer_one);
	updatePostMeta($post_id, 'answer_two', $request->answer_two);
	updatePostMeta($post_id, 'close_date', $request->close_date);
	updatePostMeta($post_id, 'close_time', $request->close_time);
}

/*****Post numberGame meta action******/
function postnumberGameMetaBox($post_id)
{
	ob_start();
?>
<br>
	<div class="input-group row">
		<h5 style="color: red;">Morning Game</h5>
		<div class="col-md-6">
			<label class="col-form-label" for="open_time_morning">Morning Open Time</label><br>
			<input type="time" name="open_time_morning" id="open_time_morning" class="form-control form-control-lg" value="<?php echo getPostMeta($post_id, 'open_time_morning') ?>">
			<span class="md-line"></span>
		</div>
		<div class="col-md-6">
			<label class="col-form-label" for="close_time_morning">Morning Close Time</label><br>
			<input type="time" name="close_time_morning" id="close_time_morning" class="form-control form-control-lg" value="<?php echo getPostMeta($post_id, 'close_time_morning') ?>">
			<span class="md-line"></span>
		</div>
	</div>
	<br>
	<div class="input-group row">
		<h5 style="color: red;">Evening Game</h5>
		<div class="col-md-6">
			<label class="col-form-label" for="open_time_evening">Evening Open Time</label><br>
			<input type="time" name="open_time_evening" id="open_time_evening" class="form-control form-control-lg" value="<?php echo getPostMeta($post_id, 'open_time_evening') ?>">
			<span class="md-line"></span>
		</div>
		<div class="col-md-6">
			<label class="col-form-label" for="close_time_evening">Evening Close Time</label><br>
			<input type="time" name="close_time_evening" id="close_time_evening" class="form-control form-control-lg" value="<?php echo getPostMeta($post_id, 'close_time_evening') ?>">
			<span class="md-line"></span>
		</div>
	</div>
<?php
	return ob_get_clean();
}
function insertUpdatenumberGamePostMetaBox($request, $post_id)
{
	updatePostMeta($post_id, 'open_time_morning', $request->open_time_morning);
	updatePostMeta($post_id, 'close_time_morning', $request->close_time_morning);
	updatePostMeta($post_id, 'open_time_evening', $request->open_time_evening);
	updatePostMeta($post_id, 'close_time_evening', $request->close_time_evening);
}

/*****Post page meta action******/

function updatePostMeta($post_id = null, $meta_key = null, $meta_value = null)
{
	if (empty($post_id) && empty($meta_key)) {
		return;
	}
	if ($postMeta = \App\Models\PostMetas::where('post_id', $post_id)->where('meta_key', $meta_key)->get()->first()) {
		$postMeta->meta_value = maybe_encode($meta_value);
		$postMeta->updated_at = new DateTime;
		$postMeta->save();
	} else {
		$postMeta = new \App\Models\PostMetas;
		$postMeta->post_id = $post_id;
		$postMeta->meta_key = $meta_key;
		$postMeta->meta_value = maybe_encode($meta_value);
		$postMeta->created_at = new DateTime;
		$postMeta->updated_at = new DateTime;
		$postMeta->save();
	}
	return $post_id;
}

function getPostMeta($post_id = null, $meta_key = null)
{
	if (empty($post_id)) {
		return;
	}
	if ($meta_key) {
		return maybe_decode(\App\Models\PostMetas::where('post_id', $post_id)->where('meta_key', $meta_key)->pluck('meta_value')->first());
	} else {
		$postMetas = \App\Models\PostMetas::where('post_id', $post_id)->select('meta_key', 'meta_value')->get()->toArray();
		$postMetasData = [];
		foreach ($postMetas as &$postMeta) {
			$postMetasData[$postMeta['meta_key']] = maybe_decode($postMeta['meta_value']);
			unset($postMeta['meta_key']);
			unset($postMeta['meta_value']);
		}
		return $postMetasData;
	}
}

function updateTermMeta($term_id = null, $meta_key = null, $meta_value = null)
{
	if (empty($term_id) && empty($meta_key)) {
		return;
	}
	if ($termMeta = \App\Models\TermMetas::where('term_id', $term_id)->where('meta_key', $meta_key)->get()->first()) {
		$termMeta->meta_value = maybe_encode($meta_value);
		$termMeta->updated_at = new DateTime;
		$termMeta->save();
	} else {
		$termMeta = new \App\Models\TermMetas;
		$termMeta->term_id = $term_id;
		$termMeta->meta_key = $meta_key;
		$termMeta->meta_value = maybe_encode($meta_value);
		$termMeta->created_at = new DateTime;
		$termMeta->updated_at = new DateTime;
		$termMeta->save();
	}
	return $term_id;
}
function getTermMeta($term_id = null, $meta_key = null)
{
	if (empty($term_id)) {
		return;
	}
	if ($meta_key) {
		return maybe_decode(\App\Models\TermMetas::where('term_id', $term_id)->where('meta_key', $meta_key)->pluck('meta_value')->first());
	} else {
		$termMetas = \App\Models\TermMetas::where('term_id', $term_id)->select('meta_key', 'meta_value')->get()->toArray();
		foreach ($termMetas as &$termMeta) {
			$termMeta[$termMeta['meta_key']] = maybe_decode($termMeta['meta_value']);
			unset($termMeta['meta_key']);
			unset($termMeta['meta_value']);
		}
		return $termMetas;
	}
}
/*****term meta action******/
function addTermMetaBox($registerTerm,  $term_id)
{
	$termBoxHtml = '';
	switch ($registerTerm) {
		case 'category':
			$termBoxHtml = categoryTermMetaBox($term_id);
			break;
		default:
			$termBoxHtml = '';
			break;
	}
	echo $termBoxHtml;
}
function insertUpdateTermMetaBox($taxonomy, $request, $term_id)
{
	switch ($taxonomy) {
		case 'category':
			return insertcategoryTermMetaBox($request, $term_id);
			break;
		default:
			return;
			break;
	}
}
function categoryTermMetaBox($term_id)
{
?>
	<div class="input-group row">
		<label class="col-form-label" for="category_icon>">Icon</label><br>
		<input type="text" name="category_icon" id="category_icon" class="form-control form-control-lg" placeholder="Icon" value="<?php echo getTermMeta($term_id, 'category_icon') ?>">
		<span class="md-line"></span>
	</div>
<?php
}
function insertcategoryTermMetaBox($request, $term_id)
{
	updateTermMeta($term_id, 'category_icon', $request->category_icon);
}
/***** Comment Meta********/
function getCommentMeta($comment_id = null, $meta_key = null)
{
	if (empty($comment_id)) {
		return;
	}
	if ($meta_key) {
		return maybe_decode(\App\Models\CommentMeta::where('comment_id', $comment_id)->where('meta_key', $meta_key)->pluck('meta_value')->first());
	} else {
		$commentMetas = \App\Models\CommentMeta::where('comment_id', $comment_id)->select('meta_key', 'meta_value')->get()->toArray();
		$commentMetasData = [];
		foreach ($commentMetas as &$commentMeta) {
			$commentMetasData[$commentMeta['meta_key']] = maybe_decode($commentMeta['meta_value']);
			unset($commentMeta['meta_key']);
			unset($commentMeta['meta_value']);
		}
		return $commentMetasData;
	}
}

function updateCommentMeta($comment_id = null, $meta_key = null, $meta_value = null)
{
	if (empty($comment_id) && empty($meta_key)) {
		return;
	}
	if ($commentMeta = \App\Models\CommentMeta::where('comment_id', $comment_id)->where('meta_key', $meta_key)->get()->first()) {
		$commentMeta->meta_value = maybe_encode($meta_value);
		$commentMeta->updated_at = new DateTime;
		$commentMeta->save();
	} else {
		$commentMeta = new \App\Models\CommentMeta;
		$commentMeta->comment_id = $comment_id;
		$commentMeta->meta_key = $meta_key;
		$commentMeta->meta_value = maybe_encode($meta_value);
		$commentMeta->created_at = new DateTime;
		$commentMeta->updated_at = new DateTime;
		$commentMeta->save();
	}
	return $comment_id;
}
/***** User Meta********/
function getUserMeta($user_id = null, $meta_key = null)
{
	if (empty($user_id)) {
		return;
	}
	if ($meta_key) {
		return maybe_decode(\App\Models\UserMetas::where('user_id', $user_id)->where('meta_key', $meta_key)->pluck('meta_value')->first());
	} else {
		$userMetas = \App\Models\UserMetas::where('user_id', $user_id)->select('meta_key', 'meta_value')->get()->toArray();
		$userMetasData = [];
		foreach ($userMetas as &$userMeta) {
			$userMetasData[$userMeta['meta_key']] = maybe_decode($userMeta['meta_value']);
			unset($userMeta['meta_key']);
			unset($userMeta['meta_value']);
		}
		return $userMetasData;
	}
}

function updateUserMeta($user_id = null, $meta_key = null, $meta_value = null)
{
	if (empty($user_id) && empty($meta_key)) {
		return;
	}
	if ($userMeta = \App\Models\UserMetas::where('user_id', $user_id)->where('meta_key', $meta_key)->get()->first()) {
		$userMeta->meta_value = maybe_encode($meta_value);
		$userMeta->updated_at = new DateTime;
		$userMeta->save();
	} else {
		$userMeta = new \App\Models\UserMetas;
		$userMeta->user_id = $user_id;
		$userMeta->meta_key = $meta_key;
		$userMeta->meta_value = maybe_encode($meta_value);
		$userMeta->created_at = new DateTime;
		$userMeta->updated_at = new DateTime;
		$userMeta->save();
	}
	return $user_id;
}
function registerNavBarMenu()
{
	return [
		'primary_menu' => 'Primary Menu',
		'footer_service_menu' => 'Footer Service Menu',
		'footer_main_menu' => 'Footer Main Menu'
	];
}
function createUpdateSiteMapXML($postUrl)
{

	$postUrl = str_replace('in//', 'in/', $postUrl);
	$hasUrl = false;
	$sitemapPath = base_path('public\sitemap.xml');
	$sitemapPath = str_replace('public/', '', $sitemapPath);
	$xmlObjects = simplexml_load_file($sitemapPath);

	$xmlRow = '';
	$existRow = false;
	if (!empty($xmlObjects->url)) {
		foreach ($xmlObjects->url as $xmlObject) {
			if ($xmlObject->loc == $postUrl) {
				$existRow = true;
				$xmlRow .= '<url>
						<loc>' . $xmlObject->loc . '</loc>
					  <lastmod>' . date('c', time()) . '</lastmod>
					  <priority>' . $xmlObject->priority . '</priority>
				   </url>';
			} else {
				$xmlRow .= '<url>
					  <loc>' . $xmlObject->loc . '</loc>
					  <lastmod>' . $xmlObject->lastmod . '</lastmod>
					  <priority>' . $xmlObject->priority . '</priority>
				   </url>';
			}
		}
	}
	if ($existRow == false) {
		$xmlRow .= '<url>
					  <loc>' . $postUrl . '</loc>
					  <lastmod>' . date('c', time()) . '</lastmod>
					  <priority>0.5</priority>
				   </url>';
	}

	$xmlContent = '<?xml version="1.0" encoding="UTF-8"?>
		<urlset
			  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
			  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
			  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
					http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
		<!-- created with Free Online Sitemap Generator www.xml-sitemaps.com -->
		   ' . $xmlRow . '
		</urlset>';
	$dom = new \DOMDocument;
	$dom->preserveWhiteSpace = FALSE;
	$dom->loadXML($xmlContent);
	$dom->save($sitemapPath);
}
function deleteSiteMapXML($postUrl)
{
	$postUrl = str_replace('in//', 'in/', $postUrl);
	$hasUrl = false;
	$sitemapPath = base_path('public\sitemap.xml');
	$sitemapPath = str_replace('public/', '', $sitemapPath);
	$xmlObjects = simplexml_load_file($sitemapPath);

	$xmlRow = '';
	if (!empty($xmlObjects->url)) {
		foreach ($xmlObjects->url as $xmlObject) {
			if ($xmlObject->loc != $postUrl) {
				$xmlRow .= '<url>
						<loc>' . $xmlObject->loc . '</loc>
					  <lastmod>' . $xmlObject->lastmod . '</lastmod>
					  <priority>' . $xmlObject->priority . '</priority>
				   </url>';
			}
		}
	}

	$xmlContent = '<?xml version="1.0" encoding="UTF-8"?>
		<urlset
			  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
			  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
			  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
					http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
		<!-- created with Free Online Sitemap Generator www.xml-sitemaps.com -->
		   ' . $xmlRow . '
		</urlset>';

	$dom = new \DOMDocument;
	$dom->preserveWhiteSpace = FALSE;
	$dom->loadXML($xmlContent);
	$dom->save($sitemapPath);
}

function getChildMenus($menufor)
{
	$menuOptions = Links::where('link_visible', 'Y')->where('link_parent', 0)->where('links.link_rel', $menufor)->orderBy('link_order', 'ASC')->get();
	$menus = [];
	foreach ($menuOptions as $menuOption) {
		if (in_array($menuOption->target_type, ['page'])) {
			$menuOption->target_type = '';
		}
		if (in_array($menuOption->target_type, ['post'])) {
			$menuOption->target_type = 'blog';
		}
		if (in_array($menuOption->target_type, ['category', 'tag'])) {
			$menuOption->link_target = 'blog';
		}
		if (in_array($menuOption->link_target, ['post'])) {
			$menuOption->link_target = '';
		}
		if (in_array($menuOption->target_type, ['gallery_category'])) {
			$menuOption->link_target = 'gallery';
			$menuOption->target_type = 'gallery-category';
		}

		$childMenuOptions = Links::where('link_visible', 'Y')->where('link_parent', $menuOption->id)->where('links.link_rel', $menufor)->orderBy('link_order', 'ASC')->get();

		$menus[] = [
			'link_name' => $menuOption->link_name,
			'link_url' => ($menuOption->link_target ? '/' . $menuOption->link_target . '/' . $menuOption->target_type : ($menuOption->target_type ? '/' . $menuOption->target_type : '')) . '/' . $menuOption->link_url,
			'childMenus' => getInnerChildMenu($childMenuOptions, $menufor)
		];
	}
	return $menus;
}

function getInnerChildMenu($menuOptions, $menufor)
{
	$menus = [];
	foreach ($menuOptions as $menuOption) {
		if (in_array($menuOption->target_type, ['page'])) {
			$menuOption->target_type = '';
		}
		if (in_array($menuOption->target_type, ['post'])) {
			$menuOption->target_type = 'blog';
		}
		if (in_array($menuOption->target_type, ['category', 'tag'])) {
			$menuOption->link_target = 'blog';
		}
		if (in_array($menuOption->link_target, ['post'])) {
			$menuOption->link_target = '';
		}
		if (in_array($menuOption->target_type, ['gallery_category'])) {
			$menuOption->link_target = 'gallery';
			$menuOption->target_type = 'gallery-category';
		}
		$childMenuOptions = Links::where('link_visible', 'Y')->where('link_parent', $menuOption->id)->where('links.link_rel', $menufor)->orderBy('link_order', 'ASC')->get();
		$menus[] = [
			'link_name' => $menuOption->link_name,
			'link_url' => ($menuOption->link_target ? '/' . $menuOption->link_target . '/' . $menuOption->target_type : ($menuOption->target_type ? '/' . $menuOption->target_type : '')) . '/' . $menuOption->link_url,
			'childMenus' => getInnerChildMenu($childMenuOptions, $menufor)
		];
	}
	return $menus;
}
function hasSubChild($menus)
{
	$hasSubChild = false;
	if (is_array($menus)) {
		foreach ($menus as $menu) {
			if (count($menu['childMenus']) > 0) {
				$hasSubChild = true;
			}
		}
	}
	return $hasSubChild;
}
