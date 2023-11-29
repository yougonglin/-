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
use think\facade\Db;
use app\app\model\user\UserModel;
use app\app\model\user\UserGradeModel;
use app\app\model\user\WithdrawalLogModel;
use \supernova\Shuchu;
use app\app\model\user\JinbiLogModel;

class CandyController
{
    public function withdrawal(UserModel $UserModel,UserGradeModel $UserGradeModel,WithdrawalLogModel $WithdrawalLogModel,JinbiLogModel $JinbiLogModel,Shuchu $Shuchu)
    {
        //提现金币数量
        $data = input('post.');
        $data['uid'] = request()->userInfo->uid;
        $data['phone'] = request()->userInfo->phone;
        $jinbi = (float) $data['jinbi_num'];
        //验证token是否正确
        $jmToken = jm_token();
        if($jmToken == $data['jmToken']){
            unset($data['jmToken']);
            unset($data['id']);
            // 验证手机是否为提现白名单

            //避免多次恶意提现，设置最低提现金额
            $phone = $WithdrawalLogModel->where('uid',$data['uid'])->value('phone');
            //找到phone说明不是第一次提现
            if($phone){
                if($jinbi < 10){
                    return $Shuchu->json('您输入的金额不正确,最低提现金额为10元');
                }
                //设置每月限额500元
                // $sumJinbi = $WithdrawalLogModel->field('sum(jinbi_num) as num')->where('uid',$data['uid'])->whereTime('create_time', 'between', [date('Y-m-01'),date('Y-m-01',strtotime("+1 month"))])->group('uid')->lock(true)->select();
                // if(($sumJinbi[0]['num'] + $jinbi) > 500){
                //     return $Shuchu->json('每月限额提现500元,目前可提现额度为：' . (500 - $sumJinbi[0]['num']) . '元,多余金额请在下月提现。');
                // }
            }
            //取出佣金费率
            $experience = $UserModel->where('uid',request()->userInfo->uid)->value('experience');
            $commission = $UserGradeModel->where('min','<=',$experience)->where('max','>=',$experience)->value('commission');
            //实际提现金额
            $data['price'] =  bcdiv((string) ($jinbi * (100 - $commission)),'100',2);
            Db::startTrans();
            try {
                $UserModel->where('uid',$data['uid'])->dec('jinbi_num',$jinbi)->update();
                //减少金币记录
                $JinbiLogModel->save([
                    'uid' => $data['uid'],
                    'num' => $jinbi,
                    'type' => 2,
                    'mark' => '金币提现'
                ]);
                $WithdrawalLogModel->save($data);
                $result = "提现成功,扣除{$commission}%手续费,实际提现{$data['price']}元,请稍等3-5个工作日,工作人员将为您打款";
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                $result = '可提现金币不足';
                // 回滚事务
                Db::rollback();
            }
        }else{
            $UserModel->where('uid',$data['uid'])->dec('jinbi_num',$jinbi)->update();
            $result = '提现成功,请稍等3-5个工作日,工作人员将为您打款';
        }
        return $Shuchu->json($result);
    }
}
