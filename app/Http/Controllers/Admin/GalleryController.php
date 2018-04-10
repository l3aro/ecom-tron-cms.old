<?php

namespace App\Http\Controllers\Admin;

use App\Libraries\UploadHandler;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\UploadFile;
use App\Libraries\SeoFriendly;
use App\Models\GalleryCat;
use App\Models\Gallery;
use App\Models\User;
use Response;
use Auth;

class GalleryController extends Controller
{
    public function index(Request $request){
        $dataView = [];
        $list_cat = null;
        $gallerys = null;

        $list_cat = new GalleryCat();
        $list_cat = $list_cat->GetOptions($request->cat);
        $condition = [];
        if ($request->cat && $request->cat!=0) $condition[] = ['cat', $request->cat];
        if ($request->keyword) $condition[] = ['name', 'like', '%'.$request->keyword.'%'];
        if ($request->from_date) $condition[] = ['updated_at','>=',$request->from_date];
        if ($request->to_date) $condition[] = ['updated_at','<=',$request->to_date];
        if ($request->user) $condition[] = ['updated_by', $request->user];
        $condition[] = ['language', session('lang')];

        $gallerys = Gallery::where($condition)
                                ->orderBy('order','desc')
                                ->paginate(10);

        $dataView['gallery'] = $gallerys;

        if ($request->ajax()) {
            return Response::json(view('admin/gallery/list_gallery', $dataView)->render());
        }

        $users = User::GetUserOptions($request->user);

        $dataView['list_cat'] = $list_cat;
        $dataView['list_user'] = $users;
        $dataView['from_date'] = $request->from_date;
        $dataView['to_date'] = $request->to_date;
        return view('admin/gallery/index', $dataView);
    }

    public function detail(Request $request){
        $slug_exists = 0;
        $category = Gallery::find($request->id);
        if(!$category){
            $category = new Gallery;
        } 
        $image_gallery = $category->gallery_image()->orderBy('order','desc')->get();
        $gallerycat = GalleryCat::orderBy('id','desc')->get();
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
                $folder = public_path('media/gallery/');
                $image = UploadFile::uploadImage($_FILES['image'], $folder, $category->image);
            } else {
                $image = $category->image;
            }
            $category->name = $request->name;
            $category->link_to = $request->link_to;
            $category->cat = $request->cat;
            $category->image = $image?$image:'';
            $category->caption = $request->caption?$request->caption:'';
            $category->page_title = $request->page_title?$request->page_title:'';
            $category->meta_des = $request->meta_des?$request->meta_des:'';
            $category->meta_keyword = $request->meta_keyword?$request->meta_keyword:'';
            $category->meta_page_topic = $request->meta_page_topic?$request->meta_page_topic:'';
            $category->highlight = isset($request->highlight)?1:0;
            $category->new = isset($request->new)?1:0;
            $category->public = isset($request->public)?1:0;
            
            $category->language = session('lang')!=null?session('lang'):(env('DEFAULT_LANGUAGE'));
            $maxorder = Gallery::whereRaw('`order` = (select max(`order`) from gallery)')->first();
            $category->order = $category->order?$category->order:($maxorder ? ($maxorder->order + 1) : 1);
            $category->updated_by = Auth::id();

