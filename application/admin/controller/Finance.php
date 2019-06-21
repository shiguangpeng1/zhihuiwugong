<?php

namespace app\admin\controller;

use think\Controller;
use Think\Exception;
use think\Request;
use think\Db;
use think\save;

class Finance extends Common
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

        $user = $this->user;

        $sites = db::name('back_project')->select();

        return view('submitSalary',['user'=>$user,'sites'=>$sites]);
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

            $resumesDate = input('datas');

            $stats = substr($resumesDate,0,strrpos($resumesDate,' - '));
            $end = substr($resumesDate,10,strrpos($resumesDate,'- '));

            $where = array('between', array($stats,$end));

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

        }else{
            $user = $this->user;

            $sites = db('back_project')->select();
            return view('searchSalary',['user'=>$user,'sites'=>$sites]);
        }


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

        }else{
            $user = $this->user;

            $sites = db::name('back_project')->select();

            return view('socialSecurity',['user'=>$user,'sites'=>$sites]);
        }


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

        $user = $this->user;

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

    //工资核算添加
    public function add()
    {
        if (request()->isPost()){

            $data = input();


            $dataAll = [
                'staffid'  => isset($data['staffid'])?$data['staffid']:'',
                'site'     => isset($data['site'])?$data['site']:'',
                'idnumber' => isset($data['idnumber'])?$data['idnumber']:'',
                'name'     => isset($data['name'])?$data['name']:'',
                'date'     => isset($data['date'])?time($data['date']):'',
                'worktype' => isset($data['worktype'])?$data['worktype']:'',
                'signdays' => isset($data['signdays'])?$data['signdays']:'',
                'salary'   => isset($data['salary'])?$data['salary']:'',
                'socialsecurity' => isset($data['socialsecurity'])?$data['socialsecurity']:'',
                'reservedfunds'  => isset($data['reservedfunds'])?$data['reservedfunds']:'',
                'taxsalary'   => isset($data['taxsalary'])?$data['taxsalary']:'',
                'deduct'      => isset($data['deduct'])?$data['deduct']:'',
                'personaltax' => isset($data['personaltax'])?$data['personaltax']:'',
                'truesalary'  => isset($data['truesalary'])?$data['truesalary']:'',
                'signature'   => isset($data['signature'])?$data['signature']:''
            ];

            if (isset($data['wid'])){

                $res = db::name('back_wages')->where('wid',$data['wid'])->update($dataAll);
                return msg(1,$res,'');
            }else{
                $role= db::name('back_wages')->insert($dataAll);
                return msg(1,$role,'');
            }
//            $roel = db::name('back_wages')->insert($dataAll);
//
//            return msg(1,$roel,'');
//            if ($roel) {
////                $result['code'] = 1;
////                $result['msg'] = "";
////
////                return json_encode($result);die;
//                return msg(1,$role,'');
//            }

        }else{
            $sitems = db::name('back_project')->select();

            return view('personnel',['sitems'=>$sitems]);
        }
    }

    //社保费用核算
    public function addto()
    {
        if (request()->isPost()){

            $data = input();

            $dataAll = [
                'socialSecurityNumber'  => isset($data['socialSecurityNumber'])?$data['socialSecurityNumber']:'',
                'name'     => isset($data['name'])?$data['name']:'',
                'sex' => isset($data['sex'])?$data['sex']:'',
                'IDNumber'     => isset($data['IDNumber'])?$data['IDNumber']:'',
                'censusRegister' => isset($data['censusRegister'])?$data['censusRegister']:'',
                'declare' => isset($data['declare'])?$data['declare']:'',
                'basics'   => isset($data['basics'])?$data['basics']:'',
                'endowmentInsurance' => isset($data['endowmentInsurance'])?$data['endowmentInsurance']:'',
                'medicalInsurance'  => isset($data['medicalInsurance'])?$data['medicalInsurance']:'',
                'unemploymentInsurance'   => isset($data['unemploymentInsurance'])?$data['unemploymentInsurance']:'',
                'largeMedicalInsurance'      => isset($data['largeMedicalInsurance'])?$data['largeMedicalInsurance']:'',
                'personalTotal' => isset($data['personalTotal'])?$data['personalTotal']:'',
                'cendowmentInsurance'  => isset($data['cendowmentInsurance'])?$data['cendowmentInsurance']:'',
                'cmedicalInsurance'   => isset($data['cmedicalInsurance'])?$data['cmedicalInsurance']:'',
                'cunemploymentInsurance'   => isset($data['cunemploymentInsurance'])?$data['cunemploymentInsurance']:'',
                'cemploymentInjuryInsurance'   => isset($data['cemploymentInjuryInsurance'])?$data['cemploymentInjuryInsurance']:'',
                'cmaternityInsurance'   => isset($data['cmaternityInsurance'])?$data['cmaternityInsurance']:'',
                'clargeMedicalInsurance'   => isset($data['clargeMedicalInsurance'])?$data['clargeMedicalInsurance']:'',
                'companyTotal'   => isset($data['companyTotal'])?$data['companyTotal']:'',
                'site'          => isset($data['site'])?$data['site']:'',
                'total'          => isset($data['total'])?$data['total']:'',
                'daytime'          => isset($data['daytime'])?$data['daytime']:'',

            ];
           /* dump($dataAll);
            exit();*/
            $socId = db::name('back_social')->where('soc_id',$data['soc_id'])->find();
            if ($data['soc_id']==$socId['soc_id']){

                    $resulta = Db::name('back_social')->where('soc_id', $data['soc_id'])->setField($dataAll);
                    if ($resulta !== false){
                        $result['code'] = 1;
                        $result['msg'] = "更新成功";

                        return json($result);die;
                    }else{
                        $result['code'] = 0;
                        $result['msg'] = "更新失败";

                        return json($result);die;
                    }
            }else{
               $roel = db::name('back_social')->insert($dataAll);

                if ($roel !==false) {
                    $result['code'] = 1;
                    $result['msg'] = "添加成功";

                    return json($result);die;
                }else{
                    $result['code'] = 0;
                    $result['msg'] = "添加失败";

                    return json($result);die;
                }
            }



        }
    }

    public function examinedel()
    {

            $id = input("examine_id/a");

            $str = implode(",", $id);

            $ids = substr($str, 0, strrpos($str, ','));


            $data = Db::name("back_examine")->where("examine_id in ($ids)")->delete();

            if (null != $data) {
                $request = [
                    'msg' => '删除成功',
                    'code' => 1
                ];
            } else {
                $request = [
                    'msg' => '删除失败',
                    'code' => 0
                ];
            }

        return json_encode($request);die;
    }

    public function querydel()
    {
        $id=input("wid/a");

        $str = implode(",",$id) ;

        $ids = substr($str,0,strrpos($str,','));
        //var_dump($ids);die;

        $data=Db::name("back_wages")->where("wid in ($ids)")->delete();

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

    public function del()
    {
        $roleId = input('soc_id');

        $data = db('back_social')->where('soc_id','=',$roleId)->delete();

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

        return json($request);die;
    }
}