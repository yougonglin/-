<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: Your Name you@example.com
 * @Description: 杰出人类商城项目
 */
namespace supernova;
use think\facade\Cache;
use \supernova\Curl;

class Weixin
{
    /**
     * @description: 获取公众号API的token
     * @return {*}
     */    
    public function get_api_token()
    {
        $wx_api_token = Cache::get('wx_api_token','');
        if($wx_api_token == ''){
            $Curl = new Curl();
            $wx_api_token = $Curl->get('https://api.weixin.qq.com/cgi-bin/token',array(
                'grant_type' => 'client_credential',
                'secret' => env('weixin.secret', ''),
                'appid' => env('weixin.appid', '')
            ));
            Cache::set('wx_api_token',$wx_api_token,6888);
        }
        $wx_api_token = json_decode($wx_api_token,true);
        return $wx_api_token['access_token'];
    }

    /**
     * @description: 获取小程序scheme用于外部浏览器跳转
     * @return {*}
     */    
    public function get_wx_scheme($path,$query)
    {
        $token = $this->get_api_token();
        $Curl = new Curl();
        $result = $Curl->post('https://api.weixin.qq.com/wxa/generatescheme?access_token=' . $token,array(
            'jump_wxa' => array(
                'path' => $path,
                'query' => $query
            ),
            "expire_time" => time() + 2590000
        ),15,array('Content-Type:application/json'),'json');
        return $result;
    }
}