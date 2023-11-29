<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\app\controller\games;
use \supernova\Shuchu;
use think\facade\Db;
use app\app\model\user\YueLog;
use app\app\model\user\UserModel;
use app\app\model\user\LotteryLogModel;
use app\app\model\user\YinbiLogModel;

class LotteryController
{
    public $pointsData = array(10,50,100,500,1000,5000,10000,66666,88888);

    
    /**
     * @description: 获取积分盲盒数据
     * @return {*}
     */    
    public function get_point(Shuchu $Shuchu)
    {
        $data = $this->pointsData;
        return $Shuchu->json($data);
    }

    /**
     * @description: 创建积分盲盒订单
     * @param {Request} $request
     * @param {MangheServices} $mangheServices
     * @return {*}
     */    
    public function build_point(UserModel $UserModel,LotteryLogModel $LotteryLogModel,YueLog $YueLog,YinbiLogModel $YinbiLogModel,Shuchu $Shuchu)
    {
        $price = $this->pointsData[input('post.type')];
        $uid = request()->userInfo->uid;
        if($uid == 1){
            $result = -1;
        }else{
            $yinbi_num = $UserModel->where('uid',$uid)->value('yinbi_num');
            Db::startTrans();
            try {
                //如果剩余积分不足就扣除余额,不然就先扣除积分
                if($yinbi_num > $price){
                    $UserModel->where('uid',$uid)->dec('yinbi_num',$price)->update();
                    $YinbiLogModel->save([
                        'uid' => $uid,
                        'num' => $price,
                        'type' => 2,
                        'mark' => '银币抽取费用'
                    ]);
                }else{
                    $UserModel->where('uid',$uid)->dec('yue_num',$price)->update();
                    //余额记录
                    $YueLog->save([
                        'uid' => $uid,
                        'num' => $price,
                        'type' => 2,
                        'mark' => '银币抽取费用'
                    ]);
                }
                //创建并获取ID
                $LotteryLogModel->save(array(
                    'uid' => $uid,
                    'num' => $price
                ));
                $result = $LotteryLogModel->id;
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                $result = 0;
                // 回滚事务
                Db::rollback();
            }
            
        }
        return $Shuchu->json($result);
    }


    /**
     * @description: 积分盲盒结算
     * @param {Request} $request
     * @param {MangheServices} $mangheServices
     * @return {*}
     */    
    public function settle_accounts_point(UserModel $UserModel,LotteryLogModel $LotteryLogModel,YinbiLogModel $YinbiLogModel,Shuchu $Shuchu)
    {
        // cache('jcrl_settle_accounts_point','已结算',0);
        //设置更新时间
        cache('jcrl_settle_accounts_point_time',time());
        //查询结算锁，如果结算中则进入下一轮结算，必须。否则会出现结算数据重复取出的严重问题
        if(cache('jcrl_settle_accounts_point') == '已结算'){
            //必须放在if里，避免设置失败然后还是已结算
            if(cache('jcrl_settle_accounts_point','结算中')){
                $manghePointLogArr = [];$upUserDataArr = [];$yinbiLogArr = [];
                //按照不同价格取出订单，分别结算
                foreach ($this->pointsData as $key => $value) {
                    //取出订单
                    $PointLog = $LotteryLogModel->field('id,uid,num')->where([
                        'num' => $value,
                        'status' => 0
                    ])->select()->toArray();
                    //如果只有一个用户的话就增加一个系统用户
                    if(count($PointLog) == 1){
                        array_push($PointLog,array('num' => $value,'uid' => 1));
                    }
                    //取出总共参与了多少积分,并扣除10%手续费
                    $nums = intval(array_sum(array_column($PointLog,'num')) * 0.9);
                    //随机打乱数组，越靠前中大奖几率越大
                    shuffle($PointLog);
                    //限额5倍积分，用户最多抽到5倍参赛金额
                    $max = $value * 5;
                    //取出总参与人数，因为for循环的key是0开始所以-1
                    $total = count($PointLog) - 1;
                    //随机积分生成
                    foreach ($PointLog as $orderInfoKey => $orderInfo) {
                        //如果是最后一个用户直接获取所有剩余积分
                        if($total == $orderInfoKey){
                            $num = $nums;
                        }else{
                            //取出随机积分，剩余积分不足5倍就直接取剩余
                            if($nums > $max){
                                $num = mt_rand(1,$max);
                            }else{
                                //计算限定，确保能够每人最少分的1积分
                                $limit = $nums - ($total - $orderInfoKey);//获取剩余人数
                                $num = mt_rand(1,$limit);
                            }
                        }
                        //总金额减去目前的数据
                        $nums = $nums - $num;
                        //如果是系统用户则不写入数据库
                        if($orderInfo['uid'] === 1){
                            continue;
                        }
                        //组合更新数据
                        array_push($manghePointLogArr,array(
                            'id' => $orderInfo['id'],
                            'points' => $num,
                            'status' => 1
                        ));
                        array_push($upUserDataArr,array(
                            'uid' => $orderInfo['uid'],
                            'yinbi_num' => Db::raw('yinbi_num+' . $num)
                        ));
                        array_push($yinbiLogArr,[
                            'uid' => $orderInfo['uid'],
                            'num' => $num,
                            'type' => 1,
                            'mark' => '银币抽取奖励'
                        ]);
                    }
                }
                
                //判断有数据要更新才更新
                if(count($manghePointLogArr)){
                    Db::startTrans();
                    try {
                        $result = count($LotteryLogModel->saveAll($manghePointLogArr)->toArray());
                        $result = count($UserModel->saveAll($upUserDataArr)->toArray());
                        $YinbiLogModel->saveAll($yinbiLogArr);
                        //解除限制
                        cache('jcrl_settle_accounts_point','已结算',0);
                        // 提交事务
                        Db::commit();
                    } catch (\Exception $e) {
                        Log::channel('pay')->error('积分盲盒更新订单错误：'.$e->getMessage());
                        $result = 0;
                        // 回滚事务
                        Db::rollback();
                    }
                }else{
                    $result = '没有数据需要更新';
                    //解除限制
                    cache('jcrl_settle_accounts_point','已结算',0);
                }
            }else{
                $result = '积分盲盒无法设置cache';
            }
        }else{
            $result = '上组数据结算中,本次结算进入下一轮';
        }
        return $Shuchu->json($result);
    }

    /**
     * @description: 积分开盒日志
     * @param {Request} $request
     * @param {MangheServices} $mangheServices
     * @return {*}
     */    
    public function get_point_log(LotteryLogModel $LotteryLogModel,Shuchu $Shuchu)
    {
        $uid = request()->userInfo->uid;
        $result['log'] = $LotteryLogModel->field('id,num,points,status,create_time')->where('uid',$uid)->page(intval(input('get.page')),30)->order('id', 'desc')->select();
        $result['time'] = cache('jcrl_settle_accounts_point_time');
        return $Shuchu->json($result);
    }
}
