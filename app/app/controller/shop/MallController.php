<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\app\controller\shop;
use app\app\model\shop\GoodsModel;
use \supernova\Shuchu;
use app\app\model\shop\GoodsCategoryModel;

class MallController
{
    
    /**
     * @description: 商品列表
     * @param {GoodsModel} $GoodsModel
     * @return {*}
     */    
    public function goods_list(GoodsModel $GoodsModel,Shuchu $Shuchu)
    {
        $page = input('get.page');
        $result = $GoodsModel->field('id,image,goods_name,price')->where('cate_id',input('get.cate_id'))->page((integer) $page,30)->order('id','desc')->select();
        $c = $GoodsModel->field('count(*) as c')->where('cate_id',input('get.cate_id'))->select();
        return $Shuchu->json(['c' => $c[0]['c'],'result' => $result]);
    }

    /**
     * @description: 获取商品详情
     * @param {GoodsModel} $GoodsModel
     * @return {*}
     */    
    public function goods_details(GoodsModel $GoodsModel,Shuchu $Shuchu)
    {
        $id = input('get.id');
        $result = $GoodsModel->where('id',$id)->find();
        return $Shuchu->json($result);
    }

    /**
     * @description: 获取分类
     * @param {GoodsCategoryModel} $GoodsCategoryModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function get_category_all(GoodsCategoryModel $GoodsCategoryModel,Shuchu $Shuchu)
    {
        $result = $GoodsCategoryModel->order('sort','desc')->select();
        return $Shuchu->json($result);
    }
}
