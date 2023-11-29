<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */

use think\facade\Route;

Route::group('bonus', function () {
    Route::post('get_task','activity.BonusController/get_task');
    Route::post('countersign','activity.BonusController/countersign');
    Route::get('close_order','activity.BonusController/close_order');
    Route::post('sign','activity.BonusController/sign');
    Route::get('build_order','activity.BonusController/build_order');
    Route::get('get_order','activity.BonusController/get_order');
})->middleware(\app\app\middleware\Auth::class);