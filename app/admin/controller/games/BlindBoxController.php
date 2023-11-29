<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\admin\controller\games;
use app\app\model\games\BlindBoxListModel;
use app\app\model\games\BlindBoxGoodsListModel;
use \supernova\Shuchu;
class BlindBoxController
{
    /**
     * @description: 添加更新盲盒
     * @param {BlindBoxListModel} $BlindBoxListModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function save(BlindBoxListModel $BlindBoxListModel,Shuchu $Shuchu)
    {
        $data = input('post.');
        $result = $BlindBoxListModel->duplicate($data)->insert($data);
        return $Shuchu->json($result);
    }

    /**
     * @description: 删除盲盒
     * @param {BlindBoxListModel} $BlindBoxListModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function del(BlindBoxListModel $BlindBoxListModel,Shuchu $Shuchu)
    {
        $result = $BlindBoxListModel->where('id','in',input('post.ids'))->delete();
        return $Shuchu->json($result);
    }

    /**
     * @description: 盲盒内商品添加
     * @param {BlindBoxListModel} $BlindBoxListModel
     * @param {BlindBoxGoodsListModel} $BlindBoxGoodsListModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function goods_add(BlindBoxListModel $BlindBoxListModel,BlindBoxGoodsListModel $BlindBoxGoodsListModel,Shuchu $Shuchu)
    {
        $data = input('post.');
        //判断是否有自定义商品概率，有的话就直接设置
        if(isset($data['limit'])){
            $data['probability'] = $data['limit'];
        }else{
            $result = $BlindBoxListModel->field('normal,rare,legend,explosive')->where('id',$data['blind_box_id'])->find();
            switch ($data['type']) {
                case 1:
                    $data['probability'] = $result['normal'];
                    break;
                case 2:
                    $data['probability'] = $result['rare'];
                    break;
                case 3:
                    $data['probability'] = $result['legend'];
                    break;
                case 4:
                    $data['probability'] = $result['explosive'];
                    break;
                default:
                    # code...
                    break;
            }
        }
        unset($data['limit']);
        $result = $BlindBoxGoodsListModel->duplicate($data)->insert($data);
        return $Shuchu->json($result);
    }


    /**
     * @description: 盲盒商品列表
     * @param {BlindBoxGoodsListModel} $BlindBoxGoodsListModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function goods_get(BlindBoxGoodsListModel $BlindBoxGoodsListModel,Shuchu $Shuchu)
    {
        $data = input('post.');
        $list['data'] = $BlindBoxGoodsListModel->field('a.id,image,goods_name,price,probability,a.type,a.product_id')->alias('a')->join('goods w','a.product_id = w.id')->where('blind_box_id',$data['blind_box_id'])->page((int) $data['page'],30)->order('a.id', 'desc')->select();
        $list['total'] = $BlindBoxGoodsListModel->field('count(*) as total')->where('blind_box_id',$data['blind_box_id'])->select();
        return $Shuchu->json($list);
    }

    /**
     * @description: 获取单个盲盒内商品
     * @param {BlindBoxGoodsListModel} $BlindBoxGoodsListModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function goods_get_id(BlindBoxGoodsListModel $BlindBoxGoodsListModel,Shuchu $Shuchu)
    {
        $result = $BlindBoxGoodsListModel->field('a.id,image,goods_name,price,probability,a.type,a.product_id')->alias('a')->join('goods w','a.product_id = w.id')->where('a.id',input('post.id'))->find();
        return $Shuchu->json($result);
    }

    /**
     * @description: 删除盲盒内商品
     * @param {BlindBoxGoodsListModel} $BlindBoxGoodsListModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function goods_del(BlindBoxGoodsListModel $BlindBoxGoodsListModel,Shuchu $Shuchu)
    {
        $result = $BlindBoxGoodsListModel->where('id',input('post.id'))->delete();
        return $Shuchu->json($result);
    }
}
