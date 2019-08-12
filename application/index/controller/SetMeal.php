<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/8/11
 * Time: 18:51
 */

namespace app\index\controller;

use app\index\model\Yoosco;
use think\Request;

/**
 * 套餐列表
 * Class SetMeal
 * @package app\index\controller
 */
class SetMeal
{

    private $yoosco = null;

    public function __construct()
    {
        $this->yoosco = new Yoosco();
    }

    function findOneMeal()
    {
        $setmeal_name = "基础版";
        $data = $this->yoosco->findOneMeal($setmeal_name);
        return getJson(200, "ok", $data);
    }

    /**
     * 添加套餐
     * @param Request $request
     * @return array
     */
    function saveSetMeal(Request $request)
    {
        $setmeal_name = $request->post('setmeal_name');
        $setmeal_price = $request->post('setmeal_price');
        $data = [
            'setmeal_name' => $setmeal_name,
            'setmeal_price' => $setmeal_price
        ];
        $result = $this->yoosco->saveSetMeal($data);
        if ($result) {
            return getJson(200, '套餐添加成功', []);
        } else {
            return getJson(201, '套餐添加失败', []);
        }
    }

}