<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\EmailContent;
use Auth;
class SettingController extends Controller
{


    public function index(){

        return view('admin/setting/index');
    }
    public function info(Request $request){
        $setting = Setting::first();
        $dataView = [];
        $dataView['saved'] = 0;
        if ($request->isMethod('post')) {
            $setting->company_website_url = $request->company_website_url;
            $setting->company_name = $request->company_name;
            $setting->company_address = $request->company_address;
            $setting->company_tel = $request->company_tel;
            $setting->company_hotline = $request->company_hotline;
            $setting->company_mobile = $request->company_mobile;
            $setting->company_email = $request->company_email;
            $setting->company_facebook_url = $request->company_facebook_url;
            $setting->save();
            $dataView['saved'] = 1;
        }
        $dataView['setting'] = $setting;
        return view('admin/setting/info',$dataView);
    }
    
    public function sendmail(Request $request){
        
        $setting = Setting::first();
        $dataView = [];
        $dataView['saved'] = 0;
        if ($request->isMethod('post')) {
            
            $setting->email_smtp_server = $request->email_smtp_server;
            $setting->email_smtp_port = $request->email_smtp_port;
            $setting->email_smtp_user = $request->email_smtp_user;
            $setting->email_smtp_pass = $request->email_smtp_pass;
            $setting->email_smtp_name = $request->email_smtp_name;
            $setting->email_smtp_email_address = $request->email_smtp_email_address;
            $setting->save();
            $dataView['saved'] = 1;
        }
        $dataView['setting'] = $setting;
        return view('admin/setting/sendmail',$dataView);
    }
    public function seo(Request $request){
        $setting = Setting::first();
        $dataView = [];
        $dataView['saved'] = 0;
        if ($request->isMethod('post')) {
            $setting->seo_page_title = $request->seo_page_title;
            $setting->seo_meta_page_topic = $request->seo_meta_page_topic;
            $setting->seo_meta_copyright = $request->seo_meta_copyright;
            $setting->seo_meta_author = $request->seo_meta_author;
            $setting->seo_meta_keywords = $request->seo_meta_keywords;
            $setting->seo_meta_des = $request->seo_meta_des;
            $setting->save();
            $dataView['saved'] = 1;
                
        }
    $dataView['setting'] = $setting;
    return view('admin/setting/seo',$dataView);
    }

    public function file() {
        return view('admin/setting/file');
    }
    public function emailcontent(Request $request) {

        $emailcontent = EmailContent::get();
        $dataView = [];
        if($request->isMethod('post')){
            $emailcontent->send_when = $request->send_when;
            $emailcontent->name = $request->name;
            $emailcontent->detail = $request->detail;
            $emailcontent->language = (session('lang'))?(session('lang')):(env('DEFAULT_LANGUAGE'));
            $emailcontent->send_when = $request->send_when;
        }
        $dataView['emailcontent'] = $emailcontent;

        return view('admin/setting/emailcontent',$dataView);
    }
    public function itememailcontent(Request $request){
        $item = EmailContent::find($request->id);
        if(!$item){
            $item = new EmailContent;
        } 
        $dataView = [];
        $dataView['saved'] = 0;
        if ($request->isMethod('post')) {

            $item->send_when = $request->send_when;
            $item->need_value = $request->need_value;
            $item->detail = $request->detail;
            $item->name = $request->name;
            $item->language = (session('lang'))?(session('lang')):(env('DEFAULT_LANGUAGE'));
            $item->save();
            $dataView['saved'] = 1;
        }
        $dataView['item'] = $item;
        return view('admin/setting/itememailcontent',$dataView);
    }
}