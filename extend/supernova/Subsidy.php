<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
namespace supernova;
use \supernova\Curl;
class Subsidy
{
    public $kuaishou = ['app_id' => 'ks697213520963024931','app_secret' => 'F5C9x0SGLFutiOW64Xo6zA'];

    /**
     * @description: 获取code模式token
     * @param {*} $code
     * @return {*}
     */    
    public function get_kuaishou_code_token($code)
    {
        $result = cache('kuaishou_code_token');
        $Curl = new Curl();
        //如果不是第一次请求code，就用refresh_token来刷新
        if($result){
            $result = json_decode($result,true);
            $result = $Curl->get('https://openapi.kwaixiaodian.com/oauth2/refresh_token',array(
                'grant_type' => 'refresh_token',
                'refresh_token' => $result['refresh_token'],
                ...$this->kuaishou
            ));
            cache('kuaishou_code_token',$result,152800);
        }else{
            //这个返回的就是json字符串不需要encode
            $result = $Curl->get('https://openapi.kwaixiaodian.com/oauth2/access_token',array(
                'grant_type' => 'code',
                'code' => $code,
                ...$this->kuaishou
            ));
            cache('kuaishou_code_token',$result,152800);
        }
        return $result;
    }

    public function get_kuaishou_client_credentials_token()
    {
        $result = cache('kuaishou_client_credentials_token');
        if(!$result){
            $Curl = new Curl();
            $result = json_decode($Curl->get('https://openapi.kwaixiaodian.com/oauth2/access_token',array(
                'grant_type' => 'client_credentials',
                ...$this->kuaishou
            )),true);
            $result = $result['access_token'];
            cache('kuaishou_client_credentials_token',$result,168888);
        }
        return $result;
    }

    /**
     * @description: 快手签名
     * @param {*} $token
     * @param {*} $method
     * @param {*} $param
     * @param {*} $time
     * @return {*}
     */    
    public function kuaishou_sign($token,$method,$param,$time,$sign = '')
    {
        if($sign){
            $result = array('appkey' => $this->kuaishou['app_id'],'timestamp' => $time,'access_token' => $token,'version' => 1,'param' => $param,'method' => $method,'sign' => $sign,'signMethod' => 'MD5');
        }else{
            $result = md5("access_token={$token}&appkey={$this->kuaishou['app_id']}&method={$method}&param={$param}&signMethod=MD5&timestamp={$time}&version=1&signSecret=a49f4a6e4c3c118aab8c00ab313f582f");
        }
        return $result;
    }

    /**
     * @description: 
     * @param {*} $apiName 快手快赚客的api名称，如：open.distribution.cps.kwaimoney.selection.item.list
     * @param {*} $isPost 是否为post请求
     * @param {*} $param api请求参数
     * @return {*}
     */      
    public function kuaishou($apiName,$isPost,$param)
    {
        //把apiname改为url
        $url = str_ireplace('.','/',$apiName);
        $time = time() * 1000;
        //获取token
        $token = json_decode(cache('kuaishou_code_token'),true);
        $param = json_encode($param);
        //获取签名
        $sign = $this->kuaishou_sign($token['access_token'],$apiName,$param,$time);
        $Curl = new Curl();
        //获取请求参数数组
        $postData = $this->kuaishou_sign($token['access_token'],$apiName,$param,$time,$sign);
        if($isPost){
            $result = $Curl->post('https://openapi.kwaixiaodian.com/' . $url,$postData);
        }else{
            $result = $Curl->get('https://openapi.kwaixiaodian.com/' . $url,$postData);
        }
        return $result;
    }
    
}