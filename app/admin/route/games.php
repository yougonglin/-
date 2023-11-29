<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
use think\facade\Route;
Route::group('blind_box', function () {
    Route::post('save','games.BlindBoxController/save');
    Route::post('del','games.BlindBoxController/del');
    Route::post('goods_add','games.BlindBoxController/goods_add');
    Route::post('goods_get','games.BlindBoxController/goods_get');
    Route::post('goods_get_id','games.BlindBoxController/goods_get_id');
    Route::post('goods_del','games.BlindBoxController/goods_del');

})->middleware(\app\admin\middleware\Auth::class);