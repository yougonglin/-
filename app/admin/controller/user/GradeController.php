<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\admin\controller\user;
use \supernova\Shuchu;
use app\app\model\user\UserGradeModel;
class GradeController
{
    /**
     * @description: 等级新增/更新
     * @param {GradeModel} $GradeModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function grade_save(UserGradeModel $GradeModel,Shuchu $Shuchu)
    {
        $data = input('post.');
        $result = $GradeModel->duplicate($data)->insert($data);
        return $Shuchu->json($result);
    }

    /**
     * @description: 等级列表
     * @param {GradeModel} $GradeModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function grade_list(UserGradeModel $GradeModel,Shuchu $Shuchu)
    {
        $result = $GradeModel->select();
        return $Shuchu->json($result);
    }
}
