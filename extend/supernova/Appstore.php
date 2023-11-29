<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
namespace supernova;
use think\facade\Cache;
class Appstore
{

    public $client_id = '20230810020';
    public $client_secret = '5F8DC7EDD46887ECD094F2D07443206A3067B51061D5375D971C9892C3C24CF3';
    /**
     * @description: 获取vivo的token
     * @param {Request} $request
     * @return {*}
     */    
    public function get_vivo_token($code)
    {
        if(cache('vivoData')){
            $vivoData = json_decode(cache('vivoData'),true);
            $ch = curl_init('https://marketing-api.vivo.com.cn/openapi/v1/oauth2/refreshToken?client_id='. $this->client_id .'&client_secret='. $this->client_secret .'&refresh_token=' . $vivoData['data']['refresh_token']);
        }else{
            $ch = curl_init('https://marketing-api.vivo.com.cn/openapi/v1/oauth2/token?client_id='. $this->client_id .'&client_secret='. $this->client_secret .'&grant_type=code&code=' . $code);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        cache('vivoData',$result,0);
        curl_close($ch);
        return $result;
    }
    /**
     * @description: vivoAPP推广自定义注册/激活
     * @param {*} $oaid
     * @param {*} $type
     * @return {*}
     */
    public function vivo_tuiguang($oaid,$type)
    {
        if(empty($oaid) || $oaid == 'null' || is_null($oaid)){
            return;
        }
        $time = time() * 1000; 
        $vivoData = json_decode(cache('vivoData'),true);
        $url = 'https://marketing-api.vivo.com.cn/openapi/v1/advertiser/behavior/upload?access_token='.$vivoData['data']['access_token'].'&timestamp='.$time.'&nonce='.md5($time . mt_rand(10, 9999999)).'&advertiser_id=74e9801a26b47099d530';    
        //如果是付费要不一样
        if($type == 'PAY'){
            $dataList = [
                [
                    'cvTime' => $time,
                    'cvType' => $type,
                    'userId' => $oaid,
                    'userIdType' => 'OAID'
                ],
                [
                    'cvTime' => $time,
                    'cvType' => "PAY_ONETIME",
                    'userId' => $oaid,
                    'userIdType' => 'OAID',
                    "extParam" => ["payAmount" => "10"]
                ]
            ];
        }else{
            $dataList = [
                'cvTime' => $time,
                'cvType' => $type,
                'userId' => $oaid,
                'userIdType' => 'OAID'
            ];
        }
        $postData = [
        'dataList' => $dataList,
        'pkgName' => 'uni.UNIC0DA0EF',
        'srcId' => 'ds-202308148391',
        'srcType' => 'APP'
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}