<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\admin\controller\star;
use app\app\model\star\UserinfoModel;
use \supernova\Shuchu;
use think\facade\Request;

class SocializeController
{
    /**
     * @description: 资料审核
     * @param {UserinfoModel} $UserinfoModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function profile_pass(UserinfoModel $UserinfoModel,Shuchu $Shuchu)
    {
        $result = $UserinfoModel->where('uid',Request::post('uid'))->update(['is_pass' => Request::post('pass_type')]);
        //审核不通过进行通知
        return $Shuchu->json($result);
    }

    /**
     * @description: 获取需要审核的用户
     * @param {UserinfoModel} $UserinfoModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function profile_pass_get(UserinfoModel $UserinfoModel,Shuchu $Shuchu)
    {
        $result = $UserinfoModel->field('uid,violation_record')->where('is_pass',0)->order('id','desc')->limit(50)->select();
        return $Shuchu->json($result);
    }
}
