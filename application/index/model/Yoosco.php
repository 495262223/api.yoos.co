<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/8/8
 * Time: 23:22
 */

namespace app\index\model;


use think\Model;

class Yoosco extends Model
{
    protected $connection = [
        // 数据库类型
        'type' => 'mysql',
        // 服务器地址
        'hostname' => '127.0.0.1',
        // 数据库名
        'database' => 'yoosco',
        // 数据库用户名
        'username' => 'root',
        // 数据库密码
        'password' => 'root',
        // 数据库编码默认采用utf8
        'charset' => 'utf8'
    ];

    //套餐列表**********************************************************************************************************

    /**
     * 添加套餐列表
     * @param $data
     * @return int|string
     */
    function saveSetMeal($data)
    {
        $result = self::table('setmeal')->insert($data);
        return $result;
    }

    /**
     * 根据套餐名查询套餐
     * @param $setmeal_name
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function findOneMeal($setmeal_name)
    {
        $data = self::table('setmeal')->where('setmeal_name', $setmeal_name)->find();
        return $data;
    }

    //END***************************************************************************************************************

    //优惠码领取记录****************************************************************************************************

    /**
     * 添加优惠码领取记录
     * @param $data
     * @return int|string
     */
    function saveCodeRecord($data)
    {
        $result = self::table('discountcoderecording')->insert($data);
        return $result;
    }

    //END***************************************************************************************************************

    //商品列表***********************************************************************************************************

    /**
     * 批量添加商品信息
     * @param $data
     * @return int|string
     */
    function saveUploadGoods($data)
    {
        $result = self::table('goods')->insertAll($data);
        return $result;
    }

    /**
     * 查询单个商品信息
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function findOneGood($good_id)
    {
        $data = self::table('goods')->where('good_id', $good_id)->find();
        return $data;
    }

    //END***************************************************************************************************************

    //优惠码列表********************************************************************************************************
    /**
     * 批量添加优惠码
     * @param $data
     * @return int|string
     */
    function saveUploadCode($data)
    {
        $result = self::table('preferencecode')->insertAll($data);
        return $result;
    }

    /**
     * 随机查询一条可用的优惠码
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function findRandomCode($money)
    {
        $data = self::table('preferencecode')->where(['PreferentialMode' => $money, 'state' => '可用'])->orderRaw('rand()')->find();
        return $data;
    }

    /**
     * 修改优惠码状态
     * @param $id
     * @return Yoosco
     */
    function updateCodeStart($id)
    {
        $result = self::table('preferencecode')->where(['Id' => $id])->update(['state' => '已使用']);
        return $result;
    }

    //END***************************************************************************************************************

}