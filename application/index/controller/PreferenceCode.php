<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/8/11
 * Time: 18:01
 */

namespace app\index\controller;

use app\index\model\Yoosco;
use think\Exception;
use think\Request;

/**
 * 优惠码列表
 * Class PreferenceCode
 * @package app\index\controller
 */
class PreferenceCode
{

    private $yoosco = null;

    public function __construct()
    {
        $this->yoosco = new Yoosco();
    }

    function findRandomCode()
    {
        $data = $this->yoosco->findRandomCode('1元');
        return getJson(200, "成功", $data);
    }

    function getCode(Request $request)
    {
        $orderId = $request->post('orderId');
        if (empty($orderId)) {
            return getJson(201, '请输入订单号码', []);
        }
        //订单号验证
        $count = $this->yoosco->findOneCodeRecord($orderId);
        if ($count) {
            return getJson(202, '该订单号已领取优惠码', []);
        }
        //实例创建通知
        $createinstance = $this->yoosco->getCreateinstance($orderId);//查询创建实例记录
        if (!empty($createinstance)) {
            //判断该记录是否为新系统
            if ($createinstance['good_type'] == 2) {
                //判断该记录是否是试用
                if (!$createinstance['productInfo_isTrial']) {
//                    $taocan_name = substr($createinstance['productInfo_spec'], 0, 9);
//                    $taocan = $this->yoosco->findOneMeal($taocan_name);
//                    $price = floatval($taocan['setmeal_price']);
//                    $time = $createinstance['productInfo_timeSpan'];
//                    switch ($time) {
//                        case 1:
//                            //一年价格
//                        case 3:
//                            //三年价格
//                        case 5:
//                            //五年价格
//                            break;
//                    }
//                    $code = $this->yoosco->findRandomCode($price . '元');
//                    if (!empty($code)) {
//                        $this->yoosco->updateCodeStart($code['Id']);
//                        $this->yoosco->saveCodeRecord($orderId, $code['code']);
//                        return getJson(200, '获取优惠码', $code);
//                    } else {
//                        return getJson(500, '获取优惠码失败,请联系管理员', []);
//                    }
                    $code = $this->getCodeData($orderId, $createinstance['productInfo_spec'], $createinstance['productInfo_timeSpan']);
                    if (!empty($code)) {
                        return getJson(200, '获取优惠码', $code);
                    } else {
                        return getJson(500, '获取优惠码失败,请联系管理员', []);
                    }
                } else {
                    return getJson(203, '获取优惠码失败,该订单是试用订单', []);
                }
            } else {
                return getJson(202, '获取优惠码失败,该订单号无效', []);
            }
        }
        //实例续费通知
        $renewinstance = $this->yoosco->getRenewinstance($orderId);
        if (!empty($renewinstance)) {
            $signId = $renewinstance['signId'];
            $createinstance = $this->yoosco->getCreateinstanceSignId($signId);
            if ($createinstance['good_type'] == 2) {
                if (!$createinstance['productInfo_isTrial']) {
                    $code = $this->getCodeData($orderId, $createinstance['productInfo_spec'], 1);
                    if (!empty($code)) {
                        return getJson(200, '获取优惠码', $code);
                    } else {
                        return getJson(500, '获取优惠码失败,请联系管理员', []);
                    }
                } else {
                    $modifyinstance = $this->yoosco->getModifyinstanceSignId($signId);
                    $code = $this->getCodeData($orderId, $modifyinstance['spec'], 1);
                    if (!empty($code)) {
                        return getJson(200, '获取优惠码', $code);
                    } else {
                        return getJson(500, '获取优惠码失败,请联系管理员', []);
                    }
                }
            } else {
                return getJson(202, '获取优惠码失败,该订单号无效', []);
            }
        }
        //实例变更通知
        $modifyinstance = $this->yoosco->getModifyinstance($orderId);
        if (!empty($modifyinstance)) {
            $signId = $modifyinstance['signId'];
            $createinstance = $this->yoosco->getCreateinstanceSignId($signId);
            if ($createinstance['good_type'] == 2) {
                $code = $this->getCodeData($orderId, $modifyinstance['spec'], $modifyinstance['timeSpan']);
                if (!empty($code)) {
                    return getJson(200, '获取优惠码', $code);
                } else {
                    return getJson(500, '获取优惠码失败,请联系管理员', []);
                }
            } else {
                return getJson(202, '获取优惠码失败,该订单号无效', []);
            }
        }
        return getJson(210, "订单号有误,请检查后重新输入", []);
    }

    function getCodeData($orderId, $spec, $time)
    {
        $taocan_name = substr($spec, 0, 9);
        $taocan = $this->yoosco->findOneMeal($taocan_name);
        $price = floatval($taocan['setmeal_price']);
        switch ($time) {
            case 1:
                //一年价格
                $price = $price * 1;
                break;
            case 3:
                //三年价格
                $price = $price * 2;
                break;
            case 5:
                //五年价格
                $price = $price * 3;
                break;
        }
        $code = $this->yoosco->findRandomCode($price . '元');
        if (!empty($code)) {
            $this->yoosco->updateCodeStart($code['Id']);
            $this->yoosco->saveCodeRecord($orderId, $code['code']);
        }
        return $code;
    }

    /**
     * 批量添加优惠码
     * @return array
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    function saveUploadCode()
    {
        $request = Request::instance();
        try {
            $excel = $request->file('excel')->getInfo();
            $file_array = explode(".", $excel['name']);
            $file_extension = strtolower(array_pop($file_array));
            if ($file_extension != "xls" && $file_extension != "xlsx") {
                return getJson(900, "上传文件类型错误,请重新上传", []);
            }
            vendor("PHPExcel.PHPExcel.IOFactory");
            $objPHPExcel = \PHPExcel_IOFactory::load($excel['tmp_name']);//读取上传的文件
            $arrExcel = $objPHPExcel->getSheet(0)->toArray();
            array_shift($arrExcel);
            $data = array();
            $titles = array(
                'code',
                'UseObjects',
                'Repeatability',
                'PreferentialMode',
                'TermOfValidity',
                'state',
                'create_time',
                'create_user'
            );
            $index_a = 0;
            foreach ($arrExcel as $key => $value) {
                $index_b = 0;
                $count = $this->yoosco->VerificationCode($arrExcel[$key][0]);
                for ($i = 0; $i < count($titles); $i++) {
                    if (!$count) {
                        $data[$index_a][$titles[$i]] = $arrExcel[$key][$index_b];
                        $index_b++;
                    }
                }
                $index_a++;
            }
            $result = $this->yoosco->saveUploadCode($data);
            if ($result) {
                return getJson(200, "上传信息成功", []);
            } else {
                return getJson(201, "上传信息失败", []);
            }
        } catch (Exception $e) {
            return getJson(901, "上传信息内容错误", []);
        }
    }


}