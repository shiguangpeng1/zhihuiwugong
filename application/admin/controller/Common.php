<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Common extends Controller
{

    public function __construct()
    {
        header('content-type:text/html;charset=utf-8');
        $user = session('admin');

        if (!isset($user)){
            $this->success('请先登录','login/index');
        }

        $route = \request()->controller().'/'.\request()->action();

        $route = strtolower($route);

        $power = db::query("select * from nine_power where power_id in(select p_id from nine_rp where r_id in(select r_id from nine_ar where a_id=$user[admin_id]))");

        $routeArr = array_column($power,'route');
//        var_dump($route);die;
        if (!(in_array($route,$routeArr))){
            echo "<script>alert('对不起，你还没有访问的权限');</script>";die;
        }
    }

    public function recursion($data, $pid)
    {
        $arr = [];
        foreach ($data as $key=>$val){
            if ($val['pid']==$pid){
                $val['sub'] = $this->recursion($data, $val['power_id']);
                $arr[] = $val;
            }
        }
        return $arr;
    }
}
