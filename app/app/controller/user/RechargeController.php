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
use \pay\Alipay;
use app\app\model\user\YueLog;
use app\app\model\user\UserModel;
use think\facade\Db;
use \supernova\Shuchu;
use app\app\model\user\RechargeOrderModel;
use \supernova\Appstore;
use think\facade\Cache;
use app\app\model\user\JinbiLogModel;
use \pay\Wxpay;
class RechargeController
{
    public function balance(Alipay $Alipay,Wxpay $Wxpay,RechargeOrderModel $RechargeOrderModel)
    {
        $orderId = md5('yue' . request()->userInfo->uid . '-' .time());
        $RechargeOrderModel->save(['order_id' => $orderId,'uid' => request()->userInfo->uid,'price' => input('get.price')]);
        if(input('get.type') == 'wx'){
            if(input('get.code')){
                $token = json_decode(wx_user_access_token(input('get.code')),true);
                $prepay_id = $Wxpay->create_order('用户:' . request()->userInfo->uid .  '&余额充值:' . input('get.price'),$orderId,input('get.price'),strtolower(input('get.platform')),$token['openid']);
                $paySign = $Wxpay->pay_sign('paySign',['package'   => 'prepay_id=' . $prepay_id['prepay_id']]);
                $paySign['signType'] = 'RSA';
                return view('jsapi',$paySign);
            }else{
                $prepay_id = $Wxpay->create_order('用户:' . request()->userInfo->uid .  '&余额充值:' . input('get.price'),$orderId,input('get.price'),strtolower(input('get.platform')));
                //H5直接返还链接
                if(isset($prepay_id['h5_url'])){
                    $result['h5_url'] = $prepay_id['h5_url'];
                }else{
                    $result = $Wxpay->pay_sign('sign',['prepayid' => $prepay_id['prepay_id']]);
                    $result['partnerid'] = '1632454841';
                    $result['package'] = 'Sign=WXPay';
                }
            }
        }else{
            $result = $Alipay->freeze('用户:' . request()->userInfo->uid .  '&余额充值:' . input('get.price'),$orderId,input('get.price'));    
        }
        //vivo自定义注册暂存oaid
        if(input('get.oaid')){
            $redis = Cache::store('redis')->handler();
            $redis->hset("zidingyifufei",$orderId,input('get.oaid'));
        }
        
        return json($result);
    }

    /**
     * @description: 支付宝回调
     * @param {Alipay} $Alipay
     * @param {YueLog} $YueLog
     * @param {UserModel} $UserModel
     * @param {RechargeOrderModel} $RechargeOrderModel
     * @return {*}
     */    
    public function notify_url(Alipay $Alipay,Wxpay $Wxpay,YueLog $YueLog,UserModel $UserModel,RechargeOrderModel $RechargeOrderModel,Appstore $Appstore)
    {
        $data = input('post.');
        //判定是支付宝还是微信
        if(isset($data['out_trade_no'])){
            $result = $Alipay->notify_url($data);
        }else if(isset($data['out_order_no'])){
            $Alipay->freeze_pay('余额充值：' . $data['amount'],$data['out_order_no'],$data['amount'],$data['auth_no']);
            $result = false;
        }else{
            $data =  $Wxpay->notify_url();
            $result = $data['trade_state'] == 'SUCCESS';
        }
        if($result){
            $orderInfo = $RechargeOrderModel->field('uid,status,price')->where('order_id',$data['out_trade_no'])->find();
            if($orderInfo['status'] == 0){
                $RechargeOrderModel->where('order_id',$data['out_trade_no'])->update(['status' => 1]);
                //增加余额
                $UserModel->where('uid',$orderInfo['uid'])->inc('yue_num',(float) $orderInfo['price'])->update();
                //余额记录
                $YueLog->save([
                    'uid' => $orderInfo['uid'],
                    'num' => (float) $orderInfo['price'],
                    'type' => 1,
                    'mark' => '余额充值:' . $data['out_trade_no']
                ]);
                //自定义付费
                $redis = Cache::store('redis')->handler();
                $oaid = $redis->hget("zidingyifufei",$data['out_trade_no']);
                $redis->hdel("zidingyifufei",$data['out_trade_no']);
                if($oaid){$Appstore->vivo_tuiguang($oaid,'PAY');}
            }
        }
        return 'success';
    }

    /**
     * @description: 佣金导入余额
     * @param {UserModel} $UserModel
     * @param {YueLog} $YueLog
     * @return {*}
     */    
    public function balance_jinbi(UserModel $UserModel,YueLog $YueLog,JinbiLogModel $JinbiLogModel,Shuchu $Shuchu)
    {
        $price = input('post.price');
        Db::startTrans();
        try {
            $UserModel->where('uid',request()->userInfo->uid)->update([
                'jinbi_num' => Db::raw('jinbi_num-' . $price),
                'yue_num' => Db::raw('yue_num+' . $price)
            ]);
            //余额记录
            $YueLog->save([
                'uid' => request()->userInfo->uid,
                'num' => $price,
                'type' => 1,
                'mark' => '金币导入余额'
            ]);
            //佣金记录
            $JinbiLogModel->save([
                'uid' => request()->userInfo->uid,
                'num' => $price,
                'type' => 2,
                'mark' => '金币导入余额'
            ]);
            $result = '佣金导入成功';
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            $result = '可导入佣金不足';
            // 回滚事务
            Db::rollback();
        }
        return $Shuchu->json($result);
    }

}
