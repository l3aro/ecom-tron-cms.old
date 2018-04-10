<?php

namespace App\Http\Controllers\Admin;

use App\Libraries\UploadHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\UploadFile;
use App\Libraries\SeoFriendly;
use App\Models\Productcat;
use DB;
use Auth;

class ProductCatController extends Controller
{
    public function index(Request $request){
        $productCat = new Productcat();
        $categories = $productCat->GetCategories();
        $dataView['categories'] = $categories;
        return view('admin/productcat/index', $dataView);
    }

    public function detail(Request $request){
        $slug_exists = 0;
        $category = Productcat::find($request->id);
        if(!$category){
            $category = new Productcat;
        } 
        $dataView = [];
        $dataView['saved'] = 0;
        $image = '';
        $parent = $request->parent;
        if (!$parent) $parent = $category->parent;
        if ($request->isMethod('post')) {
            if($request->file('image') && $request->file('image')->isValid()){
                $folder = public_path('media/product_cat/');
                $image = UploadFile::uploadImage($_FILES['image'], $folder, $category->image);
            } else {
                $image = $category->image;
            }
            $category->name = $request->name;
            $category->parent = (int)$request->parent;
            $category->image = $image?$image:'';
            $category->des = $request->des?$request->des:'';
            $category->page_title = $request->page_title?$request->page_title:'';
            $category->meta_des = $request->meta_des?$request->meta_des:'';
            $category->meta_keyword = $request->meta_keyword?$request->meta_keyword:'';
            $category->meta_page_topic = $request->meta_page_topic?$request->meta_page_topic:'';
            $category->highlight = isset($request->highlight)?1:0;
            $category->language = (session('lang'))?(session('lang')):(env('DEFAULT_LANGUAGE'));
            $maxorder = Productcat::whereRaw('`order` = (select max(`order`) from product_cat)')->first();
            $category->order = $category->order?$category->order:($maxorder ? ($maxorder->order + 1) : 1);
            $category->updated_by = Auth::id();

            if ($request->slug) {
                $slug = $request->slug;
                if (Productcat::where([['slug',$slug],['id','<>',$category->id]])->first()) {
                    $category->slug = $slug;
                    $slug_exists = 1;
                    $dataView['saved'] = $saved;
                    $dataView['category'] = $category;
                    $productcat = new Productcat();
                    $dataView['category_options'] = $productcat->GetOptions($parent);
                    $dataView['slug_exists'] = $slug_exists;
                    return view('admin/productcat/detail', $dataView);
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
        $productcat = new Productcat();
        $dataView['category_options'] = $productcat->GetOptions($parent);
        $dataView['slug_exists'] = $slug_exists;
    	return view('admin/productcat/detail', $dataView);
    }

    public function deleteimage(Request $request){
        $id = $request->id;
        $record = Productcat::find($id);
		$folder = $_SERVER['DOCUMENT_ROOT'] . '/media/product_cat/';
		if (file_exists($folder . $record->image))	unlink($folder . $record->image);
		if (file_exists($folder . 'tb/' . $record->image))	unlink($folder . 'tb/' . $record->image);
		$record->image = '';
		$record->save();
    }

    /**
     * Delete an article category and its children
     * 
     * @param $id article_id
     * @return mixed
     */
    private function delete_child_cat($id) {
        if (Productcat::find($id) == null)
            return;
        if (Productcat::where('parent', $id)->count() > 0) {
            foreach (Productcat::where('parent', $id)->get() as $key=>$value) {
                $this->delete_child_cat($value->id);
            }
        }
        Productcat::find($id)->delete();
    }

    /**
     * Delete multi categories
     * 
     * @param $id array of article id
     * @return mixed
     */
    public function delete($id) {
        $not_delete = '';
        foreach (explode(',', $id) as $key=>$value) {
            if ($this->validate_delete_child_cat(Productcat::find($value)) != 0) {
                $this->delete_child_cat($value);
            }
            else {
                $not_delete .= $value.',';
            }    
        }
        if ($not_delete == '')
            die('0');
        else
            die($not_delete);
    }
     /**
     * Determine input category have product in it/its child or not
     * 
     * @param Productcat $cat
     * @return bool
     */
    private function validate_delete_child_cat(Productcat $cat) {
        if ($cat->product()->count() > 0) {
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
			$order[] = Productcat::find($id)->order;
		}
		rsort($order);
		foreach ($order as $k => $v) {
            Productcat::where('id', str_replace('cat_', '', $cats[$k]))->update(['order' => $v]);
		}
    }
}
