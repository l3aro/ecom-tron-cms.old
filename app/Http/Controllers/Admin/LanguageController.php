<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\UploadFile;
use App\Models\Language;
use App\Models\Languagekey;
use App\Models\Languagevalue;
use Auth;

class LanguageController extends Controller
{
    public function index(){
        return view('admin/language/index');
    }
    public function language(Request $request){
        $lang = Language::orderBy('name','desc')->get();
        $lang_key = Languagekey::find($request->id);
        if(!$lang_key){
            $lang_key = new Languagekey;
        }
        $lang_value = $lang_key->lang_value()->orderBy('created_at','desc')->get();
        $lang_value = $lang_value->toArray();
        foreach($lang_value as $key=>$value) {
            $lang_value[$value['lang']] = $value;
            unset($lang_value[$key]);
        }
        $dataView = [];
        $dataView['saved'] = 0;
        if ($request->isMethod('post')) {
           
            $lang_key->name = $request->get('name');
            $lang_key->code = $request->get('code');
            $lang_key->updated_by = Auth::id();
            $lang_key->save();
            foreach($lang as $key=>$value) {
                $lang_key->lang_value()->create([
                    'lang' => $value->short_name,
                    'key_code' => $lang_key->code,
                    'value' => $request->get('lang_'.$value->short_name),
                    'updated_by' => Auth::id(),
                ]);
            }
            $dataView['saved'] = 1;
        }
        
        $dataView['lang'] = $lang;
        $dataView['lang_key'] = $lang_key;
        $dataView['lang_value'] = $lang_value;
        return view('admin/language/language',$dataView);
    }
    
    public function item(Request $request){
        $itemlang = Language::find($request->id);
        if(!$itemlang){
            $itemlang = new Language;
        }
        $dataView = [];
        $dataView['saved'] = 0;
        $image = '';
        if ($request->isMethod('post')) {
            if($request->file('image') && $request->file('image')->isValid()){
                $folder = public_path('media/lang/');
                $image = UploadFile::uploadImage($_FILES['image'], $folder, $itemlang->image);
            } else {
                $image = $itemlang->image;
            }
            $itemlang->name = $request->name;
            $itemlang->short_name = $request->short_name;
            $itemlang->image = $image?$image:'';
            $itemlang->updated_by = Auth::id();
            $itemlang->save();
            $dataView['saved'] = 1;
        }
        $dataView['itemlang'] = $itemlang;
        return view('admin/language/item',$dataView);
    }
    public function deletelangimage(Request $request){
        $id = $request->id;
        $record = Language::find($id);
		$folder = $_SERVER['DOCUMENT_ROOT'] . '/media/lang/';
		if (file_exists($folder . $record->image))	unlink($folder . $record->image);
		if (file_exists($folder . 'tb/' . $record->image))	unlink($folder . 'tb/' . $record->image);
		$record->image = '';
		$record->save();
    }
    
    public function listlang(Request $request){
        $lang = Language::orderBy('name','desc')->get();
        $dataView = [];
        $dataView['saved'] = 0;

        $lang_key = Languagekey::orderBy('name','desc')->get();
        $lang_array = $lang_key;

        $lang_value = [];
        foreach($lang_key as $key=>$value) {
            $lang_array[$key]['value'] = $value->lang_value()->get()->toArray();
        }

        $dataView['lang'] = $lang;
        $dataView['lang_key'] = $lang_array;
        return view('admin/language/listlang', $dataView);
    }
}
