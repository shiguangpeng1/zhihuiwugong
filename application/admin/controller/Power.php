<?php

namespace app\admin\controller;

use think\Controller;
use Think\Exception;
use think\Request;
use think\Db;
use think\response\Json;
use think\Session;

class Power extends Common
{


    //权限添加
    public function administrator()
    {

        if (Request::instance()->isPost()){

            //获取每页显示的条数
            $limit= Request::instance()->param('limit');
            //获取当前页数
            $page= Request::instance()->param('page');

            //计算出从那条开始查询
            $tol=($page-1)*$limit;

            //搜索
            $roleName = input('role_name');


            $where =array();

            if (!empty($roleName)){
                $where['admin']=$roleName;
            }

            if($this->user['status']!=2){
                $where['status']=array('neq',2);
            }

            $role = db::name('nine_admin')->where($where)->limit($tol,$limit)->select();

            foreach ($role as $k=>$v){
                $role[$k]['project_name']=Db::name('back_project')->where(['pro_id'=>$v['project']])->value('por_name');
            }



            $list = Db::name('nine_admin')->where($where)->select();

            $count = count($list);

            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;

            return json_encode($result);

        }else{
            $user = $this->user;
            $sites = db::name('back_project')->select();
            return view('administrator',['user'=>$user,'sites'=>$sites]);
        }

    }

    public function del()
    {

        $roleId = input('id');

        $del=Db::name('nine_admin')->where(['admin_id'=>$roleId])->delete();

        if ($del){
            $res['code']=1;
            $res['msg']="删除成功";
        }else{
            $res['code']=0;
            $res['msg']="删除失败";
        }

        return json($res);die;
    }



    public function delAll()
    {

        $id=input("role_id/a");

        $str = implode(",",$id) ;

        $ids = substr($str,0,strrpos($str,','));


        $data=Db::name("nine_role")->where("role_id in ($ids)")->delete();

        if (null != $data){
            $request =[
                'msg' => '删除成功',
                'code'  => 1

            ];
        }else{
            $request =[
                'msg' => '删除失败',
                'code'  => 0

            ];
        }

        return json_encode($request);die;
    }

    //权限展示
    public function viewjurisdiction()
    {

        $role_id=Request::instance()->param('role_id');
        $user = $this->user;


        $power = db('nine_power')->select();

        /*dump($power);
        exit();*/

        $power = $this->recursion($power, 0);

        $quanxian = Db::name('nine_admin')->where('admin_id',$role_id)->value('quanxian');
        $quanxian = explode(',',$quanxian);



        return view('viewjurisdiction',['power'=>$power,'user'=>$user,'quanxian'=>$quanxian]);
    }

    //配置权限展示
    public function givejurisdiction()
    {
        $role_id=Request::instance()->param('role_id');

        $users = Db::name('nine_admin')->where(['admin_id'=>$role_id])->find();
        $power = db('nine_power')->where(['status'=>1])->select();
        $power = $this->recursion($power, 0);
        $user = explode(',',$users['quanxian']);


        return view('givejurisdiction',['user'=>$user,'power'=>$power,'admin_id'=>$users['admin_id']]);
    }


    public function add()
    {
        //角色名称的id
        $roleId = Request::instance()->param('adamin_id');

        if (Request::instance()->isPost()) {

            $data = input('data');
            $quanxian = substr($data, 0, strlen($data) - 1);

            $res = db('nine_admin')->where('admin_id', $roleId)->setField(['quanxian' => $quanxian]);

            if ($res != false) {

                return msg(1, $res, '成功');
            } else {
                return msg(0, $res, '失败');
            }

        }
    }

