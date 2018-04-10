<?php
namespace App\Http\Controllers\Admin;
use App\Libraries\UploadHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\SeoFriendly;
use App\Libraries\UploadFile;
use App\Models\Videocat;
use App\Models\Video;
use App\Models\User;
use Response;
use Auth;
class VideoController extends Controller
{
    public function index(Request $request){
        $lang = session('lang');
        if (!$lang) $lang = env('DEFAULT_LANGUAGE');
        $dataView = [];
        $list_cat = null;
        $videos = null;
        $list_cat = new Videocat();
        $list_cat = $list_cat->GetOptions($request->cat);
        $condition = [];
        if ($request->cat && $request->cat!=0) $condition[] = ['cat', $request->cat];
        if ($request->keyword) $condition[] = ['name', 'like', '%'.$request->keyword.'%'];
        if ($request->from_date) $condition[] = ['updated_at','>=',$request->from_date];
        if ($request->to_date) $condition[] = ['updated_at','<=',$request->to_date];
        if ($request->user) $condition[] = ['updated_by', $request->user];
        $videos = Video::where($condition)->where('language', $lang)
                                ->orderBy('order','desc')
                                ->paginate(10);
        $dataView['video'] = $videos;
        if ($request->ajax()) {
            return Response::json(view('admin/video/list_video', $dataView)->render());
        }
        $users = User::GetUserOptions($request->user);
        $dataView['list_cat'] = $list_cat;
        $dataView['list_user'] = $users;
        $dataView['from_date'] = $request->from_date;
        $dataView['to_date'] = $request->to_date;
        return view('admin/video/index', $dataView);
    }
    public function detail(Request $request){
        $slug_exists = 0;
        $lang = session('lang');
        if (!$lang) $lang = env('DEFAULT_LANGUAGE');
        $category = Video::find($request->id);
        if(!$category){
            $category = new Video;
        } 
        $videocat = Videocat::where('language', $lang)->orderBy('id','desc')->get();
        $dataView = [];
        $dataView['saved'] = 0;
        $image = '';
        $parent = $request->parent;
        if (!$parent) {
            $parent = $category->parent;
        }
        $cat = $request->id;
        if (!$cat) {
            $cat = $category->id;
        }
        if ($request->isMethod('post')) {
            if($request->file('image') && $request->file('image')->isValid()){
                $folder = public_path('media/video/');
                $image = UploadFile::uploadImage($_FILES['image'], $folder, $category->image);
            } else {
                $image = $category->image;
            }
            $category->name = $request->name;
            $category->url = $request->url;
            $urlcode = trim($request->url,'https://www.youtube.com/watch?v=');
            $codearray = array('<iframe width="100%" height="315" src="https://www.youtube.com/embed/','" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>');
            $category->code = implode($urlcode, $codearray);;
            $category->cat = $request->cat;
            $category->image = $image?$image:'';
            $category->des = $request->des?$request->des:'';
            $category->detail = $request->detail?$request->detail:'';
            $category->page_title = $request->page_title?$request->page_title:'';
            $category->meta_des = $request->meta_des?$request->meta_des:'';
            $category->meta_keyword = $request->meta_keyword?$request->meta_keyword:'';
            $category->meta_page_topic = $request->meta_page_topic?$request->meta_page_topic:'';
            $category->highlight = isset($request->highlight)?1:0;
            $category->new = isset($request->new)?1:0;
            $category->public = isset($request->public)?1:0;
            
            $category->language = (session('lang'))?(session('lang')):(env('DEFAULT_LANGUAGE'));
            $maxorder = Video::whereRaw('`order` = (select max(`order`) from video)')->first();
            $category->order = $category->order?$category->order:($maxorder ? ($maxorder->order + 1) : 1);
            $category->updated_by = Auth::id();
            
            if ($request->slug) {
                $slug = $request->slug;
                if (Video::where([['slug',$slug],['id','<>',$category->id]])->first()) {
                    $product->slug = $slug;
                    $slug_exists = 1;
                    $dataView['saved'] = $saved;
                    $dataView['slug_exists'] = $slug_exists;
                    $dataView['category'] = $category;
                    $dataView['videocat'] = $videocat;
                    return view('admin/video/detail', $dataView);
                }
            }
            else {
                $category->save();
                $slug = SeoFriendly::slugify($request->name."-".$category->id);
            }
            $category->slug = $slug;

            $category->save();
            $dataView['saved'] = 1;
        }
        $dataView['slug_exists'] = $slug_exists;
        $dataView['category'] = $category;
        $dataView['videocat'] = $videocat;
    	return view('admin/video/detail', $dataView);
    }
    public function sort(Request $request){
        $items = $request->sort;
		$order = array();
		foreach ($items as $c) {
			$id = str_replace('item_', '', $c);
			$order[] = Video::find($id)->order;
		}
		rsort($order);
		foreach ($order as $k => $v) {
            Video::where('id', str_replace('item_', '', $items[$k]))->update(['order' => $v]);
		}
    }
    public function delete(Video $video, Request $request){
        $video->delete();
        if ($request->ajax()) {
            return 0;
        }
    }
    public function changfield(Request $request){
        $field = $request->field;
        $video = Video::find($request->id);
        $video->$field = $request->p?'0':'1';
        $video->save();
        die($request->p);
    }
}
