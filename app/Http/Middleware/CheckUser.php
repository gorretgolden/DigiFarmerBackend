<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $Authorization = $request->header('Authorization');
        if(empty($Authorization)){
            return response(
            ['code'=>401,'message'=>"Authentication failed"],
            401
        );
        }

        $access_token = trim(ltrim($Authorization, 'Bearer'));
        $res_user = DB::table('google_users')->where('access_token', $access_token)->select('id','avatar','name','token','access_token','type','expiry_date')->first();

        if(empty($res_user)){
            return response(['code'=>401,'message'=>'User does not exist'], 401);
        }
        $expire_date = $res_user->expiry_date;
        if(empty($expire_date)){
            return response(['code'=>401,'message'=>'You must Login'], 401);
        }
        if($expire_date < Carbon::now()){
            return response(['code'=>401,'message'=>'Your token has expired'], 401);
        }
        $addTime = Carbon::now()->addDays(5);
        if($expire_date < $addTime){
            $add_expire_date = Carbon::now()->addDays(30);
            DB::table('google_users')->where('access_token',$access_token)
            ->update(['expiry_date'=>$add_expire_date]);
        }
        $request->user_id = $res_user->id;
        $request->user_type = $res_user->type;
        $request->user_name = $res_user->name;
        $request->user_avatar = $res_user->avatar;
        $request->user_token = $res_user->token;

    return $next($request);
    }
}
