<?php

namespace App\Http\Controllers\Admin;

use App\Libraries\UploadHandler;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\UploadFile;
use App\Libraries\SeoFriendly;
use App\Models\Productcat;
use App\Models\Product;
use App\Models\User;
use Response;
use Auth;

class ProductController extends Controller
{
    public function index(Request $request){
        $dataView = [];
        $list_cat = null;
        $products = null;

        $list_cat = new Productcat();
        $list_cat = $list_cat->GetOptions($request->cat);
        $condition = [];
        if ($request->cat && $request->cat!=0) $condition[] = ['cat', $request->cat];
        if ($request->keyword) $condition[] = ['name', 'like', '%'.$request->keyword.'%'];
        if ($request->from_date) $condition[] = ['updated_at','>=',$request->from_date];
        if ($request->to_date) $condition[] = ['updated_at','<=',$request->to_date];
        if ($request->user) $condition[] = ['updated_by', $request->user];
        $condition[] = ['language', session('lang')];

        $products = Product::where($condition)
                                ->orderBy('order','desc')
                                ->paginate(10);

        $dataView['product'] = $products;

        if ($request->ajax()) {
            return Response::json(view('admin/product/list_product', $dataView)->render());
        }

        $users = User::GetUserOptions($request->user);

        $dataView['list_cat'] = $list_cat;
        $dataView['list_user'] = $users;
        $dataView['from_date'] = $request->from_date;
        $dataView['to_date'] = $request->to_date;
        return view('admin/product/index', $dataView);
    }

    public function detail(Request $request){
        $slug_exists = 0;
        $product = Product::find($request->id);
        if (!$product) $product = new Product;
        $image = '';
        $dataView = [];
        $dataView['saved'] = 0;
        $dataView['copy'] = $request->act=='copy'?1:0;
        if ($request->act == 'copy'){
            $product->id = null;
            $product->public = 0;
            $product->highlight = 0;
            $product->new = 0;
            }
        if ($request->isMethod('post')) {
            if($request->file('image') && $request->file('image')->isValid()){
                $folder = public_path('media/product/');
                $image = UploadFile::uploadImage($_FILES['image'], $folder, $product->image);
            } else {
                if ($request->act == 'copy'){
                    if ($product->image){
                        $folder = public_path('media/product/');
                        $ext = UploadFile::getExtension($product->image);
                        list($usec, $sec) = explode(".", microtime(true));
                        $image = $usec . $sec . '.' . $extension;
                        if (file_exists($folder.$product->image)) copy ($folder.$product->image, $folder.$image);
                        if (file_exists($folder.'tb/'.$product->image)) copy ($folder.'tb/'.$product->image, $folder.'tb/'.$image);
                    } else {
                        $image = '';
                    }
                } else {
                    $image = $product->image;
                }
            }
            $product->name = $request->name;
            $product->price = (float)$request->price;
            $product->cat = (int)$request->cat;
            $product->image = $image?$image:'';
            $product->product_code = $request->product_code;
            $product->unit = $request->unit;
            $product->des = $request->des?$request->des:'';
            $product->detail = $request->detail?$request->detail:'';
            $product->page_title = $request->page_title?$request->page_title:'';
            $product->meta_des = $request->meta_des?$request->meta_des:'';
            $product->meta_keyword = $request->meta_keyword?$request->meta_keyword:'';
            $product->meta_page_topic = $request->meta_page_topic?$request->meta_page_topic:'';
            $product->public = isset($request->public)?1:0;
            $product->highlight = isset($request->highlight)?1:0;
            $product->new = isset($request->new)?1:0;
            $product->language = (session('lang'))?(session('lang')):(env('DEFAULT_LANGUAGE'));
            $maxorder = Product::whereRaw('`order` = (select max(`order`) from product)')->first();
            $product->order = $product->order?$product->order:($maxorder ? ($maxorder->order + 1) : 1);
            $product->updated_by = Auth::id();
            $product->save();

            if ($request->slug) {
                $slug = $request->slug;
                if (Product::where([['slug',$slug],['id','<>',$product->id]])->first()) {
                    $product->slug = $slug;
                    $slug_exists = 1;
                    $dataView['slug_exists'] = $slug_exists;
                    $dataView['product'] = $product;
                    $productcat = new Productcat();
                    $dataView['category_options'] = $productcat->GetOptions($product->cat);
                    $dataView['productImages'] = Productimage::where('product_id', $request->id)->orderBy('order', 'desc')->get();
                    return view('admin/product/detail', $dataView);
                }
            }
            else {
                $product->save();
                $slug = SeoFriendly::slugify($request->name."-".$product->id);
            }
            $product->slug = $slug;
            $product->save();
            $dataView['saved'] = 1;
        }
        $dataView['slug_exists'] = $slug_exists;
        $dataView['product'] = $product;
        $productcat = new Productcat();
        $dataView['category_options'] = $productcat->GetOptions($product->cat);
        $dataView['productImages'] = Productimage::where('product_id', $request->id)->orderBy('order', 'desc')->get();
    	return view('admin/product/detail', $dataView);
    }
    
