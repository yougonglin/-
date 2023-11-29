<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\app\model\star;

use think\Model;

/**
 * @mixin \think\Model
 */
class UserinfoModel extends Model
{
    protected $json = ['place','picture'];
    protected $jsonAssoc = true;
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'uid';

    /**
     * 模型名称
     * @var string
     */
    protected $name = 'userinfo';
}
