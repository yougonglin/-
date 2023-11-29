<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: Your Name you@example.com
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\admin\middleware;

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
        $token = $request->header('admin-supernova-token');
        $key = env('init.admin_password', '123456');
        if($token == $key){
            return $next($request);
        }else{
            return json('用户登录信息过期,请重新登录');
        }
    }
}
