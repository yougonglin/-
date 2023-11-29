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
use app\app\model\user\UserGradeModel;
use app\app\model\user\UserModel;
use app\app\model\user\YueLog;
use think\facade\Db;

use \supernova\Shuchu;
class VipController
{
    /**
     * @description: 等级列表
     * @param {UserGradeModel} $UserGradeModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function grade_list(UserGradeModel $UserGradeModel,Shuchu $Shuchu)
    {
        $result = $UserGradeModel->select();
        return $Shuchu->json($result);
    }

    /**
     * @description: 升级VIP
     * @param {UserModel} $UserModel
     * @param {Shuchu} $Shuchu
     * @param {YueLog} $YueLog
     * @return {*}
     */    
    public function upgrade(UserModel $UserModel,Shuchu $Shuchu,YueLog $YueLog)
    {
        $vipArr = [['price' => 299.99,'duration' => 2678400],['price' => 1299,'duration' => 16070400],['price' => 1999,'duration' => 32140800]];
        $type = input('post.type');
        //获取原本的会员时间，判定是续费还是开通
        $vipExpires = $UserModel->where('uid',request()->userInfo->uid)->value('vip_expires');
        $nowTime = time();
        //如果比现在时间小就取现在时间加开通时长，否则就取已开通时长加以后时长
        $uptime = $vipExpires < $nowTime ? $nowTime + $vipArr[$type]['duration'] : $vipExpires + $vipArr[$type]['duration'];
        Db::startTrans();
        try {
            $UserModel->where('uid',request()->userInfo->uid)->update([
                'yue_num' => Db::raw('yue_num-' . $vipArr[$type]['price']),
                'vip_expires' =>  $uptime
            ]);
            $YueLog->save([
                'uid' => request()->userInfo->uid,
                'num' => $vipArr[$type]['price'],
                'type' => 2,
                'mark' => '升级VIP'
            ]);
            $result = ['升级VIP成功',$uptime];
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            $result = ['抱歉,您的余额不足',0];
            // 回滚事务
            Db::rollback();
        }
        return $Shuchu->json($result);
    }


    /**
     * @description: 提升用户等级
     * @param {UserModel} $UserModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function upgradation(UserModel $UserModel,Shuchu $Shuchu)
    {
        $nums = intval(input('post.nums'));
        $result = $UserModel->where('uid',request()->userInfo->uid)->update([
            'experience' => Db::raw('experience+' . $nums),
            'yinbi_num' => Db::raw('yinbi_num-' . $nums)
        ]);
        return $Shuchu->json($result);
    }
}
