<?php

namespace app\admin\controller;

use think\Controller;
use Think\Exception;
use think\Request;
use think\Db;
use think\Session;

class Power extends Common
{
    //权限添加
    public function administrator()
    {
        //echo 11;die;

        if (request()->isPost()){

            //获取每页显示的条数
            $limit= Request::instance()->param('limit');
            //获取当前页数
            $page= Request::instance()->param('page');

            //计算出从那条开始查询
            $tol=($page-1)*$limit;

            //搜索
            $roleName = input('role_name');


            $where = '1=1';

            if (!empty($roleName)){
                $where.= " and role_name like '%".$roleName."%' ";
            }

            $role = db('nine_role')->alias('a')->join('back_project b','a.site=b.pro_id')->where($where)->limit($tol,$limit)->select();

            $list = Db::name('nine_role')->alias('a')->join('back_project b','a.site=b.pro_id')->where($where)->select();

            $count = count($list);

            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;

            return json_encode($result);

        }
        $user = session('admin');

        return view('administrator',['user'=>$user]);
    }

    public function del()
    {
        $roleId = input('role_id');

        $data = db('nine_role')->where('role_id','=',$roleId)->delete();

        if (null != $data){
            $request =[
                'message' => '删除成功',
                'status'  => 1

            ];
        }else{
            $request =[
                'message' => '删除失败',
                'status'  => 0

            ];
        }

        return json_encode($request);die;
    }



    public function delAll()
    {

        $id=input("role_id/a");

        $str = implode(",",$id) ;

        $ids = substr($str,0,strrpos($str,','));


        $data=Db::name("nine_role")->where("role_id in ($ids)")->delete();

        if (null != $data){
            $request =[
                'message' => '删除成功',
                'status'  => 1

            ];
        }else{
            $request =[
                'message' => '删除失败',
                'status'  => 0

            ];
        }

        return json_encode($request);die;
    }

    //权限展示
    public function viewjurisdiction()
    {
        if (request()->isGet()){
            $roleId = input('role_id');

            $roleid= $roleId;

            session('role_id',$roleid);
        }
        $user = session('admin');

        $power = db('nine_power')->select();

        $power = $this->recursion($power, 0);

        $allpower = db::query("select * from nine_power where power_id in(select p_id from nine_rp where r_id in(select r_id from nine_ar where a_id=$user[admin_id]))");

        $data = array_column($allpower,'power_id');
        //var_dump($data);die;
        return view('viewjurisdiction',['power'=>$power,'data'=>$data,'user'=>$user]);
    }

    //配置权限展示
    public function givejurisdiction()
    {
        if (request()->isGet()){
            $roleId = input('role_id');

            $roleid= $roleId;

            session('role_id',$roleid);
        }
        $user = session('admin');

        $power = db('nine_power')->select();

        $power = $this->recursion($power, 0);
//        var_dump($power);die;
        return view('givejurisdiction',['user'=>$user,'power'=>$power]);
    }

    public function add()
    {
        //角色名称的id
        $roleId = session::get('role_id');
        if (Request::instance()->isPost()) {

            $data = input();
            $r_id = $roleId;
            if (isset($data['p_id'])){
                $r_id = $roleId;
                $arr = [];
                foreach ($data['p_id'] as $val){

                    $arr[] = ['r_id'=>$r_id,'p_id'=>$val];
                }

                $res = db('nine_rp')->insertAll($arr);

                if ($res){
                    $this->redirect('admin/power/administrator');
                }
            }
        }
    }

    //成员查看
    public function person()
    {
        $p = session::get('pro');

        if (request()->isPost()){

            //获取每页显示的条数
            $limit= Request::instance()->param('limit');
            //获取当前页数

            $page= Request::instance()->param('page');

            //计算出从那条开始查询
            $tol=($page-1)*$limit;

            //搜索
            $porName = input('key');
            // var_dump($porName);die;
            $where = '1=1';

            if (!empty($porName)){
                $where.= " and por_name like '%".$porName."%' ";
            }

            $role = db::name('back_query')->field('query_id,site,mobile')->where('site','=',$p)->select();
//            var_dump($role);die;
            $list = Db::name('back_project')->where($where)->select();

            $count = count($list);

            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;

            return json_encode($result);

        }else if (request()->isGet()){

                 $proNames = input('pro_name');

                 $pro = $proNames;

                 session('pro',$pro);
        }

        $user = session('admin');

        return view('person',['user'=>$user]);
    }

    public function addadmin()
    {
        if (Request::instance()->isPost()){
            $data = input();

            $role = $data['role_name'];

            $proId = $data['pro_id'];

            $admin = db('nine_admin')->where('admin',$data['admin'])->find();

            if($admin == $data['admin']){

                $sql = "insert into nine_admin values (null ,'$data[admin]','$data[pwd]',0)";
                db('nine_admin')->execute($sql);
            }else{

                $requset = [
                    'status'  => -1,
                    'message' => '用户名已存在'
                ];

                return json_encode($requset);
            }
            //用戶的id
            $a_id = db('nine_admin')->getLastInsID();

            $data = [
                'role_name' => $role,
                'site'      => $proId
            ];

            $roleName = db('nine_role')->where('role_name',$role)->find();
            if ($roleName == $data['role_name']){
                $datae = db('nine_role')->insert($data);
            }else{
                $requset = [
                    'status'  => -2,
                    'message' => '角色名已存在'
                ];
                return json_encode($requset);
            }

            //角色的id
            $r_id = db('nine_role')->getLastInsID();

            $arr = [
                'a_id'   => $a_id,
                'r_id'   => $r_id,
            ];

            $res = db('nine_ar')->insert($arr);

            if ($res){
                $requset = [
                    'status'    => 200,
                    'message' => '添加成功'
                ];

            }

            return json_encode($requset);
        }else{
            $role = db('nine_role')->select();

            $project = db('back_project')->select();

            $user = session('admin');

            return view('addadmin',['role'=>$role,'project'=>$project,'user'=>$user]);
        }
    }

    public function addto()
    {
        if (\request()->isPost()){
            //角色id
            $roleid   = input('role_id');

            $roleName = input('role_name');
            //项目id
            $proid   = input('pro_id');
            //项目点名称
            $porName = input('por_name');

            $site = input('site');

            $role = db('nine_role')->where('role_id',$roleid)->update(['role_name'=>$roleName]);

            $role = db('back_project')->where('pro_id',$proid)->update(['por_name'=>$porName]);

            $result=array();
            $result['code']=0;
            $result['msg']="";

            $result['data'] = $role;

            return json_encode($result);

        }
    }

    public function givefunction()
    {
        $role_id = session::get('role_id');
        if (request()->isGet()){
            $roleId = input('role_id');

            $roleid= $roleId;

            session('role_id',$roleid);
        }
        $user = session('admin');

        $power = db('nine_power')->select();

        $power = $this->recursion($power, 0);
//        var_dump($power);die;
        return view('givefunction',['user'=>$user]);
    }
}