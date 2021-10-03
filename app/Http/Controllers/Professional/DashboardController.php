<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Countries;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('professional');
    }
    public function dashboard()
    {
       	$viewData['pageTitle'] = "Dashboard";
        return view(roleFolder().'.dashboard',$viewData);
    }

    public function profile()
    {
       	$viewData['pageTitle'] = "Profile";
       	$viewData['active_tab'] = "profile_tab";
       	$user = User::where("id",\Auth::user()->id)->first();
       	$viewData['user'] = $user;
        return view(roleFolder().'.profile.profile',$viewData);
    }

    public function services()
    {
       	$viewData['pageTitle'] = "Services";
       	$viewData['active_tab'] = "service_tab";
       	$user = User::where("id",\Auth::user()->id)->first();
       	$viewData['user'] = $user;
        return view(roleFolder().'.profile.services',$viewData);
    }

    public function articles()
    {
        $viewData['pageTitle'] = "Articles";
        $viewData['active_tab'] = "article_tab";
        $user = User::where("id",\Auth::user()->id)->first();
        $viewData['user'] = $user;
        return view(roleFolder().'.profile.articles',$viewData);
    }

    public function events()
    {
        $viewData['pageTitle'] = "Events";
        $viewData['active_tab'] = "event_tab";
        $user = User::where("id",\Auth::user()->id)->first();
        $viewData['user'] = $user;
        return view(roleFolder().'.profile.events',$viewData);
    }

    public function editProfile()
    {
       	$viewData['pageTitle'] = "Edit Profile";
        $countries = Countries::get();
        $viewData['countries'] = $countries;
        return view(roleFolder().'.edit-profile',$viewData);
    }

    public function completeProfile()
    {
        $viewData['pageTitle'] = "Complete Profile";
        $viewData['active_tab'] = "personal_tab";
        $user = User::where("id",\Auth::user()->id)->first();
        $viewData['user'] = $user;
        return view(roleFolder().'.profile.complete-profile',$viewData);
    }

}
