<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Component;
use App\Models\User;
use Auth;
class ComponentController extends Controller
{
    public function index(Request $request){
        $lang = session('lang');
        if (!$lang) $lang = env('DEFAULT_LANGUAGE');
        $component = Component::where('language', $lang)->orderBy('id','desc')->get();
        
        $dataView = [];
        if ($request->isMethod('post')){
            $component->name = $request->name;
            $component->type = $request->type;
            $component->value = $request->value;
            $component->detail = $request->detail;
            $component->public = isset($request->public)?1:0;
            $component->language = (session('lang'))?(session('lang')):(env('DEFAULT_LANGUAGE'));
            $maxorder = Component::whereRaw('`order` = (select max(`order`) from component)')->first();
            $component->order = $component->order?$component->order:($maxorder ? ($maxorder->order + 1) : 1);
            $component->updated_by = Auth::id();
            $component->created_at = $request->created_at;
            $component->updated_at = $request->updated_at;
        }
        $dataView['component'] = $component;
        return view('admin/component/index',$dataView);
    }
    public function item(Request $request){
        $item = Component::find($request->id);
        if(!$item){
            $item = new Component;
        }
        $dataView = [];
        $dataView['saved'] = 0;
        if ($request->isMethod('post')) {
            $item->name = $request->name;
            $item->detail = $request->detail;
            $item->public = isset($request->public)?1:0;
            $item->language = (session('lang'))?(session('lang')):(env('DEFAULT_LANGUAGE'));
            $maxorder = Component::whereRaw('`order` = (select max(`order`) from component)')->first();
            $item->order = $item->order?$item->order:($maxorder ? ($maxorder->order + 1) : 1);
            $item->updated_by = Auth::id();
            $item->save();
            $dataView['saved'] = 1;
        }
        $dataView['item'] = $item;
        return view('admin/component/item',$dataView);
    }
    public function delete_cat(Component $id){
        $id->delete();
        return redirect('admin/component');
    }
}