    //成员查看
    public function person()
    {
        $p = session::get('pro');
        //var_dump($p);die;
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

            $role = db::name('back_query')->field('query_id,station,mobile,indate,livedate,site')->where('site','=',$p)->select();


            foreach ($role as $k=>$v){
                $s = isset($v['indate'])?$v['indate']:'';

                $t = isset($v['livedate'])?$v['livedate']:date('Y/m/d');
                $start_time=strtotime($s);//入职时间

                $end_time=strtotime($t);//离职时间

                $role[$k]['indate'] =(($end_time-$start_time)/86400);

                if (empty($v['livedate'])){
                    $role[$k]['status'] = 1;
                }else{
                    $role[$k]['status'] =0;
                }
            }





            $list = Db::name('back_project')->where($where)->select();
            $count = count($list);

            $result=array();
            $result['code']=0;
            $result['status']=1;
            $result['count']=$count;
            $result['data'] = $role;
//            var_dump($result);die;
            return json_encode($result);

        }else if (request()->isGet()){

            $proNames = input('project');

            $pro = $proNames;

            session('pro',$pro);
        }
        $user = session('admin');

        return view('person',['user'=>$user]);

    }




    public function addadmin()
    {

        if (Request::instance()->isPost()){

            $postdata=input();
            if(empty($postdata['name'])||empty($postdata['admin'])||empty($postdata['pwd'])||empty($postdata['project'])){
                $res['code']=0;
                $res['msg']="参数填写完整";
                return json($res);
            }

            $user=Db::name('nine_admin')->where(['admin'=>$postdata['admin']])->find();
            if($user){
                $res['code']=0;
                $res['msg']="账号已存在";
                return json($res);
            }
            if(strlen($postdata['admin'])<6 || strlen($postdata['admin'])>20 ){
                $res['code']=0;
                $res['msg']="账号由6-20位字母组合";
                return json($res);
            }
            if(strlen($postdata['pwd'])<6 || strlen($postdata['pwd'])>20 ){
                $res['code']=0;
                $res['msg']="密码由6-20位字母或数字组成";
                return json($res);
            }
            $postdata['admin']=trim(strtolower($postdata['admin']));
            $postdata['pwd']=md5($postdata['pwd']);
            $add=Db::name('nine_admin')->insertGetId($postdata);
            if($add){
                $res['code']=1;
                $res['msg']="添加成功";
                return json($res);
            }else{
                $res['code']=0;
                $res['msg']="添加失败";
                return json($res);
            }
        }else{
            $role = db('nine_role')->select();

            $project = db('back_project')->select();

            $user = $this->user;

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

    //设置角色功能
    public function givefunction()
    {
        $role_id = session::get('role_id');

        if (request()->isGet()){
            $roleId = input('role_id');

            $roleid= $roleId;

            session('role_id',$roleid);
        }
        $user = $this->user;

        $power = db('nine_power')->select();

        $power = $this->recursion($power, 0);
        unset($power[0]);
        unset($power[1]);
        unset($power[2]);
        return view('givefunction',['user'=>$user,'power'=>$power]);
    }

    public function addmto()
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
                    $this->redirect('admin/admin/Management');
                }
            }
        }
    }

    public function setmanagement()
    {

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

            //$data = db::table('nine_role')->select();

            $role = db('back_project')->where($where)->limit($tol,$limit)->select();

            $list = Db::name('back_project')->where($where)->select();

            $count = count($list);

            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;
            //var_dump($result);die;
            return json_encode($result);
        }

        return view('setManagement');
    }


    public function editadmin(){
        $postdata= Request::instance()->param();

        if(Request::instance()->isPost()){
            if(empty($postdata['name'])||$postdata['project']==1){
                $data['code']=0;
                $data['msg']="填写完整";
                return json($data);
            }
            $updata=Db::name('nine_admin')->where(['admin_id'=>$postdata['admin_id']])->update($postdata);
            if($updata){
                $data['code']=1;
                $data['msg']="修改成功";
                return json($data);
            }else{
                $data['code']=0;
                $data['msg']="修改失败";
                return json($data);
            }
        }

        $project = db::name('back_project')->select();
        $user=Db::name('nine_admin')->where(['admin_id'=>$postdata['role_id']])->find();
        $user['project_name']=Db::name('back_project')->where(['pro_id'=>$user['project']])->value('por_name');
        return view('editAdmin', [
            'project' => $project,
            'role'    => $user,
        ]);
    }




}