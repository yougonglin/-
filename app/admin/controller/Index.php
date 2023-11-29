<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */

declare (strict_types = 1);

namespace app\admin\controller;
use \sms\TenxunSms;
use \think\facade\Filesystem;
use \supernova\Shuchu;

class Index
{
    public function sms_code()
    {
        $phone = '+86'.input('post.phone');
        $smsCode = cache('sms_code:'.input('post.phone'));
        //如果验证码没过期就不重新获取
        if(!$smsCode){
            $smsCode = mt_rand(100000,999999);
            cache('sms_code:'.input('post.phone'),$smsCode,300);
        }
        $sms = new TenxunSms();
        $result = $sms->send_code("1802617",array((string) $smsCode,'5'),array($phone));
        return json($result);
    }
}
