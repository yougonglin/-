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
    Route::get('goods_list','shop.MallController/goods_list');
    Route::get('goods_details','shop.MallController/goods_details');
    Route::get('get_category_all','shop.MallController/get_category_all');
});

Route::group('subsidy', function () {
    Route::post('kuaishou_search','shop.SubsidyController/kuaishou_search');
    Route::get('get_kuaishou_code_token','shop.SubsidyController/get_kuaishou_code_token');
    Route::post('douyin_huitiao','shop.SubsidyController/douyin_huitiao');
    // 抖音商品搜索
    Route::post('douyin_search','shop.SubsidyController/douyin_search');
    //抖客token
    Route::get('get_douyin_code_token','shop.SubsidyController/get_douyin_code_token');
    //自动录入快手订单
    Route::get('kuaishou_enter_order','shop.SubsidyController/kuaishou_enter_order');
    //手动录入订单
    Route::post('entry_order','shop.SubsidyController/entry_order');
    //手动录入抖音订单
    Route::post('douyin_entry_order','shop.SubsidyController/douyin_entry_order');
    //创建快手分销链接
    Route::post('kuaishou_build_link_pass','shop.SubsidyController/kuaishou_build_link_pass');
    //抖客推广链接创建
    Route::post('douyin_build_link_pass','shop.SubsidyController/douyin_build_link_pass');
});

Route::group('subsidy', function () {
    //获取订单
    Route::post('get_order','shop.SubsidyController/get_order');
    //领取返利
    Route::get('receive_jinbi','shop.SubsidyController/receive_jinbi');
    //创建快手分销链接
    Route::post('kuaishou_build_link','shop.SubsidyController/kuaishou_build_link');
    //抖客推广链接创建
    Route::post('douyin_build_link','shop.SubsidyController/douyin_build_link');
})->middleware(\app\app\middleware\Auth::class);