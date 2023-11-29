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
use app\app\model\user\AddressModel;
use app\app\model\user\UserModel;
use app\app\model\shop\GoodsOrderModel;
use think\facade\Db;
use \supernova\Shuchu;
use app\app\model\shop\GoodsModel;
use app\app\model\user\YueLog;
use app\app\model\games\BlindBoxWinningRecordModel;
use think\facade\Request;

class AddressController
{
    /**
     * @description: 更新保存地址
     * @param {AddressModel} $model
     * @return {*}
     */     
    public function save(AddressModel $model,Shuchu $Shuchu)
    {
        $data = Request::post(['name','phone','address']);
        $data['uid'] = request()->userInfo->uid;
        if(Request::has('id','post')){
            $result = $model->where('id',Request::post('id'))->update($data);
        }else{
            $result = $model->insert($data);
        }
        return $Shuchu->json($result);
    }

    /**
     * @description: 获取地址列表
     * @param {AddressModel} $model
     * @return {*}
     */    
    public function get(AddressModel $model,Shuchu $Shuchu)
    {
        $result = $model->withoutField('uid')->where('uid',request()->userInfo->uid)->order('id','desc')->select();
        return $Shuchu->json($result);
    }

    /**
     * @description: 删除地址
     * @param {AddressModel} $model
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function del(AddressModel $model,Shuchu $Shuchu)
    {
        $result = $model->where('uid',request()->userInfo->uid)->where('id',input('post.id'))->delete();
        return $Shuchu->json($result);
    }

    /**
     * 有BUG，如果传递过长的数组就被攻击死循环
     * @description: 支付并邮寄
     * @param {UserModel} $UserModel
     * @param {GoodsOrderModel} $GoodsOrderModel
     * @return {*}
     */    
    public function pay(UserModel $UserModel,GoodsModel $GoodsModel,GoodsOrderModel $GoodsOrderModel,BlindBoxWinningRecordModel $BlindBoxWinningRecordModel,Shuchu $Shuchu,YueLog $YueLog)
    {
        $uid = request()->userInfo->uid;
        $data = Request::post();
        //限制传入数组数量，避免恶意攻击
        if(count(array_count_values(json_decode($data['id'],true))) > 50){
            $result = '每次最多提交50个商品,请减少商品数量后重试';
        }else{
            //实操
            if($data['type'] == 'mall'){
                $ids = json_decode($data['id'],true);
            }else{
                //取出发货商品ID
                $ids = $BlindBoxWinningRecordModel->where('user_id',$uid)->where('id','in',json_decode($data['id'],true))->where('status',1)->column('product_id');
                if(count($ids) > 0){
                    //盲盒发货更改状态
                    $BlindBoxWinningRecordModel->where('user_id',$uid)->where('id','in',json_decode($data['id'],true))->update(['status' => 3]);
                }else{
                    return $Shuchu->json('订单已提交过');
                }
            }
            $goodsList = $GoodsModel->where('id','in',$ids)->order('id','aes')->select()->toArray();
            Db::startTrans();
            try {
                //添加商品购买信息
                $orderGoods = $this->get_order_goods_arr($ids,$goodsList);
                //计算总价
                $price = $data['type'] == 'mall' ? $orderGoods[1] : 30;
                //减少余额
                $UserModel->where('uid',$uid)->update([
                    'yue_num' => Db::raw('yue_num-' . $price)
                ]);
                //删除id列，因为订单表id冲突
                unset($data['id']);
                unset($data['type']);
                $GoodsOrderModel->save([
                    ...$data,
                    'uid' => $uid,
                    'order_goods' => json_encode($orderGoods[0]),
                    'num' => $price
                ]);
                //余额记录
                $YueLog->save([
                    'uid' => $uid,
                    'num' => $price,
                    'type' => 2,
                    'mark' => '购买商品以及运费'
                ]);
                $result = '订单提交成功';
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                $result = '可用余额不足';
                // 回滚事务
                Db::rollback();
            }
        }
        return $Shuchu->json($result);
    }

    /**
     * @description:  获取订单商品综合数组
     * @param {*} $ids
     * @param {*} $goodsList
     * @return {*}
     */    
    public function get_order_goods_arr($ids,$goodsList)
    {
        $price = 0;
        //计算相同值出现的次数
        $idCount = array_count_values($ids);
        //升序排序对应商品排序
        ksort($idCount);
        $tmp = [];
        //一个有多少个商品
        for ($i=0; $i < count($goodsList); $i++) {
            //取出本商品的添加次数，并循环添加
            $goodsCount = $idCount[$goodsList[$i]['id']];
            //加入总金额
            $price = $price + ($goodsCount * $goodsList[$i]['price']);
            //取出图片
            $image = json_decode($goodsList[$i]['image'],true);
            $goodsList[$i]['image'] = $image[0];
            array_push($tmp,[
                ...$goodsList[$i],
                'num' => $goodsCount
            ]);
        }
        return array($tmp,$price);
    }
}
