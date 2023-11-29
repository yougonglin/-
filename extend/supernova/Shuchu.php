<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
namespace supernova;
class Shuchu
{
    public function __call ($name, $args)
    {
        if($name=='json')
        {
            $i=count($args);
            if (method_exists($this,$f='json'.$i)) {
               return call_user_func_array(array($this,$f),$args);
            }
        }
    }

    public function json1($data=[])
    {
        $res = [
            'code' => 200,
            'msg' => 'success',
            'data' => $data
        ];
        return json($res);
    }

    public function json2($code=200, $msg='success', $data=[])
    {
        $res = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        return json($res);
    }
}