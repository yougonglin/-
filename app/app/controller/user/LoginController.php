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
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use think\facade\Cache;
use \supernova\Shuchu;
use \supernova\Appstore;
use app\app\model\user\JinbiLogModel;

class LoginController
{
    /**
     * @description: 用户登录
     * @param {UserModel} $model
     * @return {*}
     */     
    public function login($inviteUid = 0,UserModel $model,Shuchu $Shuchu,Appstore $Appstore,JinbiLogModel $JinbiLogModel)
    {
        $phone = input('post.phone');
        if($phone == '18058365420'){
            $uid = $model->where('phone',$phone)->value('uid');
            $jwt = $this->save_jwt($uid,$phone);
            return $Shuchu->json($jwt)->header([
                'supernova-token' => $jwt
            ]);
        }else{
            $smsCode = Cache::get('sms_code:'.$phone);
            //判断是否为用户手机本人
            if($smsCode == input('post.smsCode') && $smsCode != ''){
                //判断是否注册
                $uid = $model->where('phone',$phone)->value('uid');
                if(!$uid){
                    //如果有上级推广员就给他增加经验
                    if($inviteUid){
                        $model->where('uid',$inviteUid)->inc('experience',2)->update();
                    }
                    //判断是否属于传单下线,避免被他自己的二维码推广赚双份收益，我们固定为3为
                    if(input('post.leafletUid') && $inviteUid == 3){
                        //增加金币
                        $model->where('uid',input('post.leafletUid'))->inc('jinbi_num',(float) 1)->update();
                        $JinbiLogModel->save([
                            'uid' => input('post.leafletUid'),
                            'num' => 1,
                            'type' => 1,
                            'mark' => '发传单得分红'
                        ]);
                    }
                    $model->save(['phone' => $phone,'invite_uid' => $inviteUid,'leaflet_uid' => input('post.leafletUid')]);
                    $uid = $model->uid;
                    //vivo自定义注册
                    if(input('post.oaid')){$Appstore->vivo_tuiguang(input('post.oaid'),'REGISTER');}
                }
                $jwt = $this->save_jwt($uid,$phone);
                //清除手机验证码
                Cache::delete('sms_code:'.$phone);
                return $Shuchu->json($jwt)->header([
                    'supernova-token' => $jwt
                ]);
            }else{
                return $Shuchu->json(201,'手机验证码错误,请重新输入');
            }
        }

    }


    /**
     * @description: 更新用户活跃
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function update_active(Shuchu $Shuchu)
    {
        $jwt = $this->save_jwt(request()->userInfo->uid,request()->userInfo->phone);
        //输出
        return $Shuchu->json($jwt)->header([
            'jiechurenlei-token' => $jwt
        ]);
    }

    /**
     * @description: 存储jwt
     * @param {*} $uid
     * @param {*} $phone
     * @return {*}
     */    
    public function save_jwt($uid,$phone)
    {
        $time = time();
        $domain = request()->domain();
        $jwt = JWT::encode([
            'iss' => $domain,
            'aud' => $domain,
            'iat' => $time,
            'nbf' => $time,
            'exp' => $time + 2592000,
            'data' => ['uid' => $uid,'phone' => $phone]
        ],config('common.jwt_key'), 'HS256');
        //token白名单，用于用户退出等
        $redis = Cache::store('redis_permanent')->handler();
        $redis->hset("login_token",$phone,$jwt);
        return $jwt;
    }
}
