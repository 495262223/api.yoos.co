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
        'hostname' => '118.24.97.56',
        // 数据库名
        'database' => 'vo_yoos_co',
        // 数据库用户名
        'username' => 'vo_yoos_co',
        // 数据库密码
        'password' => '2crPEEjFYDb3HZD4',
        // 数据库编码默认采用utf8
        'charset' => 'utf8'
    ];

    //后台登录通知*******************************************************************************************************

    /**
     * 登录
     * @param $userName 账号
     * @param $userPass 密码
     * @return int|string
     */
    function LoginUser($userName, $userPass)
    {
        $result = self::table('user')->where(['userName' => $userName, 'userPass' => $userPass])->count();
        return $result;
    }

    //END***************************************************************************************************************

    //实例配置变更通知****************************************************************************************************

    function getModifyinstance($orderId)
    {
        $data = self::table('modifyinstance')->where('orderId', $orderId)->find();
        return $data;
    }

    function getModifyinstanceSignId($signId)
    {
        $data = self::table('modifyinstance')->where('signId', $signId)->find();
        return $data;
    }

    //END***************************************************************************************************************

    //实例续费通知*******************************************************************************************************

    /**
     * 查询单条实例续费记录
     * @param $orderId
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getRenewinstance($orderId)
    {
        $data = self::table('renewinstance')->where('orderId', $orderId)->find();
        return $data;
    }

    //END***************************************************************************************************************

    //实例创建通知*******************************************************************************************************

    /**
     * 查询单条实例记录
     * @param $orderId  订单号
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function getCreateinstance($orderId)
    {
        $data = self::table('createinstance')->where('orderId', $orderId)->find();;
        return $data;
    }

    function getCreateinstanceSignId($signId)
    {
        $data = self::table('createinstance')->where('signId', $signId)->find();
        return $data;
    }

    //END***************************************************************************************************************

    //套餐列表***********************************************************************************************************

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
    function saveCodeRecord($orderId, $code)
    {
        $data = ["orderid" => $orderId, "code" => $code];
        $result = self::table('discountcoderecording')->insert($data);
        return $result;
    }

    /**
     * 订单号检查
     * @param $orderId
     * @return int|string
     */
    function findOneCodeRecord($orderId)
    {
        $count = self::table('discountcoderecording')->where('orderid', $orderId)->count();
        return $count;
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
     * 验证商品是否存在
     * @param $good_id
     * @return int|string
     */
    function VerificationGood($good_id)
    {
        $count = self::table('goods')->where('good_id', $good_id)->count();
        return $count;
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
     * 验证优惠码是否存在
     * @param $code
     * @return int|string
     */
    function VerificationCode($code)
    {
        $count = self::table('preferencecode')->where('code', $code)->count();
        return $count;
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