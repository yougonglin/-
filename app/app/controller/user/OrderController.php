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
use app\app\model\shop\GoodsOrderModel;
use \supernova\Shuchu;
use app\app\model\user\YueLog;
use app\app\model\user\YinbiLogModel;
use app\app\model\user\JinbiLogModel;

class OrderController
{
    /**
     * @description: 商城订单列表
     * @param {GoodsOrderModel} $GoodsOrderModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function order_list(GoodsOrderModel $GoodsOrderModel,Shuchu $Shuchu)
    {
        $result = $GoodsOrderModel->where('uid',request()->userInfo->uid)->where('status',input('post.status'))->page((integer) input('post.page'),30)->order('id','desc')->select();
        return $Shuchu->json($result);
    }

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
                $result = $JinbiLogModel->where('uid',request()->userInfo->uid)->where('type',input('post.type'))->page((int) input('post.page'),15)->order('id','desc')->select();
                break;
            case 1:
                $result = $YinbiLogModel->where('uid',request()->userInfo->uid)->where('type',input('post.type'))->page((int) input('post.page'),15)->order('id','desc')->select();
                break;
            case 2:
                $result = $YueLog->where('uid',request()->userInfo->uid)->where('type',input('post.type'))->page((int) input('post.page'),15)->order('id','desc')->select();
                break;
            default:
                # code...
                break;
        }
        return $Shuchu->json($result);
    }
}
