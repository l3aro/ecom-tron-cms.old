<?php

namespace App\Http\Controllers\Admin;

use App\Libraries\UploadHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\UploadFile;
use App\Models\Menu;
use App\Models\Menucat;
use App\Models\Productcat;
use App\Models\Product;
use App\Models\Articlecat;
use App\Models\Article;
use Response;
use DB;
use Auth;

class MenuController extends Controller
{
    public function index(Request $request){
        $dataView = [];
        $conditions = [];
        $conditions[] = ['cat', $request->cat];
        $conditions[] = ['parent', 0];
        $parentMenus = Menu::where($conditions)->with('subMenus')->orderBy('order', 'desc')->get();
        $dataView['menus'] = $parentMenus;
        $dataView['cat'] = $request->cat;
        return view('admin/menu/index', $dataView);
    }

    public function detail(Request $request){
        $menu = Menu::find($request->id);
        if(!$menu){
            $menu = new Menu;
        }
        $menucat = Menucat::orderBy('id','desc')->get();
        $dataView = [];
        $dataView['saved'] = 0;
        $parent = $request->parent;
        if (!$parent) $parent = $menu->parent;
        $cat = $request->cat;
        if (!$cat) {
            $cat = $menu->cat;
        }
        if ($request->isMethod('post')) {
            
            $menu->name = $request->name;
            $menu->cat = $request->cat;
            $menu->type = $request->type;
            $menu->parent = (int)$request->parent;
            $menu->article_id = (int)$request->article_id;
            $menu->article_cat = (int)$request->article_cat;
            $menu->product_id = (int)$request->product_id;
            $menu->product_cat = (int)$request->product_cat;
            $menu->link = $request->link;
            $menu->des = $request->des?$request->des:'';
            $menu->language = (session('lang'))?(session('lang')):(env('DEFAULT_LANGUAGE'));
            $maxorder = Menu::whereRaw('`order` = (select max(`order`) from menu)')->first();
            $menu->order = $menu->order?$menu->order:($maxorder ? ($maxorder->order + 1) : 1);
            $menu->updated_by = Auth::id();
            $menu->save();
            $dataView['saved'] = 1;
        }
        $dataView['menu'] = $menu;
        $dataView['menucat'] = $cat;
        $menuModel = new Menu();
        $dataView['menu_options'] = $menuModel->GetOptions($parent, $cat);
        $articlecat = new Articlecat();
        $dataView['article_cat_options'] = $articlecat->GetOptions($menu->article_cat);
        $productcat = new Productcat();
        $dataView['product_cat_options'] = $productcat->GetOptions($menu->product_cat);
    	return view('admin/menu/detail', $dataView);
    }

    public function list_articles(Request $request){
        $dataView = [];
        $list_cat = null;
        $articles = null;

        $list_cat = new Articlecat();
        $list_cat = $list_cat->GetOptions($request->cat);
        $condition = [];
        if ($request->cat && $request->cat!=0) $condition[] = ['cat', $request->cat];
        if ($request->keyword) $condition[] = ['name', 'like', '%'.$request->keyword.'%'];
        $condition[] = ['language', session('lang')];

        $articles = Article::where($condition)
                                ->orderBy('order','desc')
                                ->paginate(10);
        $dataView['list_cat'] = $list_cat;
        $dataView['keyword'] = $request->keyword;
        $dataView['article'] = $articles;
        return view('admin/menu/list_article', $dataView);
    }

    public function list_products(Request $request){
        $dataView = [];
        $list_cat = null;
        $products = null;

        $list_cat = new Productcat();
        $list_cat = $list_cat->GetOptions($request->cat);
        $condition = [];
        if ($request->cat && $request->cat!=0) $condition[] = ['cat', $request->cat];
        if ($request->keyword) $condition[] = ['name', 'like', '%'.$request->keyword.'%'];
        $condition[] = ['language', session('lang')];

        $products = Product::where($condition)
                                ->orderBy('order','desc')
                                ->paginate(10);
        $dataView['list_cat'] = $list_cat;
        $dataView['keyword'] = $request->keyword;
        $dataView['product'] = $products;
        return view('admin/menu/list_product', $dataView);
    }

    /**
     * Delete an article category and its children
     * 
     * @param $id article_id
     * @return mixed
     */
    private function delete_child_cat($id) {
        if (Menu::find($id) == null)
            return;
        if (Menu::where('parent', $id)->count() > 0) {
            foreach (Menu::where('parent', $id)->get() as $key=>$value) {
                $this->delete_child_cat($value->id);
            }
        }
        Menu::find($id)->delete();
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
            if ($this->validate_delete_child_cat(Menu::find($value)) != 0) {
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
     * Determine input category have menu in it/its child or not
     * 
     * @param Menu $cat
     * @return bool
     */
    private function validate_delete_child_cat(Menu $cat) {
        if ($cat->menu()->count() > 0) {
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
			$order[] = Menu::find($id)->order;
		}
		rsort($order);
		foreach ($order as $k => $v) {
            Menu::where('id', str_replace('cat_', '', $cats[$k]))->update(['order' => $v]);
		}
    }

    public function get_article(Request $request){
        $data = [];
        $data['article'] = Article::find($request->id);
        $data['article_cat'] = $data['article']->article_cat;
        return Response::json($data);
    }

    public function get_product(Request $request){
        $data = [];
        $data['product'] = Product::find($request->id);
        $data['product_cat'] = $data['product']->product_cat;
        return Response::json($data);
    }
}
