<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: Your Name you@example.com
 * @Description: 杰出人类商城项目
 */
namespace pay;
use Alipay\EasySDK\Kernel\Factory;
use Alipay\EasySDK\Kernel\Config;
class Alipay
{

    
    public function __construct()
    {
        Factory::setOptions($this->getOptions());
    }

    public function getOptions()
    {
        $options = new Config();
        $options->protocol = 'https';
        $options->gatewayHost = 'openapi.alipay.com';
        $options->signType = 'RSA2';
        
        $options->appId = '2021002190658357';
        
        // 为避免私钥随源码泄露，推荐从文件中读取私钥字符串而不是写入源码中
        $options->merchantPrivateKey = env('pay.merchant_private_key', '');
        
        $options->alipayCertPath = app()->getRootPath() . 'extend/pay/alipayCertPublicKey_RSA2.crt';
        $options->alipayRootCertPath = app()->getRootPath() . 'extend/pay/alipayRootCert.crt';
        $options->merchantCertPath = app()->getRootPath() . 'extend/pay/appCertPublicKey_2021002190658357.crt';
        
        //注：如果采用非证书模式，则无需赋值上面的三个证书路径，改为赋值如下的支付宝公钥字符串即可
        // $options->alipayPublicKey = '<-- 请填写您的支付宝公钥，例如：MIIBIjANBg... -->';
        //可设置异步通知接收服务地址（可选）
        //如果需要使用文件上传接口，请不要设置该参数
        $options->notifyUrl = request()->domain() . "/app/pay/notify_url";
        
        //可设置AES密钥，调用AES加解密相关接口时需要（可选）
        $options->encryptKey = "<-- 请填写您的AES密钥，例如：aa4BtZ4tspm2wnXLb1ThQA== -->";
        return $options;
    }

    /**
     * @description: 创建商品购买
     * @param {*} $subject 商品标题
     * @param {*} $orderId 订单ID
     * @param {*} $price 商品价格
     * @return {*}
     */    
    public function create_order($subject,$orderId,$price,$platform)
    {
        //2. 发起API调用（以支付能力下的统一收单交易创建接口为例）
        try {
            if($platform == 'android' || $platform == 'ios'){
                $result = Factory::payment()->app()->pay($subject,$orderId,$price);
            }else{
                // $result = Factory::payment()->wap()->pay($subject,$orderId,$price,request()->domain() . "/pages/user/recharge/index",request()->domain() . "/pages/user/recharge/index");
                $result = Factory::payment()->page()->pay($subject,$orderId,$price,request()->domain() . "/pages/user/recharge/index");
            }
            return $result;
        } catch (Exception $e) {
            echo "调用失败，". $e->getMessage(). PHP_EOL;;
        }
    }

    /**
     * @description: 预支付冻结资金
     * @param {*} $subject
     * @param {*} $orderId
     * @param {*} $price
     * @return {*}
     */    
    public function freeze($subject,$orderId,$price)
    {
        $result = Factory::util()->generic()->sdkExecute("alipay.fund.auth.order.app.freeze", [], [
            'out_order_no' => $orderId,
            'out_request_no' => $orderId,
            'order_title' => $subject,
            'amount' => $price,
            'product_code' => 'PRE_AUTH_ONLINE',
            'payee_user_id' => '2088241698425582'
        ]);
        return $result->body;
    }

    /**
     * @description: 冻结资金支付
     * @param {*} $subject
     * @param {*} $orderId
     * @param {*} $price
     * @param {*} $auth_no
     * @return {*}
     */    
    public function freeze_pay($subject,$orderId,$price,$auth_no)
    {
        $result = Factory::util()->generic()->execute("alipay.trade.pay", [], [
            'out_trade_no' => $orderId,
            'total_amount' => $price,
            'subject' => $subject,
            'product_code' => 'PRE_AUTH_ONLINE',
            'auth_no' => $auth_no
        ]);
        return $result;
    }

    public function notify_url($params)
    {
        $result = Factory::payment()->common()->verifyNotify($params); // 验证签名
        if ($result) {
            if($params['trade_status'] == 'TRADE_SUCCESS' || $params['trade_status'] == 'TRADE_FINISHED'){
                return true;
            }
        } else {
            return false;      
        }
    }
}
