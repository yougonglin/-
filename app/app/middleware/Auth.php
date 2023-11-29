<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\app\middleware;
use think\facade\Cache;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class Auth
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $loginToken = request()->header('supernova-token') ?? request()->get('supernova-token');
        if($loginToken){

            try {
                $decoded = JWT::decode($loginToken, new Key(config('common.jwt_key'), 'HS256'));
            } catch (\Throwable $th) {
                return json('用户登录信息过期,请重新登录');
            }

            //-----不验证token过期和重复使用
            $request->userInfo = $decoded->data;
            return $next($request);
            //-----后期安全性高的话考虑
            //判断用户token是否一致，不一致说明旧token过期
            $redis = Cache::store('redis_permanent')->handler();
            $token = $redis->hget('login_token',$decoded->data->phone);
            // halt($token);
            if($token == $loginToken){
                if(time() < $decoded->exp){
                    $request->userInfo = $decoded->data;
                    return $next($request);
                }
            }
        }
        return json('用户登录信息过期,请重新登录');
    }
}
