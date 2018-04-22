<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        //获取除去用户id为1的所有的用户的id
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        //关注除了1号用户以外的所有用户
        $user->follow($user_id);

        //除去1号id的用户，其他的所有用户都来关注1号id的用户
        foreach ($followers as $follower){
            $follower->follow($user_id);
        }
    }
}