    public function deleteimage(Request $request){
        $id = $request->id;
        $record = Product::find($id);
        $folder = $_SERVER['DOCUMENT_ROOT'] . '/media/product/';
        if (file_exists($folder . $record->image))	unlink($folder . $record->image);
        if (file_exists($folder . 'tb/' . $record->image))	unlink($folder . 'tb/' . $record->image);
        $record->image = '';
        $record->save();
    }
    
    public function deleteproductimage(Request $request){
        $id = $request->id;
        $record = Productimage::find($id);
        $folder = $_SERVER['DOCUMENT_ROOT'] . '/media/product/' . $record->product_id;
        if (file_exists($folder . $record->image))	unlink($folder . $record->image);
        if (file_exists($folder . 'tb/' . $record->image))	unlink($folder . 'tb/' . $record->image);
        $record->image = '';
        $record->delete();
    }

    public function sort(Request $request){
        $items = $request->sort;
		$order = array();
		foreach ($items as $c) {
			$id = str_replace('item_', '', $c);
			$order[] = Product::find($id)->order;
		}
		rsort($order);
		foreach ($order as $k => $v) {
            Product::where('id', str_replace('item_', '', $items[$k]))->update(['order' => $v]);
		}
    }

    public function delete(Product $product, Request $request){
        $product->delete();
        if ($request->ajax()) {
            return 0;
        }
    }
    
    public function movetop(Product $product,$productcat = null, Request $request){
        $condition = [];
        $condition[] = ['order', '>', $product->order];
        $condition[] = ['language', session('lang')];
        if ($productcat) {
            $id_string = $productcat;
            Productcat::getIdString($productcat, $id_string);
            $otherProducts = Product::where($condition)->whereIn('cat', explode(',', $id_string))->orderBy('order', 'asc')->get();
        } else {
            $otherProducts = Product::where($condition)->orderBy('order', 'asc')->get();
        }
        foreach ($otherProducts as $otherProduct){
            $oldorder = $product->order;
            $product->order = $otherProduct->order;
            $otherProduct->order = $oldorder;
            $product->save();
            Product::where('id', $otherProduct->id)->update(['order' => $oldorder]);
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
        $product = Product::find($request->id);
        $product->$field = $request->p?'0':'1';
        $product->save();
        die($request->p);
    }

    public function uploadImage(Request $request) {
        if ($request->ajax() && $request->has('pid')) {
            $pid = 1*$request->pid;
            if( $pid == 0 ) {
                $pid = 1*Product::max('id') + 1;
            }
            $folder = config('constants.PRODUCT_IMAGE_FOLDER') . $pid . '/';
            $upload_url = url(config('constants.PRODUCT_IMAGE_FOLDER') .  $pid ) . '/';

            $thumb_folder = $folder . '/tb/';
            $thumb_upload_url = $upload_url . '/tb/';
            $option = array(
                'script_url' => url('/admin/product/deleteimg/'),
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
            $productimage = new Productimage;
            $productimage->product_id = (int)$pid;
            $productimage->updated_by =  Auth::id();
            $productimage->image = $upload_handler->imageName;
            $productimage->order = 1*Productimage::max('order') + 1;
            $productimage->language = session('lang')?session('lang'):(env('DEFAULT_LANGUAGE'));
            $productimage->save();
        }
    }
}
