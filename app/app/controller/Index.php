<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: Your Name you@example.com
 * @Description: 杰出人类商城项目
 */

declare (strict_types = 1);

namespace app\app\controller;
use \sms\TenxunSms;
use \think\facade\Filesystem;
use \supernova\Shuchu;
use think\facade\Cache;
use \captcha\TenxunCaptcha;
use \supernova\Weixin;
use \supernova\Appstore;
use Imagine\Image\Box;
use Imagine\Gd\Imagine;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use \tts\TenxunTts;
class Index
{
    /**
     * @description: 发送短信验证码
     * @param {TenxunCaptcha} $TenxunCaptcha
     * @param {TenxunSms} $TenxunSms
     * @return {*}
     */    
    public function sms_code(TenxunCaptcha $TenxunCaptcha,TenxunSms $TenxunSms)
    {
        $jmToken = jm_token();
        if($jmToken == input('post.jmToken')){
            $result = $TenxunCaptcha->verify(input('post.Ticket'),input('post.Randstr'));
            if($result->CaptchaCode == 1){
                $phone = '+86'.input('post.phone');
                $smsCode = cache('sms_code:'.input('post.phone'));
                //如果验证码没过期就不重新获取
                if(!$smsCode){
                    $smsCode = mt_rand(100000,999999);
                    cache('sms_code:'.input('post.phone'),$smsCode,300);
                }
                $result = $TenxunSms->send_code("1828567",array((string) $smsCode,'5'),array($phone));
            }else{
                return json($result);
            }
        }else{
            $result = 'verifyError!';
        }
        return json($result);
    }

    /**
     * @description: 文件上传
     * @param {Imagine} $Imagine
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function upload(Imagine $Imagine,Shuchu $Shuchu)
    {
        //验证上传权限
        $loginToken = request()->header('supernova-token') ?? request()->get('supernova-token');
        if($loginToken){
            try {
                $decoded = JWT::decode($loginToken, new Key(config('common.jwt_key'), 'HS256'));
                $originDir = $decoded->data->uid;
            } catch (\Throwable $th) {
                return json('非法入侵已拦截!');
            }
        }else{
            //判定是否为管理员
            $token = request()->header('admin-supernova-token');
            $key = env('init.admin_password', '123456');
            if($token == $key){
                $originDir = 'admin';
            }else{
                return json('非法入侵已拦截');
            }
        }
        //处理上传文件
        $files = request()->file();
        try {
            //配置验证规则，防止上传漏洞
            $validate = [];
            foreach ($files as $key => $value) {
                $validate[$key] = 'fileMime:image/jpeg,image/png,image/gif';
            }
            validate($validate)->check($files);
            //上传文件
            $savename = [];
            foreach($files as $file) {
                if($file->extension() == ''){ $file->setExtension('mp3'); }
                //获取上传文件类型
                $mime = $file->getMime();
                //获取上传保存目录
                $fileDir = request()->header('fileDir') . '/' . $mime . '/' . $originDir;
                $savename[] = Filesystem::disk('public')->putFile($fileDir, $file);
                //判定如果是图片就进行相应处理
                if(strpos($mime,'image') !== false){
                    //缩放图片
                    $dir = app()->getRootPath() . 'public/storage/' . $savename[count($savename) - 1];
                    $imgInfo = $Imagine->open($dir);
                    $size = $imgInfo->getSize();
                    //如果宽度比手机屏幕大就缩放
                    if($size->getWidth() > 390){
                        $bili = bcdiv('390',(string) $size->getWidth(),6);
                        $height = intval($size->getHeight() * $bili);
                        $imgInfo->resize(new Box(390,$height))->save($dir,array('flatten' => true));
                    }
                }
            }
            return $Shuchu->json($savename);
        } catch (\think\exception\ValidateException $e) {
            return $Shuchu->json(201,$e->getMessage());
        }
    }

    /**
     * @description: 获取vivo商店统计token
     * @param {Appstore} $Appstore
     * @return {*}
     */    
    public function get_vivo_token(Appstore $Appstore)
    {
        return $Appstore->get_vivo_token(input('get.code'));
    }

    /**
     * @description: 自定义用户激活
     * @param {Appstore} $Appstore
     * @return {*}
     */    
    public function vivo_active(Appstore $Appstore)
    {
        $result = $Appstore->vivo_tuiguang(input('post.oaid'),'ACTIVATION');
        return json($result);
    }


    /**
     * @description: 获取oss文件
     * @return {*}
     */    
    public function get_file()
    {
        //判断请求来源，如果经过cloudflare说明为国外，直接返回文件地址
        if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])){
            return redirect('http://www.thinkphp.cn');
        }else{
            return redirect(request()->domain() . '/storage/' . input('get.path'));
            //如果是国内就先判断本地服务器是否有文件，没有就下载到本地服务器再返回
        }
    }

    /**
     * @description: 获取小程序scheme用于外部浏览器跳转
     * @param {Weixin} $Weixin
     * @return {*}
     */    
    public function get_wx_scheme(Weixin $Weixin,Shuchu $Shuchu)
    {
        $result = $Weixin->get_wx_scheme(input('post.path','/pages/index/index'),input('post.query',''));
        return $Shuchu->json($result);
    }

    /**
     * @description: 语音合成
     * @param {TenxunTts} $TenxunTts
     * @return {*}
     */    
    public function get_voice(TenxunTts $TenxunTts,Shuchu $Shuchu)
    {
        $result = $TenxunTts->getVoice(input('post.text'),input('post.VoiceType'),input('post.Speed',0));
        $filename = '/storage/tts/' . md5(input('post.text')) . time() . mt_rand() . '.pcm';
        $pcm_file = fopen(app()->getRootPath() . 'public' . $filename, "w");
        fwrite($pcm_file, $result);
       return $Shuchu->json(request()->domain() . $filename);
       //$result = $TenxunTts->createSign(input('post.'), "POST", "tts.cloud.tencent.com", "/stream", 'iBOL2TeYBXdZJn21kDQO6YkgNozuZy82');
       //return $Shuchu->json($result);
       
    }

}
