<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Libraries\UploadFile;
use App\Libraries\SeoFriendly;

use App\Models\Article;
use App\Models\Articlecat;
use App\Models\User;
use App\Models\Role;

use Response;
use Auth;

class ArticleController extends Controller
{
    /**
     * Show list of articles
     * 
     * @param \Request  $request
     * @return \Response
     */
    public function index(Request $request){
        $dataView = [];
        $list_cat = new Articlecat();
        $list_mod = User::withRole(['admin', 'moderator', 'editor', 'publisher'])->sortBy('name');
        $articles = null;

        $condition = [];
        $filter = [];

        if (session('lang')!=null) {
            $condition[] = ['language', session('lang')];
        }
        else {
            $condition[] = ['language', env('DEFAULT_LANGUAGE')];
        }
        if ($request->f_cat && $request->f_cat!=0) {
            $condition[] = ['cat', $request->f_cat];
        }
        if ($request->f_name) {
            $filter['name'] = $request->f_name;
            $condition[] = ['name', 'like', '%'.$request->f_name.'%'];
        }
        if ($request->f_fromdate) {
            $filter['fromdate'] = $request->f_fromdate;
            $condition[] = ['updated_at','>=',$request->f_fromdate];
        }
        if ($request->f_todate) {
            $filter['todate'] = $request->f_todate;
            $condition[] = ['updated_at','<=',$request->f_todate];
        }
        if ($request->f_fromdate) {
            $filter['fromdate'] = $request->f_fromdate;
            $condition[] = ['updated_at','>=',$request->f_fromdate];
        }
        if ($request->f_lastchange) {
            $filter['lastchange'] = $request->f_lastchange;
            $condition[] = ['updated_by', $request->f_lastchange];
        }

        $articles = Article::orderBy('order','desc')->where($condition)->paginate(9);

        $dataView['articles'] = $articles;
        isset($request->f_cat)?$list_cat = $list_cat->GetOptions($request->f_cat):$list_cat = $list_cat->GetOptions(0);
        if ($request->ajax()) {
            return Response::json(view('admin/article/list', $dataView)->render());
        }

        $dataView['filter'] = $filter;
        $dataView['list_mod'] = $list_mod;
        $dataView['list_cat'] = $list_cat;
        return view('admin/article/index',$dataView);
    }

    /**
     * Add new or edit an exist article
     * 
     * @param \Request $request
     * @param $id article_id
     * @return mixed
     */
    public function detail(Request $request, $id = null) {
        $saved = 0;
        $slug_exists = 0;
        $dataView = [];
        $article = null;
        $list_cat = null;

        if ($id !== null) {
            $article = Article::where('id', $id)->first();
        }
        else if ($request->act == 'copy') {
            $article = Article::where('id', $request->id)->first();
            $article->id = null;
            $article->public = 0;
            $article->highlight = 0;
            $article->new = 0;
        }
        else {
            $article = new Article();
        }
        $list_cat = new Articlecat();
        $list_cat = $list_cat->GetOptions($article->cat);

        if ($request->isMethod('post')) {
            if($request->file('image') && $request->file('image')->isValid()){
                $folder = public_path('media/article/');
                $image = UploadFile::uploadImage($_FILES['image'], $folder, $article->image);
            } 
            else if ($article->id==null && $request->current_image!=null) {
                $folder = public_path('media/article/');
                $img_name = $request->current_image;
                $path_parts = pathinfo($folder.$img_name);
                $ext = $path_parts['extension'];
                list($usec, $sec) = explode(".", microtime(true));
                $new_img_name = $usec.$sec.".".$ext;
                
                if (file_exists($folder.$img_name)) copy ($folder.$img_name, $folder.$new_img_name);
                if (file_exists($folder.'tb/'.$img_name)) copy ($folder.'tb/'.$img_name, $folder.'tb/'.$new_img_name);
                $image = $new_img_name;
            }
            else {
                $image = $article->image;
            }
            $article->name = $request->name;
            $article->cat = $request->cat;
            $article->image = $image?$image:'';
            $article->des = $request->des?$request->des:'';
            $article->detail = $request->detail?$request->detail:'';
            $article->page_title = $request->page_title?$request->page_title:'';
            $article->meta_des = $request->meta_des?$request->meta_des:'';
            $article->meta_keyword = $request->meta_keyword?$request->meta_keyword:'';
            $article->meta_page_topic = $request->meta_page_topic?$request->meta_page_topic:'';
            $article->public = isset($request->public)?1:0;
            $article->new = isset($request->new)?1:0;
            $article->highlight = isset($request->highlight)?1:0;
            $article->language = session('lang')!=null?session('lang'):(env('DEFAULT_LANGUAGE'));
            $article->order = $article->order?$article->order:(Article::max('order') ? (Article::max('order') + 1) : 1);
            $article->updated_by = Auth::id();
            
            if ($request->slug) {
                $slug = $request->slug;
                if (Article::where([['slug',$slug],['id','<>',$article->id]])->first()) {
                    $article->slug = $slug;
                    $slug_exists = 1;
                    $dataView['saved'] = $saved;
                    $dataView['article'] = $article;
                    $dataView['list_cat'] = $list_cat;
                    $dataView['slug_exists'] = $slug_exists;
                    return view('admin/article/detail', $dataView);
                }
            }
            else {
                $article->save();
                $slug = SeoFriendly::slugify($request->name."-".$article->id);
            }
            $article->slug = $slug;
            $article->save();

            $list_cat = new Articlecat();
            $list_cat = $list_cat->GetOptions($article->cat);
            
            $dataView['saved'] = 1;
        }

        $dataView['slug_exists'] = $slug_exists;
        $dataView['saved'] = $saved;
        $dataView['article'] = $article;
        $dataView['list_cat'] = $list_cat;
        return view('admin/article/detail', $dataView);
    }

