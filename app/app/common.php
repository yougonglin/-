<?php
include app()->getRootPath() .  "extend/supernova/Curl.php";
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
// 这是系统自动生成的公共文件

/**
 * @description: 获取当日验证token
 * @return {*}
 */
function jm_token()
{
    $sign = ['!','^','&','@','#','*','.','~','$','%'];
    $arr = array_reverse(str_split(date("Ymd")));
    $token = '';
    foreach ($arr as $key => $value) {
        $token = $token . $sign[$value];
    }
    return $token;
}

/**
 * @description: 获取微信用户token
 * @param {Curl} $Curl
 * @return {*}
 */    
function wx_user_access_token($code)
{
    $Curl = new supernova\Curl();
    $result = $Curl->get('https://api.weixin.qq.com/sns/oauth2/access_token',array(
        'appid' => 'wx811468c25e50d2e5',
        'secret' => '907fd983f2e042bbdb88bc8f13d4561e',
        'code' => $code,
        'grant_type' => 'authorization_code'
    ));
    return $result;
}