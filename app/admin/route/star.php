<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
use think\facade\Route;
Route::group('socialize', function () {
    //审核用户
    Route::post('profile_pass','star.SocializeController/profile_pass');
    //获取需要审核的用户
    Route::get('profile_pass_get','star.SocializeController/profile_pass_get');
})->middleware(\app\admin\middleware\Auth::class);