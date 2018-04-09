<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Support\Collection;
use Illuminate\Auth\Passwords\CanResetPassword;

use App\Notifications\AdminResetPasswordNotification;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract,
                                    CanResetPasswordContract
{
    use Notifiable;
    use Authenticatable, CanResetPassword;
    use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'email', 'name', 'address', 'mobile', 'skype', 'image', 'birthday', 'position'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    /**
     * Fetch user with specific role
     * 
     * @param array $role_name
     * @return \Collection list user with specific roles
     */
    protected function withRole($role_name) {
        $list_role = Role::orderBy('name','asc');
        foreach($role_name as $key=>$value) {
            $list_role = $list_role->orWhere('name', $value);
        }
        $list_role = $list_role->get();
        $list_user_by_role = [];
        foreach($list_role as $key=>$value) {
            $list_user_by_role[] = $value->user()->get();
        }
        $list_user = new Collection();
        foreach($list_user_by_role as $key=>$user_role) {
            foreach($user_role as $key=>$user) {
                $list_user->push($user);
            }
        }
        
        return $list_user;
    }

    public static function GetUserOptions($userid){
        $options = '<option value=""></option>';
        $cats = self::orderBy('name', 'asc')->get();
		foreach ($cats as $r) {
			$options .= '<option value="' . $r->id . '" ' . ( ($userid==$r->id)?'selected="selected"':'' ) . '>' . $r->name . '</option>';
		}
		return $options;
    }
    
    /**
     * Send password reset notification
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
}
