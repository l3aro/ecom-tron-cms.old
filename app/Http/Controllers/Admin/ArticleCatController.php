<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Libraries\UploadFile;
use App\Libraries\SeoFriendly;

use App\Models\Article;
use App\Models\Articlecat;

use Response;
use Auth;

class ArticleCatController extends Controller
{
    /**
     * Show list of article categories
     * 
     * @param Request  $request
     * @return mixed
     */
    public function index() {
        $cat = new Articlecat();
        $categories = $cat->GetCategories();
        $dataView['categories'] = $categories;  
        return view('admin/articlecat/index', $dataView);
    }

    /**
     * Add new or edit an exist article category
     * 
     * @param Request $request
     * @param article_cat_id $id
     * @return mixed
     */
    public function detail(Request $request, $id = null) {
        $saved = 0;
        $slug_exists = 0;
        $dataView = [];
        $category = null;
        $list_cat = new Articlecat();

        if ($id !== null) {
            $category = Articlecat::where('id', $id)->first();
            $list_cat = $list_cat->GetOptions($category->parent);
        }
        else if ($request->parent != null) {
            $category = new Articlecat();
            $list_cat = $list_cat->GetOptions($request->parent);
        }
        else {
            $category = new Articlecat();
            $list_cat = $list_cat->GetOptions(0);
        }               
        
        if ($request->isMethod('post')) {
            if($request->file('image') && $request->file('image')->isValid()){
                $folder = public_path('media/article_cat/');
                $image = UploadFile::uploadImage($_FILES['image'], $folder, $category->image);
            } else {
                $image = $category->image;
            }
            $category->name = $request->name;
            $category->parent = $request->parent;
            $category->image = $image?$image:'';
            $category->des = $request->des?$request->des:'';
            $category->page_title = $request->page_title?$request->page_title:'';
            $category->meta_des = $request->meta_des?$request->meta_des:'';
            $category->meta_keyword = $request->meta_keyword?$request->meta_keyword:'';
            $category->meta_page_topic = $request->meta_page_topic?$request->meta_page_topic:'';
            $category->highlight = isset($request->highlight)?1:0;
            $category->language = session('lang')!=null?session('lang'):(env('DEFAULT_LANGUAGE'));
            $category->order = $category->order?$category->order:(Articlecat::max('order') ? (Articlecat::max('order') + 1) : 1);
            $category->updated_by = Auth::id();

            if ($request->slug) {
                $slug = $request->slug;
                if (Articlecat::where([['slug',$slug],['id','<>',$category->id]])->first()) {
                    $category->slug = $slug;
                    $slug_exists = 1;
                    $dataView['saved'] = $saved;
                    $dataView['category'] = $category;
                    $dataView['list_cat'] = $list_cat;
                    $dataView['slug_exists'] = $slug_exists;
                    return view('admin/articlecat/detail', $dataView);
                }
            }
            else {
                $slug = SeoFriendly::slugify($request->name);
            }
            $category->slug = $slug;

            $category->save();

            $list_cat = new Articlecat();
            $list_cat = $list_cat->GetOptions($category->parent);
            
            $saved = 1;
        }

        $dataView['saved'] = $saved;
        $dataView['slug_exists'] = $slug_exists;
        $dataView['category'] = $category;
        $dataView['list_cat'] = $list_cat;
        return view('admin/articlecat/detail', $dataView);
    }

    /**
     * Determine input category have article in it/its children or not
     * 
     * @param $id articlecat_id
     * @return bool
     */
    private function validate_delete_child_cat($id) {
        if (Articlecat::find($id) == null)
            return 1;
        $cat = Articlecat::where('id', $id)->first();
        if ($cat->article()->count() > 0) {
            return 0;
        }
        if (Articlecat::where('parent', $cat->id)->count() > 0) {
            foreach (Articlecat::where('parent', $cat->id)->get() as $key=>$value) {
                if ($this->validate_delete_child_cat($value->id) == 0) {
                    return 0;
                }
            }
        }
        return 1;
    }

    /**
     * Delete an article category and its children
     * 
     * @param $id article_id
     * @return mixed
     */
    private function delete_child_cat($id) {
        if (Articlecat::find($id) == null)
            return;
        if (Articlecat::where('parent', $id)->count() > 0) {
            foreach (Articlecat::where('parent', $id)->get() as $key=>$value) {
                $this->delete_child_cat($value->id);
            }
        }
        $this->delete_image($id);
        Articlecat::find($id)->delete();
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
            if ($this->validate_delete_child_cat($value) != 0) {
                $this->delete_child_cat($value);
            }
            else {
                $not_delete .= $value.',';
            }    
        }
        if ($not_delete == '')
            die('1');
        else
            die($not_delete);
    }

    /**
     * Sort article category
     * 
     * @param \Request
     * @return mixed
     */
    public function sortcat(Request $request){
        $cats = $request->sort;
		$order = array();
		foreach ($cats as $c) {
			$id = str_replace('cat_', '', $c);
			$order[] = ArticleCat::find($id)->order;
		}
		rsort($order);
		foreach ($order as $k => $v) {
            Articlecat::where('id', str_replace('cat_', '', $cats[$k]))->update(['order' => $v]);
		}
    }

    /**
     * Delete article category's image
     * 
     * @param $id articlecat-id
     * @return mixed
     */
    public function delete_image($id){
        $article_cat = Articlecat::find($id);
        $folder = $_SERVER['DOCUMENT_ROOT'] . '/media/article_cat/';
        if ($article_cat->image) {
            if (file_exists($folder . $article_cat->image))	unlink($folder . $article_cat->image);
            if (file_exists($folder . 'tb/' . $article_cat->image))	unlink($folder . 'tb/' . $article_cat->image);
            $article_cat->image = '';
            $article_cat->save();
        }
    }
}
