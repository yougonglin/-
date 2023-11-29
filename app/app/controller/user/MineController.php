<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\app\controller\user;
use app\app\model\user\UserModel;
use \supernova\Shuchu;
use think\facade\Cache;

class MineController
{
    /**
     * @description: 获取用户资料
     * @param {UserModel} $model
     * @return {*}
     */    
    public function userInfo(UserModel $model,Shuchu $Shuchu)
    {
        $result = $model->where('uid',request()->userInfo->uid)->find();
        return $Shuchu->json($result);
    }

    /**
     * @description: 注销账号
     * @param {UserModel} $model
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function logout(UserModel $model,Shuchu $Shuchu)
    {
        $result = $model->where('uid',request()->userInfo->uid)->delete();
        return $Shuchu->json($result);
    }

    /**
     * @description: 退出登录
     * @return {*}
     */    
    public function user_exit(UserModel $model,Shuchu $Shuchu)
    {
        $phone = $model->where('uid',request()->userInfo->uid)->value('phone');
        $redis = Cache::store('redis_permanent')->handler();
        $result = $redis->hdel("login_token",$phone);
        return $Shuchu->json($result);
    }
}
