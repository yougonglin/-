<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */

use think\facade\Route;

Route::group('mall', function () {
    Route::post('goods_save','shop.MallController/goods_save');
    Route::post('goods_del','shop.MallController/goods_del');
    Route::post('goods_deliver','shop.MallController/goods_deliver');
    Route::get('goods_deliver_list','shop.MallController/goods_deliver_list');
    Route::post('classification_creation','shop.MallController/classification_creation');
    Route::post('get_category','shop.MallController/get_category');
    Route::post('goods_deliver_refund','shop.MallController/goods_deliver_refund');
    Route::post('goods_deliver_by_id','shop.MallController/goods_deliver_by_id');
})->middleware(\app\admin\middleware\Auth::class);