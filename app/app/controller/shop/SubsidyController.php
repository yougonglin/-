<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: Your Name you@example.com
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\app\controller\shop;
use \supernova\Subsidy;
use \supernova\Shuchu;
use app\app\model\shop\RebateGoodsLogModel;
use app\app\model\shop\RebateGoodsSuccessLogModel;
use app\app\model\user\UserModel;
use app\app\model\user\JinbiLogModel;
use think\facade\Db;
include app()->getRootPath() .  "extend/douyin/DouyinSubsidy.php";
use app\app\model\user\YueLog;

class SubsidyController
{

    /**
     * @description: 获取code模式token
     * @param {Subsidy} $Subsidy
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function get_kuaishou_code_token(Subsidy $Subsidy,Shuchu $Shuchu)
    {
        $result = $Subsidy->get_kuaishou_code_token(input('get.code'));
        return $Shuchu->json($result);
    }

    /**
     * @description: 获取抖客token
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function get_douyin_code_token(Shuchu $Shuchu)
    {
        $DouyinSubsidy = new \DouyinSubsidy();
        $result = $DouyinSubsidy->get_douyin_code_token(input('get.code'));
        return $Shuchu->json($result);
    }

    /**
     * @description: 快手搜索
     * @param {Subsidy} $Subsidy
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function kuaishou_search(Subsidy $Subsidy,Shuchu $Shuchu)
    {
        $result = $Subsidy->kuaishou('open.distribution.cps.kwaimoney.selection.item.list',false,array(
            'pageIndex' => input('post.page'),
            'sortType' => 'VOLUME_DESC',
            'pageSize' => 20,
            'planType' => 1,
            'keyword' => input('post.keyword'),
            'rangeList' => array(
                array('rangeId' => 'PROMOTION_RATE','rangeFrom' => 30,'rangeTo' => 1000)
            )
        ));
        return json(json_decode($result,true));
    }

    /**
     * @description: 快赚客推广链接创建
     * @param {Subsidy} $Subsidy
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function kuaishou_build_link(Subsidy $Subsidy,Shuchu $Shuchu)
    {
        $result = json_decode($Subsidy->kuaishou('open.distribution.cps.kwaimoney.link.create',true,array(
            'linkType' => 101,
            'linkCarrierId' => input('post.id'),
            'comments' => request()->userInfo->uid,
            'cpsPid' => env('subsidy.cps_pid', '')
        )),true);
        return $Shuchu->json($result['data']['linkUrl']);
    }

    /**
     * @description: 抖音搜索
     * @param {douyinSubsidy} $douyinSubsidy
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function douyin_search()
    {
        $DouyinSubsidy = new \DouyinSubsidy();
        $result = $DouyinSubsidy->douyin_search(input('post.keyword'),input('post.page'),input('post.type'));
        return json($result);
    }

    /**
     * @description: 抖客推广链接创建
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function douyin_build_link()
    {
        $DouyinSubsidy = new \DouyinSubsidy();
        $result = $DouyinSubsidy->douyin_build_link(input('post.url'),request()->userInfo->uid,input('post.platform'));
        return json($result);
    }

    public function kuaishou_build_link_pass(Subsidy $Subsidy,Shuchu $Shuchu)
    {
        $result = json_decode($Subsidy->kuaishou('open.distribution.cps.kwaimoney.link.create',true,array(
            'linkType' => 101,
            'linkCarrierId' => input('post.id'),
            'comments' => 1,
            'cpsPid' => env('subsidy.cps_pid', '')
        )),true);
        return $Shuchu->json($result['data']['linkUrl']);
    }

    public function douyin_build_link_pass()
    {
        $DouyinSubsidy = new \DouyinSubsidy();
        $result = $DouyinSubsidy->douyin_build_link(input('post.url'),1,input('post.platform'));
        return json($result);
    }

    /**
     * @description: 快手自动写入订单
     * @param {Subsidy} $Subsidy
     * @param {RebateGoodsLogModel} $RebateGoodsLogModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function kuaishou_enter_order(Subsidy $Subsidy,RebateGoodsLogModel $RebateGoodsLogModel,RebateGoodsSuccessLogModel $RebateGoodsSuccessLogModel,Shuchu $Shuchu)
    {
        $cpsOrderStatus = input('get.status');
        if(input('get.key') == env('kuaishou_enter_order_key', '')){
            $endTime = time() * 1000;
            $tmp = [];$pcursor = '';
            do {
                //查询该时间段的订单
                $result = json_decode($Subsidy->kuaishou('open.distribution.cps.kwaimoney.order.list',false,array(
                    'cpsOrderStatus' => $cpsOrderStatus,
                    'pageSize' => 100,
                    'sortType' => 2,
                    'queryType' => 2,
                    'beginTime' => $endTime - 180000,
                    'endTime' => $endTime,
                    'pcursor' => $pcursor
                )),true);
                //录入用户订单
                if($cpsOrderStatus == 60){
                    foreach ($result['data']['orderList'] as $key => $value) {
                        array_push($tmp,array(
                            'uid' => $value['cpsKwaimoneyOrderProductView'][0]['comments'],
                            'order_id' => $value['cpsKwaimoneyOrderProductView'][0]['oid'],
                            'title' => $value['cpsKwaimoneyOrderProductView'][0]['itemTitle'],
                            'image' => $value['cpsKwaimoneyOrderProductView'][0]['itemPicUrl'],
                            'estimated_income' => $value['settlementAmount'],
                            'payment_fee' => $value['cpsKwaimoneyOrderProductView'][0]['paymentFee'],
                            'num' => $value['cpsKwaimoneyOrderProductView'][0]['num'],
                            'tech_service_amount' => $value['cpsKwaimoneyOrderProductView'][0]['techServiceAmount'],
                            'create_time' => intval($value['updateTime']/1000)
                        ));
                    }
                }else{
                    foreach ($result['data']['orderList'] as $key => $value) {
                        array_push($tmp,array(
                            'uid' => $value['cpsKwaimoneyOrderProductView'][0]['comments'],
                            'order_id' => $value['cpsKwaimoneyOrderProductView'][0]['oid'],
                            'title' => $value['cpsKwaimoneyOrderProductView'][0]['itemTitle'],
                            'image' => $value['cpsKwaimoneyOrderProductView'][0]['itemPicUrl'],
                            'estimated_income' => $value['cpsKwaimoneyOrderProductView'][0]['estimatedIncome'],
                            'payment_fee' => $value['cpsKwaimoneyOrderProductView'][0]['paymentFee'],
                            'num' => $value['cpsKwaimoneyOrderProductView'][0]['num'],
                            'tech_service_amount' => $value['cpsKwaimoneyOrderProductView'][0]['techServiceAmount'],
                            'create_time' => intval($value['updateTime']/1000)
                        ));
                    }
                }
                //设置分页游标
                $pcursor = $result['data']['pcursor'];
            } while ($result['data']['pcursor'] != 'nomore');
            //写入数据库
            if($cpsOrderStatus == 60){
                //成功结算的订单
                $RebateGoodsSuccessLogModel->extra('IGNORE')->insertAll($tmp);
            }elseif ($cpsOrderStatus == 30) {
                //普通付款订单
                $RebateGoodsLogModel->extra('IGNORE')->insertAll($tmp);
            }
            return $Shuchu->json('kuaishou_enter_order_ok');
        }else{
            return $Shuchu->json('kuaishou_enter_order_ok!');
        }
    }

    /**
     * @description: 获取返利订单
     * @param {RebateGoodsLogModel} $RebateGoodsLogModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function get_order(RebateGoodsLogModel $RebateGoodsLogModel,RebateGoodsSuccessLogModel $RebateGoodsSuccessLogModel,Shuchu $Shuchu)
    {
        $status = input('post.status');
        if($status){
            $result = $RebateGoodsSuccessLogModel->withoutField('status,uid')->where('uid',request()->userInfo->uid)->where('status',$status)->page((int) input('post.page'),15)->order('id','desc')->select();
        }else{
            $result = $RebateGoodsLogModel->withoutField('status,uid')->where('uid',request()->userInfo->uid)->page((int) input('post.page'),15)->order('id','desc')->select();
        }
        return $Shuchu->json($result);
    }

    /**
     * @description: 领取返利
     * @param {RebateGoodsSuccessLogModel} $RebateGoodsSuccessLogModel
     * @param {UserModel} $UserModel
     * @param {JinbiLogModel} $JinbiLogModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function receive_jinbi(RebateGoodsSuccessLogModel $RebateGoodsSuccessLogModel,UserModel $UserModel,JinbiLogModel $JinbiLogModel,YueLog $YueLog,Shuchu $Shuchu)
    {
        $result = $RebateGoodsSuccessLogModel->field('estimated_income,id')->where('uid',request()->userInfo->uid)->where('status',1)->select()->toArray();
        if(count($result)){
            //取出本次操作的所有ID，用于更新状态
            $ids = array_column($result,'id');
            //取出可领取金币总额
            $estimated_income = array_sum(array_column($result,'estimated_income')) / 100;
            Db::startTrans();
            try {
                //更新增加金币
                $UserModel->where('uid',request()->userInfo->uid)->inc('jinbi_num',$estimated_income)->update();
                //写入金币记录
                $JinbiLogModel->save([
                    'uid' => request()->userInfo->uid,
                    'num' => $estimated_income,
                    'type' => 1,
                    'mark' => '购物返利补贴'
                ]);
                //首次领取送30余额
                $isHas = $RebateGoodsSuccessLogModel->field('status')->where('status',2)->find();
                if(!$isHas){
                    //增加余额
                    $UserModel->where('uid',request()->userInfo->uid)->inc('yue_num',30)->update();
                    //余额记录
                    $YueLog->save([
                        'uid' => request()->userInfo->uid,
                        'num' => 30,
                        'type' => 1,
                        'mark' => '首次使用奖励30元'
                    ]);
                }
                //更新订单状态
                $RebateGoodsSuccessLogModel->where('id','in',$ids)->update(['status' => 2]);
                $result = '领取金币成功,请前往个人中心提现';
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                $result = '领取金币失败,请联系客服处理';
                // 回滚事务
                Db::rollback();
            }
        }else{
            $result = '没有金币可以领取,请耐心等待下，反正没啥损失。推荐一次性购买多件商品，到时可以一并领取。如果已经领取过,请前往个人中心提现';
        }
        return $Shuchu->json($result);
    }

    /**
     * @description: 手动录入订单
     * @param {Subsidy} $Subsidy
     * @param {RebateGoodsSuccessLogModel} $RebateGoodsSuccessLogModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function entry_order(Subsidy $Subsidy,RebateGoodsSuccessLogModel $RebateGoodsSuccessLogModel,Shuchu $Shuchu)
    {
        $result = json_decode($Subsidy->kuaishou('open.distribution.cps.kwaimoney.order.detail',false,array(
            'oid' => [input('post.oid')]
        )),true);
        if( isset($result['data']) && count($result['data']) > 0){
            //判定是否为已结算订单
            if($result['data'][0]['cpsOrderStatus'] == 60){
                //插入订单
                try {
                    $RebateGoodsSuccessLogModel->insert(array(
                        'uid' => $result['data'][0]['cpsKwaimoneyOrderProductView'][0]['comments'],
                        'order_id' => $result['data'][0]['cpsKwaimoneyOrderProductView'][0]['oid'],
                        'title' => $result['data'][0]['cpsKwaimoneyOrderProductView'][0]['itemTitle'],
                        'image' => $result['data'][0]['cpsKwaimoneyOrderProductView'][0]['itemPicUrl'],
                        'estimated_income' => $result['data'][0]['settlementAmount'],
                        'payment_fee' => $result['data'][0]['cpsKwaimoneyOrderProductView'][0]['paymentFee'],
                        'num' => $result['data'][0]['cpsKwaimoneyOrderProductView'][0]['num'],
                        'tech_service_amount' => $result['data'][0]['cpsKwaimoneyOrderProductView'][0]['techServiceAmount'],
                        'create_time' => intval($result['data'][0]['updateTime']/1000)
                    ));
                    $result = '录入成功,请点击领取补贴按钮，领取奖励';
                } catch (\Throwable $th) {
                    $result = '该订单已存在,请检查是否已领取过!';
                }
            }else{
                $result = '请在确认收货15天后来录入订单，当前订单时间未达标';
            }
        }else{
            $result = '您输入的订单号有误,请确认后重试';
        }
        return $Shuchu->json($result);
    }

    /**
     * @description: 抖音手动录入订单
     * @param {RebateGoodsSuccessLogModel} $RebateGoodsSuccessLogModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function douyin_entry_order(RebateGoodsSuccessLogModel $RebateGoodsSuccessLogModel,Shuchu $Shuchu)
    {
        $DouyinSubsidy = new \DouyinSubsidy();
        $result = $DouyinSubsidy->douyin_get_order(input('post.oid'));
        if(count($result['data']['orders'])){
            $tmp = $result['data']['orders'][0];
            //判定是否为已结算
            if($tmp['settle_time']){
                //插入订单
                try {
                    $RebateGoodsSuccessLogModel->insert(array(
                        'uid' => $tmp['pid_info']['external_info'],
                        'order_id' => $tmp['order_id'],
                        'title' => $tmp['product_name'],
                        'image' => $tmp['product_img'],
                        'estimated_income' => $tmp['ads_real_commission'],
                        'payment_fee' => $tmp['total_pay_amount'],
                        'num' => $tmp['item_num'],
                        'tech_service_amount' => $tmp['ads_estimated_tech_service_fee'],
                        'create_time' => time()
                    ));
                    $result = '录入成功,请点击领取补贴按钮，领取奖励';
                } catch (\Throwable $th) {
                    $result = '该订单已存在,请检查是否已领取过!';
                }
            }else{
                $result = '请在确认收货15天后来录入订单，当前订单时间未达标';
            }
        }else{
            $result = '您输入的订单号有误,请确认后重试';
        }
        return $Shuchu->json($result);
    }

    /**
     * @description: 抖音回调
     * @return {*}
     */    
    public function douyin_huitiao(RebateGoodsLogModel $RebateGoodsLogModel,RebateGoodsSuccessLogModel $RebateGoodsSuccessLogModel)
    {
        //验签
        $sign = md5(mb_convert_encoding(env('douyin.app_key', '').json_encode(input('post.'),JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).env('douyin.app_secret', ''),'UTF-8'));
        if($sign == request()->header('event-sign')){
            //处理订单
            $data = input('post.');
            $RebateGoodsLogtmp = [];$RebateGoodsSuccessLogtmp = [];
            foreach ($data as $key => $value) {
                $tmp = json_decode($value['data'],true);
                //插入结算订单
                if($tmp['settle_time']){
                    array_push($RebateGoodsSuccessLogtmp,array(
                        'uid' => $tmp['pid_info']['external_info'],
                        'order_id' => $tmp['order_id'],
                        'title' => $tmp['product_name'],
                        'image' => $tmp['product_img'],
                        'estimated_income' => $tmp['ads_real_commission'],
                        'payment_fee' => $tmp['total_pay_amount'],
                        'num' => $tmp['item_num'],
                        'tech_service_amount' => ($tmp['ads_real_commission'] / 0.9) - $tmp['ads_real_commission'],
                        'create_time' => time()
                    ));
                }else if($tmp['flow_point'] == 'PAY_SUCC'){
                    array_push($RebateGoodsLogtmp,array(
                        'uid' => $tmp['pid_info']['external_info'],
                        'order_id' => $tmp['order_id'],
                        'title' => $tmp['product_name'],
                        'image' => $tmp['product_img'],
                        'estimated_income' => $tmp['ads_estimated_commission'],
                        'payment_fee' => $tmp['total_pay_amount'],
                        'num' => $tmp['item_num'],
                        'tech_service_amount' => ($tmp['ads_estimated_commission'] / 0.9) - $tmp['ads_estimated_commission'],
                        'create_time' => time()
                    ));
                }
            }
            //插入所有订单数据
            if (count($RebateGoodsLogtmp)) {
                //普通付款订单
                $RebateGoodsLogModel->extra('IGNORE')->insertAll($RebateGoodsLogtmp);
            }
            //插入所有结算数据
            if(count($RebateGoodsSuccessLogtmp)){
                //成功结算的订单
                $RebateGoodsSuccessLogModel->extra('IGNORE')->insertAll($RebateGoodsSuccessLogtmp);
            }
        }
        //返回成功
        return json(array( "code" => 0,"msg" => "success" ));
    }
}
