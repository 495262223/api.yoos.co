<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function getJson($code, $message, $data)
{
    return ["code" => $code, "message" => $message, "data" => $data];
}

/**
 * 随机生成
 * @param $length
 * @return null|string
 */
function getRandChar($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";//大小写字母以及数字
    $max = strlen($strPol) - 1;

    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)];
    }
    return $str;
}

/**
 * 随机生成数字
 * @param $length
 * @return null|string
 */
function getRandNumber($length)
{
    $str = null;
    $strPol = "0123456789";
    $max = strlen($strPol) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)];
    }
    return $str;
}

/**
 * 服务信息说明
 * @return array
 */
function serviceInformation($userName, $userPass)
{
    return array(
        array(
            'name' => '官网地址',
            'value' => 'https://www.yoos.co'
        ),
        array(
            'name' => '提醒说明',
            'value' => '访问以下网址登录账号密码管理您购买的应用'
        ),
        array(
            'name' => '登录网址',
            'value' => 'https://www.yoos.co'
        ),
        array(
            'name' => '登录账号',
            'value' => $userName
        ),
        array(
            'name' => '登录密码',
            'value' => $userPass
        ),
        array(
            'name' => '使用说明',
            'value' => '购买后请联系有时云计算客服，获取操作指引。'
        ),
        array(
            'name' => '公众号',
            'value' => '有时云计算'
        ),
        array(
            'name' => '客服微信',
            'value' => 'bo9611'
        ),
        array(
            'name' => '服务热线',
            'value' => '027 - 59761610'
        )
    );
}