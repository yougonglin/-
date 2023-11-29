<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: Your Name you@example.com
 * @Description: 杰出人类商城项目
 */
namespace pay;
use WeChatPay\Builder;
use WeChatPay\Crypto\Rsa;
use WeChatPay\Util\PemUtil;
use WeChatPay\Formatter;
use WeChatPay\Crypto\AesGcm;
class Wxpay
{
    public $instance;
    public $appid = 'wx811468c25e50d2e5';
    // 商户号
    public $merchantId = '1632454841';
    public function __construct()
    {
        // 从本地文件中加载「商户API私钥」，「商户API私钥」会用来生成请求的签名
        $merchantPrivateKeyFilePath = 'file://' . app()->getRootPath() . 'extend/pay/apiclient_key.pem';
        $merchantPrivateKeyInstance = Rsa::from($merchantPrivateKeyFilePath, Rsa::KEY_TYPE_PRIVATE);

        // 「商户API证书」的「证书序列号」
        $merchantCertificateSerial = '5D68AEA1784EB498622CA2DBDD84110C78AF7E31';

        // 从本地文件中加载「微信支付平台证书」，用来验证微信支付应答的签名
        $platformCertificateFilePath = 'file://' . app()->getRootPath() . 'extend/pay/wechatpay_561C5B8E4D75858F1728930710E809E1EC0CD5B1.pem';
        $platformPublicKeyInstance = Rsa::from($platformCertificateFilePath, Rsa::KEY_TYPE_PUBLIC);

        // 从「微信支付平台证书」中获取「证书序列号」
        $platformCertificateSerial = PemUtil::parseCertificateSerialNo($platformCertificateFilePath);

        // 构造一个 APIv3 客户端实例
        $this->instance = Builder::factory([
            'mchid'      => $this->merchantId,
            'serial'     => $merchantCertificateSerial,
            'privateKey' => $merchantPrivateKeyInstance,
            'certs'      => [
                $platformCertificateSerial => $platformPublicKeyInstance,
            ],
        ]);
    }

    public function create_order($subject,$orderId,$price,$platform,$openid = '')
    {
        if($platform == 'android' || $platform == 'ios'){
            return $this->h5($subject,$orderId,$price);
            // return $this->app($subject,$orderId,$price);
        }else{
            if($openid){
                return $this->jsapi($subject,$orderId,$price,$openid);
            }else{
                return $this->h5($subject,$orderId,$price);
            }
        }
    }

    public function h5($subject,$orderId,$price)
    {
        $resp = $this->instance->chain('v3/pay/transactions/h5')->post(['json' => [
            "mchid" => $this->merchantId,
            "out_trade_no" => $orderId,
            "appid" => $this->appid,
            "description" => $subject,
            "notify_url" => "https://shop.jiechurenlei.com/api/v2/fenhong/notify_url",
            "amount" => [
                "total" => (int) ($price * 100),
                "currency" => "CNY"
            ],
            "scene_info" => [
                "payer_client_ip" => request()->ip(),
                "h5_info" => [ "type" => "Wap" ]
            ]
        ]])->getBody()->getContents();
        return json_decode($resp,true);
    }

    public function app($subject,$orderId,$price)
    {
        $resp = $this->instance->chain('v3/pay/transactions/app')->post(['json' => [
            "mchid" => $this->merchantId,
            "out_trade_no" => $orderId,
            "appid" => 'wx97d81b14c90b9588',
            "description" => $subject,
            "notify_url" => request()->domain() . "/app/pay/notify_url",
            "amount" => [
                "total" => (int) ($price * 100),
                "currency" => "CNY"
            ]
        ]])->getBody()->getContents();
        return json_decode($resp,true);
    }

    /**
     * @description: 公众号支付，PC支付
     * @param {*} $subject
     * @param {*} $orderId
     * @param {*} $price
     * @return {*}
     */    
    public function jsapi($subject,$orderId,$price,$openid)
    {
        $resp = $this->instance->chain('v3/pay/transactions/jsapi')->post(['json' => [
            "mchid" => $this->merchantId,
            "out_trade_no" => $orderId,
            "appid" => $this->appid,
            "description" => $subject,
            "notify_url" => request()->domain() . "/app/pay/notify_url",
            "amount" => [
                "total" => (int) ($price * 100),
                "currency" => "CNY"
            ],
            "payer" => ["openid" => $openid]
        ]])->getBody()->getContents();
        return json_decode($resp,true);
    }

    /**
     * @description: 支付要用到的签名
     * @param {*} $prepay_id
     * @return {*}
     */    
    public function pay_sign($name,$arr)
    {
        $merchantPrivateKeyFilePath = 'file://' . app()->getRootPath() . 'extend/pay/apiclient_key.pem';
        $merchantPrivateKeyInstance = Rsa::from($merchantPrivateKeyFilePath);
        $params = [
            'appId'     => $this->appid,
            'timeStamp' => (string)Formatter::timestamp(),
            'nonceStr'  => Formatter::nonce()
        ];
        $params += $arr;
        $params += [$name => Rsa::sign(
            Formatter::joinedByLineFeed(...array_values($params)),
            $merchantPrivateKeyInstance
        )];
        
        return $params;
    }

    public function notify_url()
    {
        $inWechatpaySignature = request()->header('Wechatpay-Signature');// 请根据实际情况获取
        $inWechatpayTimestamp = request()->header('Wechatpay-Timestamp');// 请根据实际情况获取
        $inWechatpaySerial = request()->header('Wechatpay-Serial');// 请根据实际情况获取
        $inWechatpayNonce = request()->header('Wechatpay-Nonce');// 请根据实际情况获取
        $inBody = file_get_contents('php://input');// 请根据实际情况获取，例如: file_get_contents('php://input');

        $apiv3Key = env('pay.apiv3_key', '');// 在商户平台上设置的APIv3密钥

        // 根据通知的平台证书序列号，查询本地平台证书文件，
        // 假定为 `/path/to/wechatpay/inWechatpaySerial.pem`
        $platformCertificateFilePath = 'file://' . app()->getRootPath() . 'extend/pay/wechatpay_561C5B8E4D75858F1728930710E809E1EC0CD5B1.pem';
        $platformPublicKeyInstance = Rsa::from($platformCertificateFilePath, Rsa::KEY_TYPE_PUBLIC);

        // 检查通知时间偏移量，允许5分钟之内的偏移
        $timeOffsetStatus = 300 >= abs(Formatter::timestamp() - (int)$inWechatpayTimestamp);
        $verifiedStatus = Rsa::verify(
            // 构造验签名串
            Formatter::joinedByLineFeed($inWechatpayTimestamp, $inWechatpayNonce, $inBody),
            $inWechatpaySignature,
            $platformPublicKeyInstance
        );
        if ($timeOffsetStatus && $verifiedStatus) {
            // 转换通知的JSON文本消息为PHP Array数组
            $inBodyArray = (array)json_decode($inBody, true);
            // 使用PHP7的数据解构语法，从Array中解构并赋值变量
            ['resource' => [
                'ciphertext'      => $ciphertext,
                'nonce'           => $nonce,
                'associated_data' => $aad
            ]] = $inBodyArray;
            // 加密文本消息解密
            $inBodyResource = AesGcm::decrypt($ciphertext, $apiv3Key, $nonce, $aad);
            // 把解密后的文本转换为PHP Array数组
            $inBodyResourceArray = (array)json_decode($inBodyResource, true);
            // print_r($inBodyResourceArray);// 打印解密后的结果
            return $inBodyResourceArray;
        }else{
            return array('trade_state' => 'fail');
        }
    }
}