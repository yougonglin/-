<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */

use think\facade\Route;
Route::post('login','user.LoginController/login');

Route::group('order', function () {
    // 获取商品订单
    Route::post('order_list','user.OrderController/order_list');
    //积分日志
    Route::post('integral_log','user.OrderController/integral_log');

})->middleware(\app\app\middleware\Auth::class);

Route::group('candy', function () {
    // 获取商品订单
    Route::post('withdrawal','user.CandyController/withdrawal');
})->middleware(\app\app\middleware\Auth::class);

Route::group('address', function () {
    // 用户地址
    Route::post('address_save','user.AddressController/save');
    // 获取地址列表
    Route::get('address_get','user.AddressController/get');
    // 删除地址
    Route::post('address_del','user.AddressController/del');
    // 支付并邮寄
    Route::post('address_pay','user.AddressController/pay');
})->middleware(\app\app\middleware\Auth::class);

Route::group('mine', function () {
    //个人中心
    Route::get('mine_userinfo','user.MineController/userInfo');
    // 注销账号
    Route::get('logout','user.MineController/logout');
    // 退出登录
    Route::get('user_exit','user.MineController/user_exit');
})->middleware(\app\app\middleware\Auth::class);

Route::group('vip', function () {
    // 会员等级列表
    Route::get('grade_list','user.VipController/grade_list');
    // 会员升级
    Route::post('vip_upgrade','user.VipController/upgrade');
    //提升用户等级
    Route::post('upgradation','user.VipController/upgradation');
})->middleware(\app\app\middleware\Auth::class);

Route::group('recharge', function () {
    //余额充值
    Route::any('balance','user.RechargeController/balance');
    //佣金导入
    Route::post('balance_jinbi','user.RechargeController/balance_jinbi');
})->middleware(\app\app\middleware\Auth::class);


Route::group('pay', function () {
    Route::post('notify_url','user.RechargeController/notify_url');
    Route::post('alipay_gateway','user.RechargeController/alipay_gateway');
    Route::post('alipay_callback','user.RechargeController/alipay_callback');

});

Route::group('invite', function () {
    Route::post('get_user','user.InviteController/get_user');
    Route::post('get_user_count','user.InviteController/get_user_count');
    Route::post('get_leaflet_uid','user.InviteController/get_leaflet_uid');
    Route::get('get_leafletUserList','user.InviteController/get_leafletUserList');
});

Route::group('invite', function () {
    Route::post('save_leaflet_user','user.InviteController/save_leaflet_user');
})->middleware(\app\app\middleware\Auth::class);


