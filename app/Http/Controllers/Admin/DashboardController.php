<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        $data = [];
        $data['totalArticles'] = 12;
        $data['totalProducts'] = 34;
        $data['totalUsers'] = 234;
        $data['totalOrders'] = 345;
        $data['counter'] = 423;

        return view('admin.dashboard', $data);
    }
}
