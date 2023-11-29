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
use \supernova\Curl;
use think\facade\Db;
use app\app\model\user\YueLog;

class InviteController
{

    /**
     * @description: 获取邀请的用户
     * @param {UserModel} $UserModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function get_user(UserModel $UserModel,Shuchu $Shuchu)
    {
        $result = $UserModel->field('uid,phone,create_time')->withAttr('phone', function($value, $data) {
            return substr_replace($value,'****',3,4);
        })->whereTime('create_time', 'between', [input('post.beginTime'),input('post.endTime')])->where('invite_uid',input('post.invite_uid'))->page((int) input('post.page'),15)->order('uid','desc')->select();
        return $Shuchu->json($result);
    }

    /**
     * @description: 获取邀请用户数量
     * @param {UserModel} $UserModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function get_user_count(UserModel $UserModel,Shuchu $Shuchu)
    {
        $result = $UserModel->field('count(*) as count')->whereTime('create_time', 'between', [input('post.beginTime'),input('post.endTime')])->where('invite_uid',input('post.invite_uid'))->select();
        return $Shuchu->json($result[0]['count']);
    }

    /**
     * @description: 取出传单用户id
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function get_leaflet_uid(Shuchu $Shuchu)
    {
        $redis = Cache::store('redis')->handler();
        $key = $this->get_leaflet_key();
        //取出传单用户
        $leafletUserList = $redis->HVALS($key);
        foreach ($leafletUserList as $key => $value) {
            $tmp = json_decode($value,true);
            $m = getDistance(input('post.longitude'),input('post.latitude'),$tmp['longitude'],$tmp['latitude'],1);
            if($m <= 1500){
                return $Shuchu->json($tmp['id']);
            }
        }
        return $Shuchu->json('0');
    }

    /**
     * @description: 更新/添加传单用户，开始发放传单
     * @param {Curl} $Curl
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function save_leaflet_user(Curl $Curl,UserModel $UserModel,YueLog $YueLog,Shuchu $Shuchu)
    {
        //开始经营
        $postData = input('post.');
        $EXPIRE = strtotime("+1 day",strtotime(date("Y-m-d"),time()));
        $uid = request()->userInfo->uid;
        $postData['id'] = $uid;
        $postData['iconPath'] = '/static/ui/gps.png';
        $postData['radius'] = 1500;
        $postData['fillColor'] = '#ff5a1a4d';
        $postData['color'] = '#ff5a1a4d';
        //开启定位支付3元
        Db::startTrans();
        try {
            //扣除余额
            $UserModel->where('uid',$uid)->dec('yue_num',3)->update();
            //余额记录
            $YueLog->save([
                'uid' => $uid,
                'num' => 3,
                'type' => 2,
                'mark' => '开始发放传单'
            ]);
            //定位逻辑
            $redis = Cache::store('redis')->handler();
            $key = $this->get_leaflet_key();
            //验证是否与他人坐标过近
            $leafletUserList = $redis->HVALS($key);
            $tmpUid = 0;
            //循环比对所有，如果有冲突就设置tmpuid。
            foreach ($leafletUserList as $keys => $value) {
                $tmp = json_decode($value,true);
                $m = getDistance(input('post.longitude'),input('post.latitude'),$tmp['longitude'],$tmp['latitude'],1);
                if($m <= 3000){
                    //避免和自身ID冲突
                    if($tmp['id'] != $uid){
                        $tmpUid = $tmp['id'];
                    }
                }
            }
            if($tmpUid != 0){
                $result = '您距离其他用户太近了,请走出对方的经营圈后重试!';
            }else{
                //更新/插入自身坐标
                $result = $redis->hset((string) $key,(string) $uid,json_encode($postData));
                $redis->EXPIREAT((string) $key,$EXPIRE);
            }
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            $result = '开启定位失败，您的余额不足3元,请充值后重试。';
            // 回滚事务
            Db::rollback();
        }
        return $Shuchu->json($result);
    }

    /**
     * @description: 获取传单key
     * @return {*}
     */    
    public function get_leaflet_key()
    {
        $Curl = new Curl();
        //获取位置
        $curlData = $Curl->get("https://whois.pconline.com.cn/ipJson.jsp",array(
            'ip' => request()->ip(),
            'json' => 'true'
        ));
        preg_match('/pro":"(.*?)"/',$curlData,$match);
        $key = 'leaflet_user_' . md5($match[1]);
        return $key;
    }

    /**
     * @description: 获取传单用户
     * @return {*}
     */    
    public function get_leafletUserList(Shuchu $Shuchu)
    {
        $key = $this->get_leaflet_key();
        $redis = Cache::store('redis')->handler();
        $leafletUserList = $redis->HVALS($key);
        return $Shuchu->json($leafletUserList);
    }
}
