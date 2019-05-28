<?php

namespace app\admin\controller;

use think\Controller;
use Think\Exception;
use think\Request;
use think\Db;

class Finance extends Controller
{

    public function submitSalary()
    {

        if (request()->isPost()){

            //获取每页显示的条数
            $limit= Request::instance()->param('limit');
            //获取当前页数
            $page= Request::instance()->param('page');

            //计算出从那条开始查询
            $tol=($page-1)*$limit;

            //搜索
            $resumeName = input('name');

            $resumeSite = input('site');

            $resumeDate = input('date');

            $where = '1=1';

            if (!empty($resumeName)){
                $where.= " and name like '%".$resumeName."%' ";
            }

            if (!empty($resumeSite)){
                $where.= " and site like '%".$resumeSite."%' ";
            }

            if (!empty($resumeDate)){
                $where.= " and date like '%".$resumeDate."%' ";
            }

            $role = db('back_wages')->where($where)->limit($tol,$limit)->select();
            //var_dump($role);die;
            $list = Db::name('back_wages')->where($where)->select();

            $count = count($list);

            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;

            return json_encode($result);

        }

        $user = session('admin');

        return view('submitSalary',['user'=>$user]);
    }

    public function searchSalary()
    {

        if (request()->isPost()){

            //获取每页显示的条数
            $limit= Request::instance()->param('limit');
            //获取当前页数
            $page= Request::instance()->param('page');

            //计算出从那条开始查询
            $tol=($page-1)*$limit;

            //搜索
            $resumeName = input('name');

            $resumeSite = input('site');

            $resumeDate = input('date');

            $where = '1=1';

            if (!empty($resumeName)){
                $where.= " and name like '%".$resumeName."%' ";
            }

            if (!empty($resumeSite)){
                $where.= " and site like '%".$resumeSite."%' ";
            }

            if (!empty($resumeDate)){
                $where.= " and date like '%".$resumeDate."%' ";
            }

            $role = db('back_wages')->order('date desc')->where($where)->limit($tol,$limit)->order('date desc')->select();

            $list = Db::name('back_wages')->where($where)->order('date desc')->select();

            $count = count($list);

            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;

            return json_encode($result);

        }

        $user = session('admin');

        return view('searchSalary',['user'=>$user]);
    }

    public function socialSecurity()
    {

        if (request()->isPost()){

            //获取每页显示的条数
            $limit= Request::instance()->param('limit');
            //获取当前页数
            $page= Request::instance()->param('page');

            //计算出从那条开始查询
            $tol=($page-1)*$limit;

            //搜索
            $resumeName = input('name');

            $resumeSite = input('site');

            $resumeDate = input('date');

            $where = '1=1';

            if (!empty($resumeName)){
                $where.= " and name like '%".$resumeName."%' ";
            }

            if (!empty($resumeSite)){
                $where.= " and site like '%".$resumeSite."%' ";
            }

            if (!empty($resumeDate)){
                $where.= " and date like '%".$resumeDate."%' ";
            }

            $role = db('back_social')->where($where)->limit($tol,$limit)->select();
            //var_dump($role);die;
            $list = Db::name('back_social')->where($where)->select();

            $count = count($list);

            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;

            return json_encode($result);

        }

        $user = session('admin');

        return view('socialSecurity',['user'=>$user]);
    }

    public function checkMission()
    {

        if (request()->isPost()){

            //获取每页显示的条数
            $limit= Request::instance()->param('limit');
            //获取当前页数
            $page= Request::instance()->param('page');

            //计算出从那条开始查询
            $tol=($page-1)*$limit;

            //搜索
            $resumeName = input('key');

            $where = '1=1';

            if (!empty($resumeName)){
                $where.= " and name like '%".$resumeName."%' ";
            }

            $role = db('back_examine')->where($where)->limit($tol,$limit)->select();

            $list = Db::name('back_examine')->where($where)->select();

            $count = count($list);

            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;

            return json_encode($result);

        }

        $user = session('admin');

        return view('checkMission',['user'=>$user]);
    }

    //同意
    public function change()
    {
        $dataAll = input('post.');

        $time = date("Y-m-d H:i:s",$dataAll['time']);

        $status = input('status');

        $where = [
            'examine_id' => array('eq',$dataAll['examine_id']),
            'result' => array('eq',$dataAll['result']),
        ];

        $data = DB::table('back_examine')->where($where)->find();

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

        $request = DB::table('back_examine')->where('examine_id', $data['examine_id'])->setField($set);

        return json_encode($request);die;
    }

    public function reject()
    {
        $dataAll = input('post.');

        $time = date("Y-m-d H:i:s",$dataAll['time']);

        $where = [
            'examine_id' => array('eq',$dataAll['examine_id']),
            'result' => array('eq',$dataAll['result']),
        ];

        $data = DB::table('back_examine')->where($where)->find();

        $status = input('status');

        $set = [
            'result' =>$status,
        ];

        $request = DB::table('back_examine')->where('examine_id', $data['examine_id'])->setField($set);

        return json_encode($request);
    }
}