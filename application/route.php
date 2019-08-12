<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::post('index', 'index/Index/index');

//******************* 内部接口 ***********************//
Route::group('api', function () {
    Route::group('goods', function () {
        Route::post('saveUploadGoods', 'index/Goods/saveUploadGoods');//批量添加商品
    });
    Route::group('code', function () {
        Route::post('saveUploadCode', 'index/PreferenceCode/saveUploadCode');//批量添加优惠码
        Route::post('getCode','index/PreferenceCode/getCode');//获取优惠码
        Route::get('findRandomCode', 'index/PreferenceCode/findRandomCode');
    });
    Route::group('codeRecord', function () {
        Route::get('saveCodeRecord', 'index/DiscountCodeRecording/saveCodeRecord');
    });
    Route::group('setMeal', function () {
        Route::post('saveSetMeal', 'index/SetMeal/saveSetMeal');//添加套餐
        Route::get('findOneMeal', 'index/SetMeal/findOneMeal');
    });
});

