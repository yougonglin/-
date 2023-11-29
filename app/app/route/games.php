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
    Route::get('get','games.BlindBoxController/blind_box_get');
    Route::get('detail','games.BlindBoxController/blind_box_detail');
});

Route::group('blind_box', function () {
    Route::post('create_order','games.BlindBoxController/create_order');
    Route::post('recovery','games.BlindBoxController/blind_box_recovery');
    Route::post('status_list','games.BlindBoxController/blind_box_status_list');
    Route::post('try','games.BlindBoxController/blind_box_try');
})->middleware(\app\app\middleware\Auth::class);


Route::group('lottery', function () {
    Route::get('get_point','games.LotteryController/get_point');
    Route::get('settle_accounts_point','games.LotteryController/settle_accounts_point');
});

Route::group('lottery', function () {
    Route::post('build_point','games.LotteryController/build_point');
    Route::get('get_point_log','games.LotteryController/get_point_log');

})->middleware(\app\app\middleware\Auth::class);