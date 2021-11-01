<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginCounter;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $login_log = LoginCounter::orderBy('id', 'desc')->get();
        $arr = [];
        foreach($login_log as $item){
            $timestamp = strtotime($item->created_at);
            $month = date('M', $timestamp);
            $arr[] = $month;
        }
        $count = array_count_values($arr);

        return view('admin.dashboard', compact('login_log', 'count'));
    }
}
