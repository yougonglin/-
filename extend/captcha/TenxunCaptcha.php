<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: Your Name you@example.com
 * @Description: 杰出人类商城项目
 */
namespace captcha;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Captcha\V20190722\CaptchaClient;
use TencentCloud\Captcha\V20190722\Models\DescribeCaptchaResultRequest;
use think\facade\Cache;

class TenxunCaptcha {

    /**
     * @description: 验证，如果还被盗刷，那就启动前端加密后验证密钥，通过后再验证验证码
     * @param {*} $Ticket 客户端返回票据
     * @param {*} $Randstr 客户端随机字符串
     * @return {*}
     */    
    public function verify($Ticket,$Randstr)
    {
        $redis = Cache::store('redis_permanent')->handler();
        $overTime = $redis->hget("ip_blacklist",request()->ip());
        if(time() > $overTime){
            try {
                // 实例化一个认证对象，入参需要传入腾讯云账户 SecretId 和 SecretKey，此处还需注意密钥对的保密
                // 代码泄露可能会导致 SecretId 和 SecretKey 泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考，建议采用更安全的方式来使用密钥，请参见：https://cloud.tencent.com/document/product/1278/85305
                // 密钥可前往官网控制台 https://console.cloud.tencent.com/cam/capi 进行获取
                $cred = new Credential(env('captcha.tenxun_captcha_secret_id', ''),env('captcha.tenxun_captcha_secret_key', ''));
                // 实例化一个http选项，可选的，没有特殊需求可以跳过
                $httpProfile = new HttpProfile();
                $httpProfile->setEndpoint("captcha.tencentcloudapi.com");
            
                // 实例化一个client选项，可选的，没有特殊需求可以跳过
                $clientProfile = new ClientProfile();
                $clientProfile->setHttpProfile($httpProfile);
                // 实例化要请求产品的client对象,clientProfile是可选的
                $client = new CaptchaClient($cred, "", $clientProfile);
            
                // 实例化一个请求对象,每个接口都会对应一个request对象
                $req = new DescribeCaptchaResultRequest();
                
                $params = array(
                    "Ticket" => $Ticket,
                    "Randstr" => $Randstr,
                    "CaptchaType" => 9,
                    "UserIp" => request()->ip(),
                    "CaptchaAppId" => 197338208,
                    "AppSecretKey" => "R7eh2232lu4Rn9KTHDdIsCip7"
                );
                $req->fromJsonString(json_encode($params));
            
                // 返回的resp是一个DescribeCaptchaResultResponse的实例，与请求对象对应
                $resp = $client->DescribeCaptchaResult($req);
                //如果不等于1说明异常请求拉入黑名单
                if($resp->CaptchaCode != 1){
                    $redis->hset("ip_blacklist",request()->ip(),time() + 86400);
                }
                // 输出json格式的字符串回包
                return($resp);
            }catch(TencentCloudSDKException $e) {
                return (Object) array("CaptchaCode" => -1);
            }
        }else{
            return (Object) array("CaptchaCode" => -2);
        }
    }

}
