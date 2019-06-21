<?php

namespace app\admin\controller;

use app\admin\model\ExcelModel;
use think\Controller;
use think\Request;
use think\Db;

class Admin extends Common
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

            $role = db('nine_admin')->alias('a')->where($where)->limit($tol,$limit)->select();

            $list = Db::name('nine_admin')->where($where)->select();

            $count = count($list);


            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;
            // var_dump($result);die;
            return json_encode($result);
        }
        $user = $this->user;
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

            $role = db('back_record')->where($where)->limit($tol,$limit)->order('re_id desc')->select();

            $list = Db::name('back_record')->where($where)->order('re_id desc')->select();

            $count = count($list);


            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;
            return json_encode($result);
        }

        $user = $this->user;

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

        $user = $this->user;
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

//    public function setManagement()
//    {
//
//        if (request()->isPost()){
//
//            //获取每页显示的条数
//            $limit= Request::instance()->param('limit');
//            //获取当前页数
//
//            $page= Request::instance()->param('page');
//
//            //计算出从那条开始查询
//            $tol=($page-1)*$limit;
//
//            //搜索
//            $porName = input('key');
//           // var_dump($porName);die;
//            $where = '1=1';
//
//            if (!empty($porName)){
//                $where.= " and por_name like '%".$porName."%' ";
//            }
//
//            //$data = db::table('nine_role')->select();
//
//            $role = db('back_project')->where($where)->limit($tol,$limit)->select();
//
//            $list = Db::name('back_project')->where($where)->select();
//
//            $count = count($list);
//
//            $result=array();
//            $result['code']=0;
//            $result['msg']="";
//            $result['count']=$count;
//            $result['data'] = $role;
//             //var_dump($result);die;
//            return json_encode($result);
//        }
//
//        return view('setManagement');
//    }

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

            $datas= $data['resume_data'];//这里可以任意格式，因为strtotime函数很强大

            $is_date=strtotime($datas)?strtotime($datas):false;

            if($is_date===false){
                $result = [
                    'code'  => -1,

                    'msg'  => '请输入正确的时间格式'
                ];

                return json_encode($result);die;
            }

            $all = [
                'resume_data' => isset($datas)?$datas:'',
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


            if (!empty($data['resume_id'])){
                $resulta = Db::name('back_resume')->where('resume_id', $data['resume_id'])->setField($all);
                if ($resulta !== false){
                    $result['code'] = 1;
                    $result['msg'] = "更新成功";

                    return json_encode($result);die;
                }else{
                    $result['code'] = 0;
                    $result['msg'] = "更新失败";

                    return json_encode($result);die;
                }
            }else{
                $role = db::name('back_resume')->insert($all);

                if ($role !== false){
                    $result=array();
                    $result['code']=1;
                    $result['msg']="添加成功";
                    $result['data'] = $role;
                    return json_encode($result);die;
                }else{
                    $result=array();
                    $result['code']=0;
                    $result['msg']="添加失败";
                    $result['data'] = $role;
                    return json_encode($result);die;
                }

            }

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

    public function addMission()
    {
        return view('addMission');
    }

    public function addMissto()
    {
        if (request()->isPost()){
            $data = input();
            if ($data['handle_name'] == ''){
                $requset = [
                    'code' => 1,
                    'error' => '名称不能为空'
                ];
                return json_encode($requset);die;
            }

            if ($data['handle_events'] == ''){
                $requset = [
                    'code'  => 1,
                    'error' => '事件名称不能为空'
                ];
                return json_encode($requset);die;
            }

            $results = [
                'handle_name' => $data['handle_name'],
                'handle_events' => $data['handle_events'],
                'time'         => time($data['time'])
            ];

            $list = Db::name('back_handle')->insert($results);

            $result=array();
            $result['code']=0;
            $result['msg']="";

            return json_encode($result);
        }
    }









    //测试
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
       //











        $time2 = strtotime(date('Y-m-d', strtotime("+30 day")));//获得一年之后的时间戳
        //var_dump($time2);die;
        $time3 = strtotime(date('Y-m-d', time()));//获得当前时间戳，用作对比
        //var_dump($time3);die;
        if ($time3 <= $time2) {
            echo '到期时间是：' . Date('Y-m-d', $time2);
            unset($time1);
        }
    }


    public function config()
    {
        $user = $this->user;
        //保险险种
        $insurance = db('insurance')->select();
        //公积金缴纳城市
        $fund = db('fund')->select();
        //代发银行
        $bankname = db('bankname')->select();
        //合同类型
        $contract = db('contract')->select();
        //项目点
        $sites = db::name('back_project')->select();

        return view('config',[
            'insurance'  => $insurance,
            'fund'       => $fund,
            'bankname'   => $bankname,
            'contract'   => $contract,
            'sites'      => $sites,
            'user'=>$user
        ]);
    }
    //项目点添加
    public function sitesadd()
    {
        $porName = input('name');

        $dataAll = [
            'por_name' => $porName
        ];
        $all = db::name('back_project')->where('por_name',$porName)->find();


            if ($porName==$all['por_name']) {
            db::name('back_project')->insert($dataAll);
                $res=array();
                $res['code']=0;
                $res['msg']="添加失败";
            return json($res);die;
            }else{
                db::name('back_project')->insert($dataAll);
                $res=array();
                $res['code']=1;
                $res['msg']="添加成功";
                return json($res);die;
            }
    }

    //项目点删除
    public function sitesdel()
    {
        if (request()->isPost()){
            $proId = input('name');

            $data = db::name('back_project')->where('pro_id',$proId)->delete();

            if ($data){
                $res=array();
                $res['code']=1;
                $res['msg']="删除成功";
                return json($res);die;
            }
        }
    }
    //保险险种管理
    public function insuranceadd()
    {
        $insuranceName = input('name');

        $dataAll = [
            'insurance_name' => $insuranceName
        ];
        $all = db::name('insurance')->where('insurance_name',$insuranceName)->find();


        if ($insuranceName==$all['insurance_name']) {
            db::name('insurance')->insert($dataAll);
            $res=array();
            $res['code']=0;
            $res['msg']="添加失败";
            return json($res);die;
        }else{
            db::name('insurance')->insert($dataAll);
            $res=array();
            $res['code']=1;
            $res['msg']="添加成功";
            return json($res);die;
        }
    }

    //保险险种管理删除
    public function insurancedel()
    {
        if (request()->isPost()){
            $insuranceId = input('name');

            $data = db::name('insurance')->where('insurance_id',$insuranceId)->delete();

            if ($data){
                $res=array();
                $res['code']=1;
                $res['msg']="删除成功";
                return json($res);die;
            }else{
                $res=array();
                $res['code']=0;
                $res['msg']="删除失败";
                return json($res);die;
            }
        }
    }

    //公积金缴纳城市管理
    public function fundadd()
    {
        $fundName = input('name');
        //var_dump($fundName);die;
        $dataAll = [
            'fund_name' => $fundName
        ];
        $all = db::name('fund')->where('fund_name',$fundName)->find();


        if ($fundName==$all['fund_name']) {
            db::name('fund')->insert($dataAll);
            $res=array();
            $res['code']=0;
            $res['msg']="添加失败";
            return json($res);die;
        }else{
            db::name('fund')->insert($dataAll);
            $res=array();
            $res['code']=1;
            $res['msg']="添加成功";
            return json($res);die;
        }
    }
    //公积金缴纳城市管理
    public function funddel()
    {
        if (request()->isPost()){
            $fundId = input('name');

            $data = db::name('fund')->where('fund_id',$fundId)->delete();

            if ($data){
                $res=array();
                $res['code']=1;
                $res['msg']="删除成功";
                return json($res);die;
            }else{
                $res=array();
                $res['code']=0;
                $res['msg']="删除失败";
                return json($res);die;
            }
        }
    }

    //代发银行管理
    public function backadd()
    {
        $backName = input('name');

        $dataAll = [
            'bank_name' => $backName
        ];
        $all = db::name('bankname')->where('bank_name',$backName)->find();


        if ($backName==$all['bank_name']) {
            db::name('bankname')->insert($dataAll);
            $res=array();
            $res['code']=0;
            $res['msg']="添加失败";
            return json($res);die;
        }else{
            db::name('bankname')->insert($dataAll);
            $res=array();
            $res['code']=1;
            $res['msg']="添加成功";
            return json($res);die;
        }
    }

    //代发银行管理
    public function backdel()
    {
        if (request()->isPost()){
            $bankId = input('name');

            $data = db::name('bankname')->where('bank_id',$bankId)->delete();

            if ($data){
                $res=array();
                $res['code']=1;
                $res['msg']="删除成功";
                return json($res);die;
            }else{
                $res=array();
                $res['code']=0;
                $res['msg']="删除失败";
                return json($res);die;
            }
        }
    }

    //合同
    public function contractadd()
    {

        $contractName = input('name');

        $all = db::name('contract')->where('contract_name',$contractName)->find();

        if (!$all) {
            $ht['contract_name']=$contractName;
            $addht=db::name('contract')->insert($ht);
            if($addht){
                $res['code']=1;
                $res['msg']="添加成功";
                return json($res);die;
            }else{
                $res['code']=0;
                $res['msg']="添加失败";
                return json($res);die;
            }
        }else{
            $res['code']=0;
            $res['msg']="合同已存在";
            return json($res);die;
        }
    }

    //合同
    public function contractdel()
    {
            $contractId = input('name');
            $data = db::name('contract')->where(['contract_id'=>$contractId])->delete();
            if ($data){
                $res['code']=1;
                $res['msg']="删除成功";
                return json($res);die;
            }else{
                $res['code']=0;
                $res['msg']="删除失败";
                return json($res);die;
            }
    }

    public function deletes()
    {
        $id=input("handle_id/a");

        $str = implode(",",$id) ;

        $ids = substr($str,0,strrpos($str,','));
        //var_dump($ids);die;

        $data=Db::name("back_handle")->where("handle_id in ($ids)")->delete();

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

    public function role(){
        if (request()->isPost()){
            $val = input('post.key');
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : 10;
            $list = Db::name('nine_power')
                ->order('power_id asc')
                ->where(['is_menu' => 0])
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            $res = $list['data'];
            $result= ['code' => 0, 'msg' => '', 'count' => $list['total'],'data' => $res];
            return json_encode($result);

        }else{
            $val = input('post.key');
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : 10;
            $list = Db::name('nine_power')
                ->order('power_id asc')
                ->where(['is_menu' => 0])
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            $res = $list['data'];
            $result= ['code' => 0, 'msg' => '', 'count' => $list['total'],'data' => $res];
            return view('role');
        }
    }

    public function role_list()
    {
        $val = input('post.key');
        $page = input('page') ? input('page') : 1;
        $pageSize = input('limit') ? input('limit') : 10;
        $list = Db::name('nine_power')
            ->order('power_id asc')
            ->where(['is_menu' => 0])
            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
            ->toArray();
        $res = $list['data'];
        $result= ['code' => 0, 'msg' => '', 'count' => $list['total'],'data' => $res];
        return json_encode($result);
    }

    public function role_del(){
        $data = input('post.');
        Db::table('nine_power')->delete(['power_id'=> $data['id']]);
        $result = ['code'=>0,'msg'=>'路由删除成功!'];
        return json($result);
    }

    public function role_pldel(){
        $data = input('post.');
        $id = '';
        foreach ($data as $k => $v){
            foreach ($v as $kk => $vv){
                $id[] = $vv['power_id'];
            }
        }
        Db::table('nine_power')->delete($id);
        $result = ['code'=>1,'msg'=>'路由删除成功!'];
        return json($result);
    }

    public function editrole()
    {
       if(request()->isPost()){
           $data = input('post.');
            $date = [
                'power_name' => $data['power_name'],
                'route' => $data['route']
            ];
            $role = db('nine_power')->where(['power_id'=> $data['power_id']])->update($date);

            $result=array();
            $result['code']=0;
            $result['msg']="";

            $result['data'] = $role;

            return json_encode($result);

        }
        $data = input('get.');
        $role = db::name('nine_power')->where(['power_id' => $data['power_id']])->find();

        return view('editAdmin', [
            'role' => $role
        ]);
    }

    public function addAdmin()
    {
        if(request()->isPost()){
            $data = input('post.');
            if(empty($data['pid'])){
                $date = [
                    'power_name' => $data['power_name'],
                    'route' => $data['route'],
                    'pid' => 0,
                    'status' => 0,
                    'is_menu' => 0
                ];
            }
            $date = [
                'power_name' => $data['power_name'],
                'route' => $data['route'],
                'pid' => $data['pid'],
                'status' => 0,
                'is_menu' => 0
            ];
            $role = db('nine_power')->insert($date);

            $result=array();
            $result['code']=0;
            $result['msg']="";

            $result['data'] = $role;

            return json_encode($result);

        }
        $role = db::name('nine_power')->where(['pid' => 0])->select();
        return view('addAdmin', [
            'role' => $role
        ]);
    }
}