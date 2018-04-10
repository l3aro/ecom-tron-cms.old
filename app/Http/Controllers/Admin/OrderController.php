<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Setting;
class OrderController extends Controller
{
    public function index(Request $request){
        $order = Order::orderBy('name','desc')->paginate(9);
        $dataView = [];
        if ($request->isMethod('post')){
            $order->user = $request->user;
            $order->name = $request->name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->title = $request->title;
            $order->content = $request->content;
            $order->total = $request->total;
            $order->finished = $request->finished;
            $order->sent_date = $request->sent_date;
            $order->finished_date = $request->finished_date;
        }
        $dataView['order'] =$order;

        return view('admin/order/index',$dataView);
    }
    public function item(Request $request){
        $item = Order::find($request->id);
        
        if(!$item){
            $item = new Order;            
        }
        $dataView = [];
        $dataView['saved'] = 0;
        if ($request->isMethod('post')) {
            $item->name = $request->name;
            $item->email = $request->email;
            $item->address = $request->address;
            $item->phone = $request->phone;
            $item->total = $request->total;
            $item->content = $request->content;
            
            $item->save();
            $dataView['saved'] = 1;
        }
        $dataView['item'] = $item;
        return view('admin/order/item',$dataView);
    }

    public function printfile(Request $request){
        $printfile = Order::find($request->id);
        $setting = Setting::first();
        $dataView = [];
        if ($request->isMethod('post')){
            $printfile->name = $request->name;
            $printfile->email = $request->email;
            $printfile->address = $request->address;
            $printfile->phone = $request->phone;
            $printfile->total = $request->total;
            $printfile->content = $request->content;
            
            $printfile->company_name = $setting->company_name;
            $printfile->company_address = $setting->company_address;
            $printfile->company_hotline = $setting->company_hotline;
            $printfile->company_email = $setting->company_email;
            $printfile->company_website_url = $setting->company_website_url;
        }
        $dataView['setting'] = $setting;
        $dataView['printfile'] = $printfile;
        return view('admin/order/printfile',$dataView);
    }
    
    public function delete_cat(Order $id){    
        $id->delete();
        return redirect('admin/order');
    }
    public function delete(Order $order, Request $request){
        $order->delete();
        if ($request->ajax()) {
            return 0;
        }
    }
    
}   
