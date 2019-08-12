<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/7/17
 * Time: 21:56
 */

namespace app\index\model;


use think\Model;

class IndexModel extends Model
{
//-------------------------------　实例创建通知接口　---------------------------------

    /**
     * 添加订单信息
     * @param $data
     * @return int|string
     */
    function saveOrderInfo($data)
    {
        $result = self::table('ims_createInstance')->insert($data);
        return $result;
    }

    /**
     * 创建服务商用户信息
     * @param $userName
     * @param $userPass
     * @param $remark   备注
     * @param $endtime  到期时间
     * @return int|string
     */
    function saveUser($userName, $userPass, $remark, $endtime)
    {
        $salt = getRandChar(8);
        $key = "db5597db";
        $userPass = $userPass . "-" . $salt . "-" . $key;
        $data = array(
            'owner_uid' => 0,
            'groupid' => 7,
            'founder_groupid' => 0,
            'username' => $userName,
            'password' => sha1($userPass),
            'salt' => $salt,
            'type' => 1,
            'status' => 2,
            'joindate' => time(),
            'joinip' => '127.0.0.1',
            'lastvisit' => time(),
            'lastip' => '127.0.0.1',
            'remark' => $remark,
            'starttime' => 0,
            'endtime' => $endtime,
            'register_type' => 0,
            'openid' => "",
            'welcome_link' => 0,
            'is_bind' => 0,
            'notice_setting' => "",
        );
        $result = self::table('ims_users')->insert($data);
        return $result;
    }
//-------------------------------　END　---------------------------------

//-------------------------------　实例续费通知接口　---------------------------------
    function updateUserEndTime($signId, $time)
    {
        $order = self::table('ims_createInstance')->where('signId', $signId)->find();
        $username = $order['userName'];
        $result = self::table('ims_users')->where('username', $username)->update(['endtime' => $time]);
        return $result;
    }
//-------------------------------　END　---------------------------------

//-------------------------------　实例配置变更通知接口　---------------------------------
    function updateUserRemarkEndTime($signId, $spec, $time)
    {
        $order = self::table('ims_createInstance')->where('signId', $signId)->find();
        $username = $order['userName'];
        $user = self::table('ims_users')->where('username', $username)->find();
        $remark = $user['remark'];
        $strarray = explode("-", $remark);
        $remark = $strarray[0] . '-' . $spec;
        $result = self::table('ims_users')->where('username', $username)->update(['endtime' => $time, 'remark' => $remark]);
        return $result;
    }
//-------------------------------　END　---------------------------------

//-------------------------------　实例过期通知接口　---------------------------------

//-------------------------------　END　---------------------------------

//-------------------------------　实例销毁通知接口　---------------------------------

//-------------------------------　END　---------------------------------
}