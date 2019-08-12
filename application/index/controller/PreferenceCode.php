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

    /**
     * 获取优惠码
     * @param Request $request
     * @return array
     */
    function getCode(Request $request)
    {
        $orderId = $request->post('orderId');
        if (empty($orderId)) {
            return getJson(201, '请输入订单号码', []);
        }
        return getJson(200, '获取优惠码', ['orderId' => $orderId]);
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
                for ($i = 0; $i < count($titles); $i++) {
                    $data[$index_a][$titles[$i]] = $arrExcel[$key][$index_b];
                    $index_b++;
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