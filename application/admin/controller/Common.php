<?php

namespace app\admin\Controller;

use think\Controller;
use think\Db;
use think\Session;

class Common extends Controller
{

    protected $user='';

    public function __construct()
    {
        if (Session::get('admin')===null){
            $this->success('请先登录','login/index');
        }

        $user=Session::get('admin');
        $route = \request()->controller().'/'.\request()->action();
        $route = strtolower($route);

        $user = Db::name('nine_admin')->where(['admin' => $user])->find();

        if(!$user){
            Session::delete('admin');
            $this->redirect('login/index');
        }

        if($user['status']!=2){//不是超级管理员的进行权限验证
            $quanxian=explode(',',$user['quanxian']);
            $open=0;
            if($route == 'index/index'){
                $open = 1;
            }
            for ($i = 0; $i < count($quanxian); $i++) {
                if ($quanxian[$i] == $route) {
                    $open = 1;
                }
            }
            if($open == 0){
                $this->redirect('Login/errors');
            }
        }
        $this->user=$user;
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