<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menucat;
use App\Models\User;
use Auth;
class MenuCatController extends Controller
{
    public function index(Request $request){
        $menucat = Menucat::where('language', session('lang'))->orderBy('id','desc')->get();
        $dataView = [];
        if ($request->isMethod('post')){
            $menucat->name = $request->name;
            $menucat->public = $request->public;
            $menucat->language = $request->language;
            $menucat->order = $request->order;
            $menucat->updated_by = $request->updated_by;
            $menucat->created_at = $request->created_at;
            $menucat->updated_at = $request->updated_at;
        }
        $dataView['menucat'] = $menucat;
        return view('admin/menucat/index',$dataView);
    }
    public function detail(Request $request){
        $item = Menucat::find($request->id);
        if(!$item){
            $item = new Menucat;
        }
        $dataView = [];
        $dataView['saved'] = 0;
        if ($request->isMethod('post')) {
            $item->name = $request->name;
            $item->public = isset($request->public)?1:0;
            $item->language = session('lang')?session('lang'):(env('DEFAULT_LANGUAGE'));
            $maxorder = Menucat::whereRaw('`order` = (select max(`order`) from menu_cat)')->first();
            $item->order = $item->order?$item->order:($maxorder ? ($maxorder->order + 1) : 1);
            $item->updated_by = Auth::id();
            $item->save();
            $dataView['saved'] = 1;
        }
        $dataView['item'] = $item;
        return view('admin/menucat/detail',$dataView);
    }
    public function delete_cat(MenuCat $id){
    $id->delete();
    return redirect('admin/menucat');
    }
}
