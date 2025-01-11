<?php

namespace App\Services;

use App\Models\{
    User,
    Posts,
    Enquiry,
    Subscibers
};

class DashboardService
{
    public function userCount(){
        return User::count();
    }
    public function enquiryCount(){
        return Enquiry::count();
    }
    public function subscribersCount(){
        return Subscibers::count();
    }
    public function postsCount(){
        $postCounts = [];
        foreach (postTypes() as $postKey => $postValue) {
            $postCounts[] = [
                'postTitle' => $postValue['title'],
                'postType' => $postKey,
                'postCount' => Posts::where('post_status', 'publish')->where('post_type', $postKey)->count()
            ];
        }
        return $postCounts;
    }
}