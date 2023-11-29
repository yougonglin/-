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
use app\app\model\user\WithdrawalLogModel;
use app\app\model\user\UserModel;
use app\app\model\user\JinbiLogModel;
use think\facade\Db;

class CandyController
{
    /**
     * @description: 更新提现状态
     * @param {WithdrawalLogModel} $WithdrawalLogModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function update(WithdrawalLogModel $WithdrawalLogModel,UserModel $UserModel,JinbiLogModel $JinbiLogModel,Shuchu $Shuchu)
    {
        Db::startTrans();
        try {
            $result = $WithdrawalLogModel->where('id',input('post.id'))->update([
                'mark' => input('post.mark'),
                'status' => input('post.status')
            ]);
            //如果拒绝提现，返还金币并写入记录
            if(input('post.status') == -1){
                $UserModel->where('uid',input('post.uid'))->inc('jinbi_num',(float) input('post.num'))->update();
                //增加金币记录
                $JinbiLogModel->save([
                    'uid' => input('post.uid'),
                    'num' => input('post.num'),
                    'type' => 1,
                    'mark' => '提现被拒返还'
                ]);
            }else{
                //提现成功给上级增加金币
                $invite_uid = $UserModel->where('uid',input('post.uid'))->value('invite_uid');
                if($invite_uid != 0){
                    $ticheng = bcsub(input('post.num'),input('post.price'),2);
                    $ticheng = bcmul(0.5,$ticheng,2);
                    $UserModel->where('uid',$invite_uid)->inc('jinbi_num',(float) $ticheng)->update();
                    //增加金币说明
                    $JinbiLogModel->save([
                        'uid' => $invite_uid,
                        'num' => $ticheng,
                        'type' => 1,
                        'mark' => '下级提现获得奖励'
                    ]);
                }
            }
            $result = '操作成功';
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            $result = '操作失败';
            // 回滚事务
            Db::rollback();
        }
        return $Shuchu->json($result);
    }

    /**
     * @description: 提现列表
     * @param {WithdrawalLogModel} $WithdrawalLogModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function list(WithdrawalLogModel $WithdrawalLogModel,Shuchu $Shuchu)
    {
        $result = $WithdrawalLogModel->where('status',input('post.status'))->page((int) input('post.page'),30)->select();
        $c = $WithdrawalLogModel->field('count(*) as c')->where('status',0)->select();
        return $Shuchu->json(['c' => $c[0]['c'],'result' => $result]);
    }
}
