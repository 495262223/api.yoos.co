<?php

namespace app\index\controller;

use app\index\model\IndexModel;
use app\index\model\Yoosco;
use think\Request;

class Index
{

    private $token = null;
    private $model = null;
    private $yoosco = null;

    public function __construct()
    {
        $this->token = "12345678987654321";
        $this->model = new IndexModel();
        $this->yoosco = new Yoosco();
    }

    function index(Request $request)
    {
        $signature = $request->get('signature');
        $timestamp = $request->get('timestamp');
        $eventId = $request->get('eventId');
        $action = $request->post('action');
        $echoback = $request->post('echoback');
        if ($this->checkSignature($signature, $this->token, $timestamp, $eventId)) {
            switch ($action) {
                case 'verifyInterface':
                    return $this->verifyInterface($echoback);
                    break;
                case 'createInstance':
                    return $this->createInstance($request);
                    break;
                case 'renewInstance':
                    return $this->renewInstance($request);
                    break;
                case 'modifyInstance':
                    return $this->modifyInstance($request);
                    break;
                case 'expireInstance':
                    return $this->expireInstance();
                    break;
                case 'destroyInstance':
                    return $this->destroyInstance($request);
                    break;
            }
        }
    }

    /**
     * 实例销毁通知接口
     */
    function destroyInstance($request)
    {
        $orderId = $request->post('orderId');//订单ID
        $accountId = $request->post('accountId');//客户在腾讯云的账号ID
        $openId = $request->post('openId');//客户的识别(若未接入开放平台,则为空)
        $productId = $request->post('productId');//云市场产品ID
        $requestId = $request->post('requestId');//接口请求的ID
        $signId = $request->post('signId');//实例标识Id
        $result = $this->model->updateUserEndTime($signId, strtotime('-1 day'));
        if ($result) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }

    /**
     * 实例过期通知接口
     * @return array
     */
    function expireInstance()
    {
        return ['success' => true];
    }

    /**
     * 实例配置变更通知接口
     * @return array
     */
    function modifyInstance($request)
    {
        $orderId = $request->post('orderId');//订单ID
        $accountId = $request->post('accountId');//客户在腾讯云的账号ID
        $openId = $request->post('openId');//客户的识别(若未接入开放平台,则为空)
        $productId = $request->post('productId');//云市场产品ID
        $requestId = $request->post('requestId');//接口请求的ID
        $signId = $request->post('signId');//实例标识Id
        $spec = $request->post('spec');//实例新规格
        $timeSpan = $request->post('timeSpan');//时长
        $timeUnit = $request->post('timeUnit');//时长单位
        $instanceExpireTime = $request->post('instanceExpireTime');//实例到期时间
        $time = strtotime($instanceExpireTime);
        $result = $this->model->updateUserRemarkEndTime($signId, $spec, $time);
        if ($result) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }

    /**
     * 实例续费通知接口
     * @return array
     */
    function renewInstance($request)
    {
        $orderId = $request->post('orderId');//订单ID
        $accountId = $request->post('accountId');//客户在腾讯云的账号ID
        $openId = $request->post('openId');//客户的识别(若未接入开放平台,则为空)
        $productId = $request->post('productId');//云市场产品ID
        $requestId = $request->post('requestId');//接口请求的ID
        $signId = $request->post('signId');//实例标识Id
        $instanceExpireTime = $request->post('instanceExpireTime');//新的实例到期时间(yyyy-MM-dd HH:mm:ss)
        $time = strtotime($instanceExpireTime);
        $result = $this->model->updateUserEndTime($signId, $time);
        if ($result) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }

    /**
     * 实例创建通知接口
     * @return array
     */
    function createInstance($request)
    {

        $orderId = $request->post('orderId');//订单ID
        $accountId = $request->post('accountId');//客户在腾讯云的账号ID
        $openId = $request->post('openId');//客户的识别(若未接入开放平台,则为空)
        $productId = $request->post('productId');//云市场产品ID
        $requestId = $request->post('requestId');//接口请求的ID
        $productInfo = $request->post('productInfo/a');//产品信息(JSON)
        $productInfo_productName = $productInfo['productName'];//购买产品名称
        $productInfo_isTrial = $productInfo['isTrial'];//是否为试用,true:是,false:否
        $productInfo_spec = $productInfo['spec'];//产品规格,是试用时为空
        $productInfo_timeSpan = $productInfo['timeSpan'];//购买时长,是试用时为空
        $productInfo_timeUnit = $productInfo['timeUnit'];//购买时长单位(y,m,d,h,t.分别代表年,月,日,时,次),是试用时为空
        $email = $request->post('email');//客户邮箱:服务商创建商品时,勾选"需要客户授权邮箱"
        $mobile = $request->post('mobile');//客户手机:服务商创建商品时,勾选"需要客户授权手机"

        $signId = getRandChar(11);
        $userName = 'txy' . date("Ymd", time()) . getRandNumber(5);
        $userPass = getRandChar(10);

        $data = array(
            'orderId' => $orderId,
            'signId' => $signId,
            'accountId' => $accountId,
            'userName' => $userName,
            'openId' => $openId,
            'productId' => $productId,
            'requestId' => $requestId,
            'productInfo_productName' => $productInfo_productName,
            'productInfo_isTrial' => $productInfo_isTrial,
            'productInfo_spec' => $productInfo_spec,
            'productInfo_timeSpan' => $productInfo_timeSpan,
            'productInfo_timeUnit' => $productInfo_timeUnit,
            'email' => $email,
            'mobile' => $mobile
        );

        $endtime = null;
        $remark = $orderId . '/' . $accountId . '/' . $productInfo_productName . '-' . $productInfo_spec;
        switch ($productInfo_timeUnit) {
            case "y":
                $endtime = strtotime('+' . $productInfo_timeSpan . ' year');
                break;
            case "m":
                $endtime = strtotime('+' . $productInfo_timeSpan . ' month');
                break;
            case "d":
                $endtime = strtotime('+' . $productInfo_timeSpan . ' day');
                break;
            case "h":
                $endtime = strtotime('+' . $productInfo_timeSpan . ' hour');
                break;
            case "t":
//                $endtime = strtotime('+' . $productInfo_timeSpan . ' day');
                break;
        }

        $result = $this->model->saveOrderInfo($data);
        if ($result) {
            $resutl = $this->model->saveUser($userName, $userPass, $remark, $endtime);
            if ($resutl) {
                $appInfo = array(
                    'website' => "https://www.yoos.co"
                );
                $additionalInfo = serviceInformation($userName, $userPass);
                return ['signId' => $signId, 'appInfo' => $appInfo, 'additionalInfo' => $additionalInfo];
            } else {
                return ['success' => false];
            }
        } else {
            return ['success' => false];
        }
    }

    /**
     * SAAS交付接口设置效验
     * @param $echoback
     * @return array
     */
    function verifyInterface($echoback)
    {
        return ['echoback' => $echoback];
    }

    /**
     * 效验加密信息
     * @param $signature
     * @param $token
     * @param $timestamp
     * @param $eventId
     * @return bool
     */
    function checkSignature($signature, $token, $timestamp, $eventId)
    {
        $currentTimestamp = time();
        if ($currentTimestamp - $timestamp > 30) {
            return false;
        }
        $timestamp = (string)$timestamp;
        $eventId = (string)$eventId;
        $params = array($token, $timestamp, $eventId);
        sort($params, SORT_STRING);
        $str = implode('', $params);
        $requestSignature = hash('sha256', $str);
        return $signature === $requestSignature;
    }

}