    /**
     * Delete an article or multi articles
     * 
     * @param $id the id number of article(s)
     * @return bool
     */
    public function delete($id) {
        $article = Article::find(explode(',', $id));
        foreach($article as $key=>$value) {
            if ($value->image)
                $this->delete_image($value->id);
            $value->delete();
        }
        // $article->delete();
        //->delete();
        die('0');
    }
    
    /**
     * Change an attribute of [public, highlight, new] to true or false
     * 
     * @param \Request
     */
    public function changefield(Request $request) {
        $field = $request->field;
        $article = Article::find($request->id);
        $article->$field = $request->p?'0':'1';
        $article->save();
        die($request->p);
    }

    /**
     * Move an article to top
     * 
     * @param Article
     * @param $article_cat $article catgory id in filter
     * @param \Request
     * @return mixed
     */
    public function movetop(Article $article,$articlecat = null, Request $request){
        $condition = [];
        $condition[] = ['order', '>', $article->order];
        $condition[] = ['language', session('lang')];
        if ($articlecat) {
            $id_string = $articlecat;
            Articlecat::getIdString($articlecat, $id_string);
            $otherArticles = Article::where($condition)->whereIn('cat', explode(',', $id_string))->orderBy('order', 'asc')->get();
        } else {
            $otherArticles = Article::where($condition)->orderBy('order', 'asc')->get();
        }
        foreach ($otherArticles as $otherArticle){
            $oldorder = $article->order;
            $article->order = $otherArticle->order;
            $otherArticle->order = $oldorder;
            $article->save();
            Article::where('id', $otherArticle->id)->update(['order' => $oldorder]);
        }
        if ($request->ajax()) {
            return 0;
        }
    }

    /**
     * Sort article
     * 
     * @param \Request
     * @return mixed
     */
    public function sort(Request $request){
        $items = $request->sort;
		$order = array();
		foreach ($items as $c) {
			$id = str_replace('item_', '', $c);
			$order[] = Article::find($id)->order;
		}
		rsort($order);
		foreach ($order as $k => $v) {
            Article::where('id', str_replace('item_', '', $items[$k]))->update(['order' => $v]);
		}
    }

    /**
     * Delete article's image
     * 
     * @param $id article-id
     * @return mixed
     */
    public function delete_image($id){
        $article = Article::find($id);
        $folder = $_SERVER['DOCUMENT_ROOT'] . '/media/article/';
        if (file_exists($folder . $article->image))	unlink($folder . $article->image);
        if (file_exists($folder . 'tb/' . $article->image))	unlink($folder . 'tb/' . $article->image);
        $article->image = '';
        $article->save();
    }
}
