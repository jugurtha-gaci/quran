<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Helper;
use App\Models\Setting;

class GroupsController extends Controller
{

    public function select($id) {
        $group = Group::find($id);
        $price = Setting::find(1)->subscription_price ? 
            Setting::find(1)->subscription_price :
            env('SUBSCRIPTION_PRICE');

        return view('dashboard.join-group', compact("group", "price"));
    }

    public function confirm($id) {
        $group = Group::find($id);
        $price = Setting::find(1)->subscription_price ? Setting::find(1)->subscription_price : env('SUBSCRIPTION_PRICE');
        $start = Helper::nextGroupSession($id);

        return view('dashboard.checkout', compact("group", "price"))->with('start', $start);
        

    }

}
