<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */

use think\facade\Route;

Route::group('article', function () {
    //发帖
    Route::post('publish','star.ArticleController/publish');
    //新增评论
    Route::post('comment_add','star.ArticleController/comment_add');
    //附件购买
    Route::post('buy_file','star.ArticleController/buy_file');
    //删除帖子/评论
    Route::post('del','star.ArticleController/del');

})->middleware(\app\app\middleware\Auth::class);

Route::group('article', function () {
    //帖子列表
    Route::get('list','star.ArticleController/list');
    //帖子详情
    Route::get('details','star.ArticleController/details');
    //获取评论
    Route::get('comment_get','star.ArticleController/comment_get');
});

Route::group('socialize', function () {
    //保存资料
    Route::post('profile_save','star.SocializeController/profile_save');
    //查找用户
    Route::any('search','star.SocializeController/search');
    //获取联系方式
    Route::get('get_phone','star.SocializeController/get_phone');
    //获取联系方式
    Route::get('get_phone_free','star.SocializeController/get_phone_free');
    //保存资料
    Route::post('profile_save_free','star.SocializeController/profile_save_free');
})->middleware(\app\app\middleware\Auth::class);

Route::group('socialize', function () {
    //资料获取
    Route::get('profile_get','star.SocializeController/profile_get');
    //获取最新用户列表
    Route::get('get_user_list','star.SocializeController/get_user_list');
});