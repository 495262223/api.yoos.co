<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/8/11
 * Time: 18:39
 */

namespace app\index\controller;

use app\index\model\Yoosco;

/**
 * 优惠码领取记录
 * Class DiscountCodeRecording
 * @package app\index\controller
 */
class DiscountCodeRecording
{

    private $yoosco = null;

    public function __construct()
    {
        $this->yoosco = new Yoosco();
    }

//    function saveCodeRecord()
//    {
//        $data = [
//            'orderid' => '3213213213123',
//            'code' => '1232131312312313'
//        ];
//        $result = $this->yoosco->saveCodeRecord($data);
//        return getJson(200, 'ok', $result);
//    }

}