<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
class ContactController extends Controller
{
    public function index(Request $request){
        $lang = session('lang');
        if (!$lang) $lang = env('DEFAULT_LANGUAGE');
        $user = Contact::where('language', $lang)->orderBy('created_at','desc')->get();
        $dataView = [];
        if ($request->isMethod('post')){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->title = $request->title;
            $user->content = $request->content;
            $user->sent_date = $request->sent_date;
            $user->language = $request->language;
            $user->updated_by = $request->updated_by;
            $user->created_at = $request->created_at;
            $user->upated_at = $request->upated_at;
        }
        $dataView['user'] = $user;

        return view('admin/contact/index',$dataView);
    }
    public function detail(Request $request){
        $lang = session('lang');
        if (!$lang) $lang = env('DEFAULT_LANGUAGE');
        $infouser = Contact::find($request->id);
        $dataView = [];
        if ($request->isMethod('post')){
            $infouser->name = $request->name;
            $infouser->email = $request->email;
            $infouser->phone = $request->phone;
            $infouser->address = $request->address;
            $infouser->content = $request->content;
        }
        $dataView['infouser'] = $infouser;

        return view('admin/contact/detail',$dataView);
    }
    public function delete_cat(Contact $id){

        $id->delete();
        return redirect('admin/contact');
    }
    public function delete(Contact $contact, Request $request){
        $contact->delete();
        if ($request->ajax()) {
            return 0;
        }
    }
}
