<?php

namespace app\admin\Controller;

use think\Controller;
use think\Request;
use think\Db;
use think\Session;

class Login extends controller
{
    public function index()
    {
        return view('login');
    }

    public function add(Request $request)
    {

        if ($request->isPost()){

            $username = input('admin');

            $password = input('pwd');

            if ($username ==''){
                $this->error('用户名不能为空');die;
            }

            if ($password == ''){

                $this->error('密码不能为空');die;
            }

            $data = db::name('nine_admin')->where('admin',$username)->find();

            //$res = db('nine_admin')->where('admin',$username)->find();

            if ($data) {
                if ($data['pwd'] == md5($password)) {

                    session('admin',$data);

                    $request =[
                        'message' => '登录成功',
                        'status'  => 1

                    ];

                    //管理员日志
                    $record = [
                        'uid'  => session::get('admin.admin'),
                        'type' => '登录',
                        'ips'  => $_SERVER["REMOTE_ADDR"]
                    ];
                    if ($data['status'] == 1 ){
                        db::name('back_record')->insert($record);
                    }

                } else{
                    $request =[
                        'message' => '密码错误',
                        'status'  => 0

                    ];
                }
            } else{
                $request =[
                    'message' => '用户名不存在请先注册',
                    'status'  => 2

                ];
            }
            return json($request);
        }
    }

    //修改密码
    public function changePassword(Request $request)
    {
        //获取当前登录用户的信息
        $password = session::get('admin.pwd');

        $uid = session::get('admin.admin_id');
        //var_dump($uid);die;
        if ($request->isPost()){

            $data = $request->post();

            $password = input('pwd','','md5');

            $newpassword = input('newpwd','','md5');

            $renewpassword = input('renewpwd','','md5');

            //首先判断用户输入的旧密码是否与当前用户的密码是否一致
            if ($password !== md5($data['pwd'])){

                return msg(-1,'','旧密码输入错误，请重新输入！');
            }

            //判断新旧密码是否相同
            if ($newpassword == $password){

                return msg(2,'','新旧密码一致,您未做任何修改！');

            }elseif ($newpassword == !$renewpassword) {
                return msg(3,'','密码确认不一致,请重新输入！');
            }else{
                $request =  DB::table('nine_admin')->where('admin_id','=',$uid)->setField('pwd',$newpassword);

                if ($request){
                    session::delete('pwd',null);
                    return msg(200,'','密码修改成功！');
                }else{
                    return msg(0,'','密码修改失败！');
                }
            }
        }

    }


    //退出
    public function out()
    {
        Session::clear();
        $this->redirect('admin/login/index');
    }
}
