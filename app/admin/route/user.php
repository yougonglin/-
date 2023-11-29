<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */

use think\facade\Route;
Route::group('grade', function () {
    // 等级新增/更新
    Route::post('grade_save','user.GradeController/grade_save');
    //等级列表
    Route::get('grade_list','user.GradeController/grade_list');
})->middleware(\app\admin\middleware\Auth::class);

Route::group('candy', function () {
    Route::post('list','user.CandyController/list');
    Route::post('update','user.CandyController/update');
})->middleware(\app\admin\middleware\Auth::class);

Route::group('info', function () {
    Route::post('integral_log','user.InfoController/integral_log');
    Route::post('userinfo','user.InfoController/userinfo');

})->middleware(\app\admin\middleware\Auth::class);

