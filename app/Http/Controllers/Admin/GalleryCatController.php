<?php

namespace App\Http\Controllers\Admin;

use App\Libraries\UploadHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\UploadFile;
use App\Libraries\SeoFriendly;
use App\Models\Gallerycat;
use DB;
use Auth;

class GalleryCatController extends Controller
{
    public function index(Request $request){
        $gallerycat = new Gallerycat();
        $categories = $gallerycat->GetCategories();
        $dataView['categories'] = $categories;
        return view('admin/gallerycat/index', $dataView);
    }

    public function detail(Request $request){
        $category = Gallerycat::find($request->id);
        $slug_exists = 0;
        if(!$category){
            $category = new Gallerycat;
        } 
        $dataView = [];
        $dataView['saved'] = 0;
        $image = '';
        $parent = $request->parent;
        if (!$parent) $parent = $category->parent;
        if ($request->isMethod('post')) {
            if($request->file('image') && $request->file('image')->isValid()){
                $folder = public_path('media/gallery_cat/');
                $image = UploadFile::uploadImage($_FILES['image'], $folder, $category->image);
            } else {
                $image = $category->image;
            }
            $category->name = $request->name;
            $category->parent = (int)$request->parent;
            $category->image = $image?$image:'';
            $category->detail = $request->detail?$request->detail:'';
            $category->page_title = $request->page_title?$request->page_title:'';
            $category->meta_des = $request->meta_des?$request->meta_des:'';
            $category->meta_keyword = $request->meta_keyword?$request->meta_keyword:'';
            $category->meta_page_topic = $request->meta_page_topic?$request->meta_page_topic:'';
            $category->highlight = isset($request->highlight)?1:0;
            $category->public = isset($request->public)?1:0;
            $category->language = (session('lang'))?(session('lang')):(env('DEFAULT_LANGUAGE'));
            $maxorder = Gallerycat::whereRaw('`order` = (select max(`order`) from gallery_cat)')->first();
            $category->order = $category->order?$category->order:($maxorder ? ($maxorder->order + 1) : 1);
            $category->updated_by = Auth::id();

            if ($request->slug) {
                $slug = $request->slug;
                if (Gallerycat::where([['slug',$slug],['id','<>',$category->id]])->first()) {
                    $category->slug = $slug;
                    $slug_exists = 1;
                    $dataView['saved'] = $saved;
                    $dataView['category'] = $category;
                    $gallerycat = new Gallerycat();
                    $dataView['category_options'] = $gallerycat->GetOptions($parent);
                    $dataView['slug_exists'] = $slug_exists;
                    return view('admin/gallerycat/detail', $dataView);
                }
            }
            else {
                $slug = SeoFriendly::slugify($request->name);
            }
            $category->slug = $slug;
            $category->save();
            $dataView['saved'] = 1;
        }
        $dataView['category'] = $category;
        $gallerycat = new Gallerycat();
        $dataView['category_options'] = $gallerycat->GetOptions($parent);
        $dataView['slug_exists'] = $slug_exists;
    	return view('admin/gallerycat/detail', $dataView);
    }

    public function deleteimage(Request $request){
        $id = $request->id;
        $record = Gallerycat::find($id);
		$folder = $_SERVER['DOCUMENT_ROOT'] . '/media/gallery_cat/';
		if (file_exists($folder . $record->image))	unlink($folder . $record->image);
		if (file_exists($folder . 'tb/' . $record->image))	unlink($folder . 'tb/' . $record->image);
		$record->image = '';
		$record->save();
    }

    public function delete(Gallerycat $gallerycat, Request $request){
        if ($this->validate_delete_child_cat($gallerycat)) {
            $gallerycat->where('parent', $gallerycat->id)->delete();
            $gallerycat->delete();
            if ($request->ajax()) {
                return 0;
            }
        } else {
            if ($request->ajax()) {
                return 'Mục bạn cần xóa vẫn còn sản phẩm! Hãy xóa hết sản phẩm trước khi xóa mục này!';
            } else {
                echo '<script type="text/javascript"> confirm("Mục bạn cần xóa vẫn còn sản phẩm! Hãy xóa hết sản phẩm trước khi xóa mục này!");</script>';
            }
        }
    }
     /**
     * Determine input category have gallery in it/its child or not
     * 
     * @param Gallerycat $cat
     * @return bool
     */
    private function validate_delete_child_cat(Gallerycat $cat) {
        if ($cat->gallery()->count() > 0) {
            return 0;
        }
        if ($cat->where('parent', $cat->id)->count() > 0) {
            foreach ($cat->where('parent', $cat->id)->get() as $key=>$value) {
                if ($this->validate_delete_child_cat($value) == 0) {
                    return 0;
                }
            }
        }
        return 1;
    }

    public function sortcat(Request $request){
        $cats = $request->sort;
		$order = array();
		foreach ($cats as $c) {
			$id = str_replace('cat_', '', $c);
			$order[] = Gallerycat::find($id)->order;
		}
		rsort($order);
		foreach ($order as $k => $v) {
            Gallerycat::where('id', str_replace('cat_', '', $cats[$k]))->update(['order' => $v]);
		}
    }
}
