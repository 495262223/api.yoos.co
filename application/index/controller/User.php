<?php


namespace app\index\controller;


use app\index\model\Yoosco;
use think\Request;

class User
{

    private $yoosco = null;

    public function __construct()
    {
        $this->yoosco = new  Yoosco();
    }

    function LoginUser(Request $request)
    {
        $userName = $request->post('userName');
        $userPass = $request->post('userPass');
        $result = $this->yoosco->LoginUser($userName, $userPass);
        if ($result) {
            return getJson(200, "登录成功", []);
        } else {
            return getJson(201, "登录失败", []);
        }
    }

}