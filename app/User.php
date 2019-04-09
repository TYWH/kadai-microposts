<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    //一対多、多対多の関係を示すメソッド
    
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
    public function followings()
    {
        return $this->belongsToMany(User::class,'user_follow','user_id','follow_id')->withTimestamps();
    }
    
    public function followers()
    {
        return $this->belongsToMany(User::class,'user_follow','follow_id','user_id')->withTimestamps();
    }
    
    public function favorites()
    {
        return $this->belongsToMany(Micropost::class,'favorites','user_id','microposts_id')->withTimestamps();
    }
    
    //フォロー、アンフォローを実行するメソッド
    
    public function follow($userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id == $userId;
        
        if ($exist || $its_me){
            return false;
        } else {
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id == $userId;
        
        if ($exist || $its_me) {
            $this->followings()->detach($userId);
            return true;
        } else {
            return false;
        }
    }
    
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id',$userId)->exists();
    }
    
    //ふぁぼ、ふぁぼ解除のメソッド
    
    public function favorite($micropostId)
    {
        //重複ふぁぼを避ける。true,falseは見た目上の分かりやすさと、今後の拡張の為に付けてある。
        $exist = $this->is_favorite($micropostId);
        
        if ($exist) {
            return false;
        } else {
            $this->favorites()->attach($micropostId);
            return true;
        };
    }
    
    public function unfavorite($micropostId)
    {
        //重複ふぁぼを避ける。true,falseは見た目上の分かりやすさと、今後の拡張の為に付けてある
        $exist = $this->is_favorite($micropostId);
        
        if ($exist) {
            $this->favorites()->detach($micropostId);
            return true;
        } else {
            return false;
        };
        
    }
    
    public function is_favorite($micropostId)
    {
        return $this->favorites()->where('microposts_id',$micropostId)->exists();
    }
    
    //タイムライン表示のメソッド
    
    public function feed_microposts()
    {
        $follow_user_ids = $this->followings()->pluck('users.id')->toArray();
        // pluckは、指定した引数のテーブルのカラム名だけを抜き出す命令。followしているuser_idを抜き出し、toArrayで配列に格納している
        $follow_user_ids[] = $this->id;
        // 自分のIDも追加
        return Micropost::whereIn('user_id',$follow_user_ids);
    }
    
}
