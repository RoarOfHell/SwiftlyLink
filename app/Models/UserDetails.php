<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserDetails extends Model
{
    use HasFactory;

    protected $table = 'user_details';

    protected $fillable = ['id', 'user_id', 'avatar_path', 'tag', 'nickname', 'first_name', 'last_name', 'birthday', 'created_at', 'updated_at'];

    protected $hidden = [];

    

    protected function createOrUpdate($params){
        $user = User::get();

        $user_details = UserDetails::where('user_id', '=', $user->id)->first();

        if($user_details === null){
            $new_user_details = [
                'user_id' => $params['user_id'] ?? $user->id,
                'tag' => $params['tag'] ?? $params['nickname'] ?? Str::before($user->email, '@'),
                'avatar_path' => $params['avatar_path'] ?? null,
                'nickname' => $params['nickname'] ?? Str::before($user->email, '@'),
                'first_name' => $params['first_name'] ?? null,
                'last_name' => $params['last_name'] ?? null,
                'birthday' => $params['birthday'] ?? null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

           
            UserDetails::create($new_user_details);
            return;
        }

        if (isset($params['nickname'])) {
            $user_details->nickname = $params['nickname'];
        }

        if (isset($params['tag'])) {
            
            $newTag = Str::replace('@', '', $params['tag']);
            $user_details->tag = $newTag;
        }

        if (isset($params['avatar_path'])) {
            $user_details->avatar_path = $params['avatar_path'];
        }
    
        if (isset($params['first_name'])) {
            $user_details->first_name = $params['first_name'];
        }
    
        if (isset($params['last_name'])) {
            $user_details->last_name = $params['last_name'];
        }

        if (isset($params['birthday'])) {
            $user_details->birthday = $params['birthday'];
        }
        $user_details->updated_at = Carbon::now();
        $user_details->save();
    }
}
