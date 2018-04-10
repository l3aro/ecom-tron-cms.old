<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Hash;
use App\Http\Controllers\Controller;
use App\Libraries\UploadFile;
use App\Models\User;
use App\Models\Role;
use Auth;

class UserController extends Controller
{
    public function index(Request $request){
        $user = User::orderBy('id','desc')->get();
        $mode = User::withRole(['admin','publisher','editor','moderator']);
        $dataView = [];
        if ($request->isMethod('post')){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->mobile = $request->mobile;
            $user->skype = $request->skype;
            $user->birthday = $request->birthday;
            $user->position = $request->position;
            $user->password = $request->password;
        }
        $dataView['user'] = $user;
        $dataView['mode'] = $mode;
        return view('admin/user/index',$dataView);
    }
    public function info(Request $request){
        $role = Role::orderBy('name','desc')->get();
        $infouser = User::find($request->id);
        if(!$infouser){
            $infouser = new User();
        }
        $dataView = [];
        $dataView['saved'] = 0;
        
        $image = '';
        if ($request->isMethod('post')) {
            if($request->file('image') && $request->file('image')->isValid()){
                $folder = public_path('media/user/');
                $image = UploadFile::uploadImage($_FILES['image'], $folder, $infouser->image);
            } else {
                $image = $infouser->image;
            }
            $infouser->name = $request->name;
            $infouser->email = $request->email;
            $infouser->address = $request->address;
            $infouser->mobile = $request->mobile;
            $infouser->skype = $request->skype;
            $infouser->image = $image?$image:'';
            $infouser->birthday = $request->birthday;
            $infouser->position = $request->position;
            $infouser->user_role = $request->user_role;
            $infouser->password = bcrypt($request->password);
            
            $infouser->save();
            $role_user = Role::where('name', $request->user_role)->first();
            $infouser->attachRole($role_user);

            $dataView['saved'] = 1;
        }
        
        $dataView['role'] = $role;
        $dataView['infouser'] = $infouser;
        return view('admin/user/info',$dataView);
    }
    public function deleteuserimage(Request $request){
        $id = $request->id;
        $record = Language::find($id);
		$folder = $_SERVER['DOCUMENT_ROOT'] . '/media/user/';
		if (file_exists($folder . $record->image))	unlink($folder . $record->image);
		if (file_exists($folder . 'tb/' . $record->image))	unlink($folder . 'tb/' . $record->image);
		$record->image = '';
		$record->save();
    }
    public function profile(Request $request){
        $profile = User::find($request->id);
        if(!$profile){
            $profile = new User();
        }
        $dataView = [];
        $dataView['saved'] = 0;
        $image = '';
        if ($request->isMethod('post')) {
            if($request->file('image') && $request->file('image')->isValid()){
                $folder = public_path('media/user/');
                $image = UploadFile::uploadImage($_FILES['image'], $folder, $profile->image);
            } else {
                $image = $profile->image;
            }
            $profile->name = $request->name;
            $profile->email = $request->email;
            $profile->address = $request->address;
            $profile->mobile = $request->mobile;
            $profile->skype = $request->skype;
            $profile->image = $image?$image:'';
            $profile->birthday = $request->birthday;
            $profile->position = $request->position;
            
            $profile->save();
            $dataView['saved'] = 1;
        }
        $dataView['profile'] = $profile;
        return view('admin/user/profile',$dataView);
    }
    public function changepass(Request $request){
        $user = Auth::user();

        $dataView = [];
        $dataView['passwordMessage'] = 0;
        $dataView['message'] = 0;

        if ($request->isMethod('post')){
           // kiem tra password cu
            if (!Hash::check($request->get('password'), $user->password)) {
                $dataView['passwordMessage'] = 'Mật khẩu cũ không chính xác';
                return view('admin/user/changepass',$dataView);
            }
            // kiem tra password moi va confirm
            if(empty($request->get('newpassword'))
                || empty($request->get('confirmpassword'))
                || $request->get('newpassword') != $request->get('confirmpassword')
                ){
                    $dataView['passwordMessage'] = 'Mật khẩu nhập lại không chính xác';
                    return view('admin/user/changepass',$dataView);
                }
            //kiem tra password moi khong duoc giong password cu
            if (Hash::check($request->get('newpassword'), $user->password)){
                $dataView['passwordMessage'] = 'Mật khẩu mới không được giống mật khẩu cũ';
                return view('admin/user/changepass',$dataView);
            }
            // Luu password moi

            if ($dataView['passwordMessage'] == 0) {
                $user->password = bcrypt($request->get('newpassword'));
                $user->save();
                $dataView['message'] = 'Đổi mật khẩu thành công';
            }
            
        }
        
       
        return view('admin/user/changepass',$dataView);
    }
    public function delete_user(User $id){
        $id->delete();
        return redirect('admin/user');
    }
}
