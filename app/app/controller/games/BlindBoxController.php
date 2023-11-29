<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\app\controller\games;
use \supernova\Shuchu;
use app\app\model\games\BlindBoxListModel;
use app\app\model\games\BlindBoxGoodsListModel;
use app\app\model\games\BlindBoxOrderModel;
use app\app\model\games\BlindBoxWinningRecordModel;
use app\app\model\user\UserModel;
use app\app\model\user\YueLog;
use app\app\model\shop\GoodsModel;
use think\facade\Db;

class BlindBoxController
{
    /**
     * @description: 盲盒列表获取
     */    
    public function blind_box_get(BlindBoxListModel $BlindBoxListModel,Shuchu $Shuchu)
    {
        $result = $BlindBoxListModel->page((int) input('get.page'),30)->select();
        return $Shuchu->json($result);
    }

    /**
     * @description: 盲盒详情
     */    
    public function blind_box_detail(BlindBoxGoodsListModel $BlindBoxGoodsListModel,BlindBoxListModel $BlindBoxListModel,Shuchu $Shuchu)
    {
        $result['list'] = $BlindBoxGoodsListModel->field('a.id,image,goods_name,price,probability,a.type,a.product_id')->alias('a')->join('goods w','a.product_id = w.id')->where('blind_box_id',input('get.id'))->order('probability', 'asc')->select();
        $result['manghe'] = $BlindBoxListModel->where('id',input('get.id'))->find();//取出盲盒基本信息
        return $Shuchu->json($result);
    }

    /**
     * @description: 创建盲盒订单
     */    
    public function create_order(UserModel $UserModel,BlindBoxListModel $BlindBoxListModel,BlindBoxOrderModel $BlindBoxOrderModel,BlindBoxGoodsListModel $BlindBoxGoodsListModel,BlindBoxWinningRecordModel $BlindBoxWinningRecordModel,GoodsModel $GoodsModel,YueLog $YueLog,Shuchu $Shuchu)
    {
        $uid = request()->userInfo->uid;
        $price =  bcmul($BlindBoxListModel->where('id',input('post.id'))->value('price'),(string) input('post.nums'),2);
        Db::startTrans();
        try {
            //扣除余额
            $UserModel->where('uid',$uid)->dec('yue_num',(float) $price)->update();
            //余额记录
            $YueLog->save([
                'uid' => $uid,
                'num' => $price,
                'type' => 2,
                'mark' => '余额抽取盲盒'
            ]);
            //开箱记录
            $BlindBoxOrderModel->save(array(
                'user_id' => $uid,
                'blind_box_id' => input('post.id'),
                'nums' => input('post.nums')
            ));
            //开箱
            //获取盲盒商品，中奖概率大的放在前面
            $result = $BlindBoxGoodsListModel->where('blind_box_id',input('post.id'))->order('probability', 'desc')->select()->toArray();
            $tmp = [];$goods = [];
            for ($i=0; $i < input('post.nums'); $i++) { 
                $one = $this->get_one($result);
                $tmp[$i]['product_id'] = $one['product_id'];
                $tmp[$i]['user_id'] = $uid;
                $tmp[$i]['blind_box_id'] = input('post.id');
                $goods[$i] = $GoodsModel->field('image')->where('id',$tmp[$i]['product_id'])->find();
                $goods[$i]['type'] = $one['type'];
            }
            //写入中奖记录
            $BlindBoxWinningRecordModel->saveAll($tmp);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            $goods = false;
            // 回滚事务
            Db::rollback();
        }
        return $Shuchu->json($goods);
    }

    /**
     * @description: 盲盒回收
     */    
    public function blind_box_recovery(UserModel $UserModel,BlindBoxWinningRecordModel $BlindBoxWinningRecordMode,YueLog $YueLog,Shuchu $Shuchu)
    {
        $uid = request()->userInfo->uid;
        Db::startTrans();
        try {
            //取出回收价格
            $result = $BlindBoxWinningRecordMode->field('price')->alias('a')->join('goods w','a.product_id = w.id')->where('a.id','in',input('post.ids'))->where('a.user_id',$uid)->where('a.status',1)->column('price');
            //修改盲盒状态为回收
            $BlindBoxWinningRecordMode->where('id','in',input('post.ids'))->where('user_id',$uid)->update(['status' => 2]);
            $price = intval(array_sum($result) / 10);
            //增加余额
            $UserModel->where('uid',$uid)->inc('yue_num',$price)->update();
            //余额记录
            $YueLog->save([
                'uid' => $uid,
                'num' => $price,
                'type' => 1,
                'mark' => '盲盒回收'
            ]);
            $result = "成功回收,返还余额：{$price}元";
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            $result = '盲盒回收失败!';
            // 回滚事务
            Db::rollback();
        }
        return $Shuchu->json($result);
    }

    /**
     * @description: 盲盒状态列表
     */    
    public function blind_box_status_list(BlindBoxWinningRecordModel $BlindBoxWinningRecordModel,Shuchu $Shuchu)
    {
        $uid = request()->userInfo->uid;
        $result = $BlindBoxWinningRecordModel->field('a.id,image,goods_name,price,a.product_id,create_time')->alias('a')->join('goods w','a.product_id = w.id')->where('user_id',$uid)->where('status',input('post.status'))->page((int) input('post.page'),30)->order('a.id', 'desc')->select();
        return $Shuchu->json($result);
    }

    /**
     * @description: 盲盒试玩
     */    
    public function blind_box_try(BlindBoxGoodsListModel $BlindBoxGoodsListModel,GoodsModel $GoodsModel,Shuchu $Shuchu)
    {
        //获取盲盒商品
        $goods = $BlindBoxGoodsListModel->where('blind_box_id',input('post.id'))->order('probability', 'desc')->select()->toArray();
        $tmp = [];$notice = [];$total=count($goods);
        foreach ($goods as $key => $value) {
            $randNumber = mt_rand(1,$total);
            if ($randNumber == 1) {
                $notice = $value;
                break;
            } else {
                $total -= 1;
            }
        }
        $goods[0] = $GoodsModel->field('image')->where('id',$notice['product_id'])->find();
        $goods[0]['type'] = $notice['type'];
        return $Shuchu->json($goods);
    }

     /**
     * @description: 盲盒开一个数据
     * @param {*} $goods
     * @return {*}
     */    
    public function get_one($goods)
    {
        $total = 0;$notice;
        foreach ($goods as &$item) {
            $item['probability'] = round($item['probability'], 2) * 100; // 扩大100倍避免小数
            $total = $total + intval($item['probability']);
        }
        foreach ($goods as $key => $value) {
            $randNumber = mt_rand(1,intval($total));
            //中奖率越高的先抽取
            if ($randNumber <= $value['probability']) {
                $notice = $value;
                break;
            } else {
                $total -= $value['probability'];
            }
        }

        return $notice;
    }
}