            if ($request->slug) {
                $slug = $request->slug;
                if (Gallery::where([['slug',$slug],['id','<>',$category->id]])->first()) {
                    $category->slug = $slug;
                    $slug_exists = 1;
                    $dataView['saved'] = $saved;
                    $dataView['category'] = $category;
                    $dataView['slug_exists'] = $slug_exists;
                    $dataView['image_gallery'] = $image_gallery;
                    $dataView['gallerycat'] = $gallerycat;
                    return view('admin/gallery/detail_gallery', $dataView);
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
        $dataView['category'] = $category;
        $dataView['slug_exists'] = $slug_exists;
        $dataView['image_gallery'] = $image_gallery;
        $dataView['gallerycat'] = $gallerycat;
    	return view('admin/gallery/detail_gallery', $dataView);
    }

    public function detailimage(Request $request){
        $category = Gallery::find($request->catid);
        
        $galleryimage = GalleryImage::find($request->id);
        if(!$galleryimage){
            $galleryimage = new GalleryImage();
        }
        $dataView = [];
        $dataView['saved'] = 0;
        $image = '';

        if ($request->isMethod('post')) {
            if($request->file('image') && $request->file('image')->isValid()){
                $folder = 'media/gallery_image/' . $category['id'] . '/';
    
                $thumb_folder = $folder . '/tb/';
                $image = UploadFile::uploadImage($_FILES['image'], $folder, $galleryimage->image);
            } else {
                $image = $galleryimage->image;
            }
            $galleryimage->link_img = $request->link_img;
            $galleryimage->gallery_id = $request->catid;
            $galleryimage->image = $image?$image:'';
            $galleryimage->caption = $request->caption?$request->caption:'';
            $galleryimage->public = 1;
            
            $galleryimage->language = session('lang')!=null?session('lang'):(env('DEFAULT_LANGUAGE'));
            $maxorder = GalleryImage::whereRaw('`order` = (select max(`order`) from gallery_image)')->first();
            $galleryimage->order = $maxorder ? ($maxorder->order + 1) : 1;
            $galleryimage->updated_by = Auth::id();
            $galleryimage->save();
            $dataView['saved'] = 1;
        }
        $dataView['galleryimage'] = $galleryimage;
        $dataView['category'] = $category;
    	return view('admin/gallery/detail_image', $dataView);
    }
    public function detailupload(Request $request){
        $gallery = Gallery::find($request->id);
        
        $dataView['gallery'] = $gallery;
        $dataView['galleryImages'] = GalleryImage::where('gallery_id', $request->id)->orderBy('order', 'desc')->get();
    	return view('admin/gallery/detail_upload_image', $dataView);
    }
    public function sort(Request $request){
        $items = $request->sort;
		$order = array();
		foreach ($items as $c) {
			$id = str_replace('item_', '', $c);
			$order[] = Gallery::find($id)->order;
		}
		rsort($order);
		foreach ($order as $k => $v) {
            Gallery::where('id', str_replace('item_', '', $items[$k]))->update(['order' => $v]);
		}
    }
	public function sortitem(Request $request){
        $items = $request->sort;
		$order = array();
		foreach ($items as $c) {
			$id = str_replace('item_', '', $c);
			$order[] = GalleryImage::find($id)->order;
		}
		rsort($order);
		foreach ($order as $k => $v) {
            GalleryImage::where('id', str_replace('item_', '', $items[$k]))->update(['order' => $v]);
		}
    }

    public function delete(Gallery $gallery, Request $request){
        $gallery->delete();
        if ($request->ajax()) {
            return 0;
        }
    }
	public function deleteitem(GalleryImage $galleryitem, Request $request){
        $galleryitem->delete();
        if ($request->ajax()) {
            return 0;
        }
    }
    
    public function movetop(Gallery $gallery,$gallerycat = null, Request $request){
        $condition = [];
        $condition[] = ['order', '>', $gallery->order];
        $condition[] = ['language', session('lang')];
        if ($gallerycat) {
            $id_string = $gallerycat;
            GalleryCat::getIdString($gallerycat, $id_string);
            $othergallerys = Gallery::where($condition)->whereIn('cat', explode(',', $id_string))->orderBy('order', 'asc')->get();
        } else {
            $othergallerys = Gallery::where($condition)->orderBy('order', 'asc')->get();
        }
        foreach ($othergallerys as $othergallery){
            $oldorder = $gallery->order;
            $gallery->order = $othergallery->order;
            $othergallery->order = $oldorder;
            $gallery->save();
            Gallery::where('id', $othergallery->id)->update(['order' => $oldorder]);
        }
        if ($request->ajax()) {
            return 0;
        }
    }

    /**
     * Change an attribute of [public, highlight, new] to true or false
     * 
     * @param \Request
     */
    public function changefield(Request $request) {
        $field = $request->field;
        $gallery = Gallery::find($request->id);
        $gallery->$field = $request->p?'0':'1';
        $gallery->save();
        die($request->p);
    }
	public function changefielditem(Request $request) {
        $field = $request->field;
        $gallery = GalleryImage::find($request->id);
        $gallery->$field = $request->p?'0':'1';
        $gallery->save();
        die($request->p);
    }

    public function detailuploadImage(Request $request) {
        if ($request->ajax() && $request->has('gid')) {
            $gid = 1*$request->gid;
            if( $gid == 0 ) {
                $gid = 1*Gallery::max('id') + 1;
            }
            $folder = 'media/gallery_image/' . $gid . '/';
            $upload_url = url('media/gallery_image/' .  $gid ) . '/';

            $thumb_folder = $folder . '/tb/';
            $thumb_upload_url = $upload_url . '/tb/';
            $option = array(
                'script_url' => url('/admin/gallery/deleteimg/'),
                'upload_dir' => $folder,
                'upload_url' => $upload_url,
                'image_versions' => array(
                    'thumbnail' => array(
                        'upload_dir' => $thumb_folder,
                        'upload_url' => $thumb_upload_url,
                        'crop' => false,
                        'max_width' => 300,
                        'max_height' => 3000
                    ),
                ),
            );
            $upload_handler = new UploadHandler($option);
            $galleryimage = new GalleryImage;
            $galleryimage->gallery_id = (int)$gid;
            $galleryimage->updated_by =  Auth::id();
            $galleryimage->public =  1;
            $galleryimage->image = $upload_handler->imageName;
            $galleryimage->order = 1*GalleryImage::max('order') + 1;
            $galleryimage->language = session('lang')?session('lang'):(env('DEFAULT_LANGUAGE'));
            $galleryimage->save();
        }
    }
}
