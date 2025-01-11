<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\{
    VisitorData,
    VisitedPages
};

class VisitorTracking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ipAddress = get_client_ip();
        $device_id = $_SERVER['HTTP_USER_AGENT'];
        if(!$visitorData = VisitorData::where('ip_address', $ipAddress)->get()->first()) {
            $visitorData = new VisitorData();
            $visitorData->ip_address = $ipAddress;
            $visitorData->device = $device_id;
            $visitorData->visit_time = dateTime();
            $visitorData->created_at = dateTime();
        }
        $visitorData->latest_visit_time = dateTime();
        $visitorData->updated_at = dateTime();
        $visitorData->save();
        VisitedPages::insert([
            'visitor_id' => $visitorData->id,
            'route' => $request->url(),
            'page_title' => ($request->route()->getName()??$request->url()),
            'created_at' => dateTime(),
            'updated_at' => dateTime()
        ]);
        return $next($request);
    }
}
