<?php
declare (strict_types = 1);

namespace app\app\controller\activity;
use app\app\model\user\UserModel;
use app\app\model\user\YueLog;
use app\app\model\activity\BonusOrderModel;
use app\app\model\activity\BonusTaskModel;
use think\facade\Db;
use app\app\model\user\JinbiLogModel;
use \supernova\Shuchu;
use \captcha\TenxunCaptcha;

class BonusController
{
    /**
     * @description:创建任务 
     * @return {*}
     */
    protected function build_task($id)
    {
        $BonusTaskModel = new BonusTaskModel();
        //生成随机签到时间
        $signTime = strtotime(date('Y-m-d',strtotime('+1 day')));
        $signTimeMorning = mt_rand($signTime +3600*5,$signTime +3600*7);
        $signTimeNoon = mt_rand($signTime +3600*10,$signTime +3600*12);
        $signTimeAfternoon = mt_rand($signTime +3600*17,$signTime +3600*19);
        //生成任务
        $result = $BonusTaskModel->insert([
            'id' => $id,
            'sign_time_morning' => $signTimeMorning,
            'sign_time_noon' => $signTimeNoon,
            'sign_time_afternoon' => $signTimeAfternoon
        ]);
        return $result;
    }
     /**
     * @description: 创建分红订单
     * @return {*}
     */
    public function build_order(UserModel $UserModel,BonusOrderModel $BonusOrderModel,YueLog $YueLog,Shuchu $Shuchu)
    {
        $uid = request()->userInfo->uid;
        $price = 30;
        Db::startTrans();
        try {
            //扣除余额
            $UserModel->where('uid',$uid)->dec('yue_num',$price)->update();
            //余额记录
            $YueLog->save([
                'uid' => $uid,
                'num' => $price,
                'type' => 2,
                'mark' => '签到领红包活动报名费'
            ]);
            //创建订单
            $result = $BonusOrderModel->insertGetId([
                'uid' => $uid,
                'start_date' => date("Y-m-d")
            ]);
            $this->build_task($result);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            $result = 0;
            // 回滚事务
            Db::rollback();
        }
        return $Shuchu->json($result);
    }

    /**
     * @description:获取正在进行的分红单 
     * @return {*}
     */
    public function get_order(BonusOrderModel $BonusOrderModel,Shuchu $Shuchu)
    {
        $uid = request()->userInfo->uid;
        $result = $BonusOrderModel->where('uid',$uid)->where('status',1)->whereOr([['status','=',-1]])->order('id', 'desc')->find();
        return $Shuchu->json($result);
    }

    /**
     * @description:获取今日任务 
     * @return {*}
     */
    public function get_task(BonusTaskModel $BonusTaskModel,Shuchu $Shuchu)
    {
        $result = $BonusTaskModel->where('id',input('post.id'))->where('status',1)->find();
        return $Shuchu->json($result);
    }

    /**
     * @description:签到 
     * @return {*}
     */    
    public function sign(UserModel $UserModel,BonusOrderModel $BonusOrderModel,BonusTaskModel $BonusTaskModel,JinbiLogModel $JinbiLogModel,TenxunCaptcha $TenxunCaptcha,Shuchu $Shuchu)
    {
        $result = $TenxunCaptcha->verify(input('post.Ticket'),input('post.Randstr'));
        if($result->CaptchaCode == 1){
            $uid = request()->userInfo->uid;
            $task = $BonusTaskModel->where('id',input('post.id'))->where('status',1)->find();
            //获取当日成功签到次数
            $nums = $this->sign_start($task,'morning') + $this->sign_start($task,'noon') + $this->sign_start($task,'afternoon');
            //三次签到都成功签到，更新任务单为完成状态
            if($nums === 20){
                //更改任务为完成状态
                $result = $BonusTaskModel->where('id',$task['id'])->where('status',1)->update(['status' => 2]);
                //更新签到天数
                $result = $BonusOrderModel->where('id',$task['id'])->update(['signed_days'	=>	Db::raw('signed_days+1')]);
                $result = $BonusOrderModel->where('id',$task['id'])->where('status',1)->find();
                //签到满365天结算，否则创建新任务
                if($result['signed_days'] == 365){
                    $UserModel->where('uid',$uid)->inc('jinbi_num',10000)->update();
                    //添加金币记录
                    $JinbiLogModel->save([
                        'uid' => $uid,
                        'num' => 10000,
                        'type' => 1,
                        'mark' => '签到领红包活动成功签到'
                    ]);
                    //将订单设置为已完成
                    $BonusOrderModel->where('id',$task['id'])->update(['status' => 2]);
                    $result = 6;
                }else{
                    $this->build_task($task['id']);
                    $result = 1;
                }
            }else{
                //如果小于-500说明错过了签到时间，否则大于10说明成功签到，否则说明时间未到
                if($nums < -500){
                    $result = 4;
                }elseif($nums > 10){
                    $result = 2;
                }else{
                    $result = 3;
                }
            }
        }else{
            $result = 5;
        }
        return $Shuchu->json($result);
    }

    protected function sign_start($task,$type)
    {
        $now = time();
        $signTime = $task["sign_time_{$type}"];
        //判断是否已经签到，签了就返回
        if(!$task["{$type}_sign"]){
            $BonusOrderModel = new BonusOrderModel();
            $BonusTaskModel = new BonusTaskModel();
            if($now >= $signTime && $now <= $signTime + 600){
                $BonusTaskModel->where('id',$task['id'])->where('status',1)->update(["{$type}_sign" => 1]);
                return 20;
            }else{
                //如果当前时间大于签到时间10分钟就关闭签到任务
                if($now > $signTime + 600){
                    //错过签到
                    $result = $BonusTaskModel->where('id',$task['id'])->where('status',1)->update(['status' => -1]);
                    $BonusOrderModel->where('id',$task['id'])->update(['status' => -1]);
                    return -1000;
                }else{
                    //签到时间小于当前时间
                    return -1;
                }
            }
        }else{
            return 0;
        }
    }

    /**
     * @description:补签 
     * @return {*}
     */    
    public function countersign(BonusOrderModel $BonusOrderModel,UserModel $UserModel,YueLog $YueLog,Shuchu $Shuchu)
    {
        $signed_days = $BonusOrderModel->where('id',input('post.id'))->value('signed_days');
        $uid = request()->userInfo->uid;
        $price = $signed_days * 30;
        Db::startTrans();
        try {
            $UserModel->where('uid',$uid)->dec('yue_num',$price)->update();
            //余额记录
            $YueLog->save([
                'uid' => $uid,
                'num' => $price,
                'type' => 2,
                'mark' => '签到补签费用'
            ]);
            //增加一天签到,并且状态改为进行中
            $BonusOrderModel->where('id',input('post.id'))->update([
                'signed_days'	=>	Db::raw('signed_days+1'),
                'status' => 1
            ]);
            //创建新的任务
            $this->build_task(input('post.id'));
            $result = 'ok';
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            $result = $price;
            // 回滚事务
            Db::rollback();
        }
        return $Shuchu->json($result);
    }

    /**
     * @description:关闭订单 
     * @return {*}
     */    
    public function close_order(BonusOrderModel $BonusOrderModel,Shuchu $Shuchu)
    {
        $uid = request()->userInfo->uid;
        $result = $BonusOrderModel->where('uid',$uid)->where('status',-1)->update(['status' => -2]);
        return $Shuchu->json($result);
    }

}
