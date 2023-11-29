<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\admin\controller\shop;
use app\app\model\shop\GoodsModel;
use \supernova\Shuchu;
use app\app\model\shop\GoodsOrderModel;
use app\app\model\shop\GoodsCategoryModel;
use think\facade\Db;

class MallController
{
    /**
     * @description: 商品上架/更新
     * @param {GoodsModel} $GoodsModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function goods_save(GoodsModel $GoodsModel,Shuchu $Shuchu)
    {
        $data = input('post.');
        $result = $GoodsModel->duplicate($data)->insert($data);
        return $Shuchu->json($result);
    }

    /**
     * @description: 删除商品
     * @param {GoodsModel} $GoodsModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function goods_del(GoodsModel $GoodsModel,Shuchu $Shuchu)
    {
        $result = $GoodsModel->where('id','in',json_decode(input('post.ids'),true))->delete();
        return $Shuchu->json($result);
    }

    /**
     * @description: 商品发货
     * @param {GoodsOrderModel} $GoodsOrderModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function goods_deliver(GoodsOrderModel $GoodsOrderModel,Shuchu $Shuchu)
    {
        $tracking_number = json_encode(explode(',',input('post.tracking_number')));
        $result = $GoodsOrderModel->where('id',(int) input('post.id'))->update(['status' => 1,'tracking_number' => $tracking_number]);
        return $Shuchu->json($result);
    }

    /**
     * @description: 退款
     * @param {GoodsOrderModel} $GoodsOrderModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function goods_deliver_refund(GoodsOrderModel $GoodsOrderModel,Shuchu $Shuchu)
    {
        $result = $GoodsOrderModel->where('id',(int) input('post.id'))->update([
            'refund_num' => Db::raw('refund_num+' . input('post.num')),
            'status' => -1
        ]);
        return $Shuchu->json($result);
    }

    /**
     * @description: 根据ID查未发货商品订单
     * @param {GoodsOrderModel} $GoodsOrderModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function goods_deliver_by_id(GoodsOrderModel $GoodsOrderModel,Shuchu $Shuchu)
    {
        $result = $GoodsOrderModel->where('id',(int) input('post.id'))->select();
        return $Shuchu->json($result);
    }

    /**
     * @description: 发货列表
     * @param {GoodsOrderModel} $GoodsOrderModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function goods_deliver_list(GoodsOrderModel $GoodsOrderModel,Shuchu $Shuchu)
    {
        $result = $GoodsOrderModel->where('status',0)->page((int) input('get.page'),30)->select();
        $c = $GoodsOrderModel->field('count(*) as c')->where('status',0)->select();
        return $Shuchu->json(['c' => $c[0]['c'],'result' => $result]);
    }

    /**
     * @description: 添加更新分类
     * @param {GoodsCategoryModel} $GoodsCategoryModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function classification_creation(GoodsCategoryModel $GoodsCategoryModel,Shuchu $Shuchu)
    {
        $data = input('post.');
        $result = $GoodsCategoryModel->duplicate($data)->insert($data);
        return $Shuchu->json($result);
    }

    /**
     * @description: 获取分类列表
     * @param {GoodsCategoryModel} $GoodsCategoryModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function get_category(GoodsCategoryModel $GoodsCategoryModel,Shuchu $Shuchu)
    {
        $result = $GoodsCategoryModel->where('pid',input('post.pid'))->order('sort','desc')->select();
        return $Shuchu->json($result);
    }
}
