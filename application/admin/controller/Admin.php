<?php

namespace app\admin\Controller;

use think\Controller;
use think\Request;
use think\Db;

class Admin extends Controller
{

    //角色功能管理
    public function management()
    {
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

            $list = Db::name('nine_role')->where($where)->select();

            $count = count($list);


            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;
            // var_dump($result);die;
            return json_encode($result);
        }
        $user = session('admin');
        return view('Management',['user'=>$user]);
    }

    //管理员日志
    public function adminLog()
    {

        if (request()->isPost()){

            //获取每页显示的条数
            $limit= Request::instance()->param('limit');
            //获取当前页数

            $page= Request::instance()->param('page');

            //计算出从那条开始查询
            $tol=($page-1)*$limit;

            //搜索
            $roleName = input('uid');

            $where = '1=1';

            if (!empty($roleName)){
                $where.= " and uid like '%".$roleName."%' ";
            }

            //$data = db::table('nine_role')->select();

            $role = db('back_record')->where($where)->limit($tol,$limit)->select();

            $list = Db::name('back_record')->where($where)->select();

            $count = count($list);


            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;
           // var_dump($result);die;
            return json_encode($result);
        }

        $user = session('admin');

        return view('adminLog',['user'=>$user]);
    }



    public function waitMission()
    {
        if (request()->isPost()){

            //获取每页显示的条数
            $limit= Request::instance()->param('limit');
            //获取当前页数

            $page= Request::instance()->param('page');

            //计算出从那条开始查询
            $tol=($page-1)*$limit;

            //搜索
            $roleName = input('key');

            $where = '1=1';

            if (!empty($roleName)){
                $where.= " and handle_name like '%".$roleName."%' ";
            }

            //$data = db::table('nine_role')->select();

            $role = db('back_handle')->where($where)->limit($tol,$limit)->select();

            $list = Db::name('back_handle')->where($where)->select();

            $count = count($list);


            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;
            // var_dump($result);die;
            return json_encode($result);
        }

        $user = session('admin');
        return view('waitMission',['user'=>$user]);
    }


    //删除
    public function del()
    {

        $roleId = input('re_id');

        $data = db('back_record')->where('re_id','=',$roleId)->delete();

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

        $id=input("re_id/a");

        $str = implode(",",$id) ;

        $ids = substr($str,0,strrpos($str,','));
        //var_dump($ids);die;

        $data=Db::name("back_record")->where("re_id in ($ids)")->delete();
        //var_dump($data);die;
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

    public function change()
    {
        $dataAll = input('post.');

        $time = date("Y-m-d H:i:s",$dataAll['time']);
       // var_dump($time);die;
        $status = input('status');

        $where = [
            'handle_id' => array('eq',$dataAll['handle_id']),
            'result' => array('eq',$dataAll['result']),
        ];

        $data = DB::table('back_handle')->where($where)->find();

        $now = date('Y-m-d h:i:s', time());

        if ($now>$time){
            $reult = [
                'message' => '已开始',
                'code'    => 1,
            ];
        }else{
            $reult = [
                'message' => '未开始',
                'code'    => 0,
            ];
        }

        $set = [
            'result' =>$status
        ];

        $request = DB::table('back_handle')->where('handle_id', $data['handle_id'])->setField($set);

        return json_encode($request);die;

    }

    public function setManagement()
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

    public function dell()
    {

        $roleId = input('pro_id');

        $data = db('back_project')->where('pro_id','=',$roleId)->delete();

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



    public function dd()
    {
        $id = input("pro_id/a");
        //var_dump($id);die;
        $str = implode(",",$id) ;

        $ids = substr($str,0,strrpos($str,','));
        //var_dump($ids);die;

        $data=Db::name("back_project")->where("pro_id in ($ids)")->delete();
        //var_dump($data);die;
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

    public function add()
    {
        if (request()->isPost()){
            $proName = input('por_name');

            $data = [
                'por_name' =>$proName
            ];

            $requset = db::name('back_project')->insert($data);
        }

        return json_encode($requset);
    }


    public function addto()
    {
        if (\request()->isPost()){
            $data = input();

            $all = [
                'resume_data' => isset($data['resume_data'])?$data['resume_data']:'',
                'resume_dq'   => isset($data['resume_dq'])?$data['resume_dq']:'',
                'resume_zw'   => isset($data['resume_zw'])?$data['resume_zw']:'',
                'resume_xmd'  => isset($data['resume_xmd'])?$data['resume_xmd']:'',
                'resume_name' => isset($data['resume_name'])?$data['resume_name']:'',
                'resume_xb'   => isset($data['resume_xb'])?$data['resume_xb']:'',
                'resume_age'  => isset($data['resume_age'])?$data['resume_age']:'',
                'resume_xl'   => isset($data['resume_xl'])?$data['resume_xl']:'',
                'resume_gzjx' => isset($data['resume_gzjx'])?$data['resume_gzjx']:'',
                'resume_qwzw' => isset($data['resume_qwzw'])?$data['resume_qwzw']:'',
                'resume_qwdd' => isset($data['resume_qwdd'])?$data['resume_qwdd']:'',
                'resume_qwxz' => isset($data['resume_qwxz'])?$data['resume_qwxz']:'',
                'resume_tel'  => isset($data['resume_tel'])?$data['resume_tel']:'',
                'resume_bz'   => isset($data['resume_bz'])?$data['resume_bz']:''
            ];
            $role = db::name('back_resume')->insert($all);
            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['data'] = $role;
            return json_encode($result);die;
        }
    }

    public function delete()
    {
        $id = input("resume_id/a");

        $str = implode(",",$id) ;

        $ids = substr($str,0,strrpos($str,','));
        //var_dump($ids);die;

        $data=Db::name("back_resume")->where("resume_id in ($ids)")->delete();
        //var_dump($data);die;
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


   public function givefunction()
   {
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


    public function ceshi()
    {
        $time=date("Y-n-j",(time()+86400*30));
        var_dump($time);die;
//
        $sql='select * from back_query where livedate<'.$time;

            $d = db::query('select * from back_query where livedate<'.$time);
            var_dump($d);die;
//       $s = "SELECT if(DATEDIFF(CURDATE(),'2019-4-20')<=30,"即将到期","-") as expire";
//
//        var_dump($time);die;

        $time1 = strtotime(date('Y-m-d', time()));//获得当时时间戳
       // var_dump($time1);die;
        $time2 = strtotime(date('Y-m-d', strtotime("+30 day")));//获得一年之后的时间戳
        //var_dump($time2);die;
        $time3 = strtotime(date('Y-m-d', time()));//获得当前时间戳，用作对比
        //var_dump($time3);die;
        if ($time3 <= $time2) {
            echo '到期时间是：' . Date('Y-m-d', $time2);
            unset($time1);
        }
    }

}