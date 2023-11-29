<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\admin\controller\user;
use \supernova\Shuchu;
use app\app\model\user\YueLog;
use app\app\model\user\YinbiLogModel;
use app\app\model\user\JinbiLogModel;
use app\app\model\user\UserModel;
use app\app\model\user\RechargeOrderModel;
use app\app\model\shop\RebateGoodsSuccessLogModel;

class InfoController
{
    /**
     * @description: 积分日志
     * @param {YueLog} $YueLog
     * @param {YinbiLogModel} $YinbiLogModel
     * @param {JinbiLogModel} $JinbiLogModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function integral_log(YueLog $YueLog,YinbiLogModel $YinbiLogModel,JinbiLogModel $JinbiLogModel,Shuchu $Shuchu)
    {
        $integralType = input('post.integralType'); 
        switch ($integralType) {
            case 0:
                $result = $JinbiLogModel->where('uid',input('post.uid'))->where('type',input('post.type'))->page((int) input('post.page'),15)->order('id','desc')->select();
                break;
            case 1:
                $result = $YinbiLogModel->where('uid',input('post.uid'))->where('type',input('post.type'))->page((int) input('post.page'),15)->order('id','desc')->select();
                break;
            case 2:
                $result = $YueLog->where('uid',input('post.uid'))->where('type',input('post.type'))->page((int) input('post.page'),15)->order('id','desc')->select();
                break;
            default:
                # code...
                break;
        }
        return $Shuchu->json($result);
    }

    /**
     * @description: 用户信息
     * @param {UserModel} $UserModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function userinfo(UserModel $UserModel,RechargeOrderModel $RechargeOrderModel,RebateGoodsSuccessLogModel $RebateGoodsSuccessLogModel,Shuchu $Shuchu)
    {
        //获取基础信息
        $result = $UserModel->where('phone',input('post.phone'))->find();
        //获取传单效果
        $leafletUids = $UserModel->where('leaflet_uid',$result['uid'])->whereTime('create_time','between',[date('Y-m-d',strtotime("-30 day")),date('Y-m-d')])->limit(100)->column('uid');
        //获取用户有效充值金额
        $result['leafletRecharge'] = $RechargeOrderModel->field('sum(price) as prices')->where('uid','in',$leafletUids)->where('status',1)->select();
        //获取100人中有效购买数量
        $result['leafletNums'] = $RebateGoodsSuccessLogModel->field('count(*) as nums')->where('uid','in',$leafletUids)->select();
        //获取网推下线效果
        $inviteUids = $UserModel->where('invite_uid',$result['uid'])->whereTime('create_time','between',[date('Y-m-d',strtotime("-30 day")),date('Y-m-d')])->limit(100)->column('uid');
        //获取用户有效充值金额
        $result['inviteRecharge'] = $RechargeOrderModel->field('sum(price) as prices')->where('uid','in',$inviteUids)->where('status',1)->select();
        //获取100人中有效购买数量
        $result['inviteNums'] = $RebateGoodsSuccessLogModel->field('count(*) as nums')->where('uid','in',$inviteUids)->select();
        return $Shuchu->json($result);
    }
}
