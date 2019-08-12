<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/8/11
 * Time: 17:44
 */

namespace app\index\controller;


use app\index\model\Yoosco;
use think\Exception;
use think\Request;

/**
 * 商品列表
 * Class Goods
 * @package app\index\controller
 */
class Goods
{

    private $yoosco = null;

    public function __construct()
    {
        $this->yoosco = new Yoosco();
    }

    function findOneGood()
    {
        $data = $this->yoosco->findOneGood(2);
        return getJson(200, "ok", $data);
    }

    /**
     * 批量添加商品信息
     * @return array
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    function saveUploadGoods()
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
                'good_id',
                'good_name',
                'good_type'
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
            $result = $this->yoosco->saveUploadGoods($data);
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