<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\Loader;
use PHPExcel;

class Personnel extends Common
{
    public function resumes()
    {
        $user = $this->user;

        if (request()->isPost()){

            //获取每页显示的条数
            $limit= Request::instance()->param('limit');
            //获取当前页数
            $page= Request::instance()->param('page');

            //计算出从那条开始查询
            $tol=($page-1)*$limit;

            //搜索
            $resumeName = input('name');

            $where = '1=1';

            if (!empty($resumeName)){
                $where.= " and resume_name like '%".$resumeName."%' ";
            }

            $role = db::name('back_resume')->where($where)->limit($tol,$limit)->select();

            $list = db::name('back_resume')->where($where)->select();

            $count = count($list);

            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;

            return json_encode($result);

        }else{
            $sites = db::name('back_project')->select();

            return view('resumes',['user'=>$user,'sites'=>$sites]);
        }

    }

    public function del()
    {
        $user = $this->user;

        $roleId = input('resume_id');

        $data = db('back_resume')->where('role_id','=',$roleId)->delete();

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


    public function search()
    {
        $user = $this->user;
        $txuser= Request::instance()->param('txuser');
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
                $where.= " and resume_name like '%".$resumeName."%' ";
            }
            //搜索
            $resumeName = input('name');

            $resumeSite = input('site');

            $resumeStation = input('station');

            $resumeAge = input('age');
            //var_dump($resumeAge);die;
            $resumeIndate = input('indate');

            $idnumber = input('idnumber');

            $stats = substr($resumeIndate,0,strrpos($resumeIndate,' - '));
            $end = substr($resumeIndate,10,strrpos($resumeIndate,'- '));

            $where = '1=1';

            if (!empty($resumeName)){
                $where.= " and name like '%".$resumeName."%' ";
            }

            if (!empty($resumeSite)){
                $where.= " and site like '%".$resumeSite."%' ";
            }

            if (!empty($resumeAge)){
                $where.= " and age like '%".$resumeAge."%' ";
            }
            if (!empty($resumeStation)){
                $where.= " and station like '%".$resumeStation."%' ";
            }

            if (!empty($resumeIndate)){
                $where.= " and indate like '%".$resumeIndate."%' ";
            }

            if (!empty($idnumber)){
                $where.= " and idnumber = $idnumber";
            }

            if($txuser==1){//查询要退休的人员 男60 女50
                $wheres['age']=['egt',49];
                $lists=array();
                $role = db('back_query')->where($wheres)->limit($tol,$limit)->select();
                foreach ($role as $k=>$v){
                    if($v['sex']=="女"){
                        $times=strtotime($v['birthday']);//获得出生时的时间戳
                        $gqtime=strtotime("+50 year",$times);//获得退休时的时间戳
                        $nowtime=($gqtime-time())/86400;
                        if($nowtime<=30){
                            $lists[]=$role[$k];
                        }
                    }elseif ($v['sex']=="男"){
                        $times=strtotime($v['birthday']);//获得出生时的时间戳
                        $gqtime=strtotime("+60 year",$times);//获得退休时的时间戳
                        $nowtime=($gqtime-time())/86400;
                        if($nowtime<=30){
                            $lists[]=$role[$k];
                        }
                    }
                }
                $role = $lists;
                $list = $lists;
            }else{
                $role = db('back_query')->where($where)->limit($tol,$limit)->select();
                $list = Db::name('back_query')->where($where)->select();
            }



            if($stats&&$end){//如果提交了时间查询，那就对时间做处理
                $list=array();
                foreach ($role as $k=>$v){
                    $stime=strtotime($stats);
                    $etime=strtotime($end);

                    if($stime<=strtotime($v['indate'])&&strtotime($v['indate'])<$etime){
                        $list[]=$role[$k];
                    }elseif ($stime<=strtotime($v['livedate'])&&strtotime($v['livedate'])<$etime){
                        $list[]=$role[$k];
                    }elseif ($stime<=strtotime($v['socialsecuritybegin'])&&strtotime($v['socialsecuritybegin'])<$etime){
                        $list[]=$role[$k];
                    }elseif ($stime<=strtotime($v['socialsecuritystop'])&&strtotime($v['socialsecuritystop'])<$etime){
                        $list[]=$role[$k];
                    }elseif ($stime<=strtotime($v['accumulationfundbegin'])&&strtotime($v['accumulationfundbegin'])<$etime){
                        $list[]=$role[$k];
                    }elseif ($stime<=strtotime($v['accumulationfundstop'])&&strtotime($v['accumulationfundstop'])<$etime){
                        $list[]=$role[$k];
                    }elseif ($stime<=strtotime($v['birthday'])&&strtotime($v['birthday'])<$etime){
                        $list[]=$role[$k];
                    }elseif ($stime<=strtotime($v['contractbegin'])&&strtotime($v['contractbegin'])<$etime){
                        $list[]=$role[$k];
                    }elseif ($stime<=strtotime($v['contractend'])&&strtotime($v['contractend'])<$etime){
                        $list[]=$role[$k];
                    }
                }
                $role=$list;
            }








            $count = count($list);

            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;

            return json_encode($result);

        }else{
            $sites = db::name('back_project')->select();

            $insurance = db::name('insurance')->select();

            $fund = db('fund')->select();

            $bankname = db('bankname')->select();
            //合同类型
            $contract = db('contract')->select();

            return view('search',[
                'user'=>$user,
                'insurance'  => $insurance,
                'fund'       => $fund,
                'bankname'   => $bankname,
                'contract'   => $contract,
                'sites'      => $sites,
                'txuser'     => $txuser
            ]);
        }

    }






    public function personnel()
    {
        $user = $this->user;

        if (request()->isPost()){

            //获取每页显示的条数
            $limit= Request::instance()->param('limit');
            //获取当前页数
            $page= Request::instance()->param('page');

            //计算出从那条开始查询
            $tol=($page-1)*$limit;

            //搜索
            $resumeName = input('name');

            $resumeIDNumber = input('idnumber');

            $resumeDate = input('indate');

            $where = '1=1';

            if (!empty($resumeName)){
                $where.= " and name like '%".$resumeName."%' ";
            }

            if (!empty($resumeIDNumber)){
                $where.= " and idnumber like '%".$resumeIDNumber."%' ";
            }

            if (!empty($resumeDate)){
                $where.= " and indate like '%".$resumeDate."%' ";
            }

            $role = db('back_query')->where($where)->limit($tol,$limit)->select();
            //var_dump($role);die;
            $list = Db::name('back_query')->where($where)->select();

            $count = count($list);

            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;

            return json_encode($result);

        }else{
            $sites = db::name('back_project')->select();

            $insurance = db::name('insurance')->select();

            $fund = db('fund')->select();

            $bankname = db('bankname')->select();
            //合同类型
            $contract = db('contract')->select();

            return view('personnel',[
                'user'   => $user,
                'sites'  => $sites,
                'insurance' => $insurance,
                'fund' => $fund,
                'bankname' => $bankname,
                'contract' =>$contract
            ]);
        }

    }

    public function add()
    {
        vendor("PHPExcel");
        vendor('PHPExcel . Classes . PHPExcel . IOFactory . PHPExcel_IOFactory');
        vendor('PHPExcel . Classes . PHPExcel . Reader . Excel5');
        $objPHPExcel = new \PHPExcel();

        $file = request()->file('file');

        if (empty($file)) {
            return $this->error('您未选择表格!!', url('ceshi/index'));
        }

        $file_types = explode(".", $_FILES ['file'] ['name']); // ["name"] => string(25) "excel文件名.xls"

        $file_type = $file_types [count($file_types) - 1];//xls后缀
        //var_dump($file_type);die;
        $file_name = $file_types [count($file_types) - 2];//xls去后缀的文件名

        /*判别是不是.xls文件，判别是不是excel文件*/
        if (strtolower($file_type) != "xls" && strtolower($file_type) != "xlsx") {
            return $this->error('不是xls或者不是xlsx类型结尾的!!', url('ceshi/index'));
            die;
        }

        $info = $file->move('public/excel');

        if ($info) {

            header("Content-type:text/html;charset=utf-8");

            $fileName = $info->getSaveName();

            //文件路径

            $filePath = 'public/excel/' . $fileName;
            //var_dump($filePath);die;
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');

            $obj_PHPExcel = $objReader->load($_FILES ['file']['tmp_name'], $encode = 'utf-8');
//            var_dump($obj_PHPExcel);die;
            $excel_array = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
//            var_dump($excel_array);die;
            array_shift($excel_array);  //删除第一个数组(标题);
            $datas = [];
            $data_errors = [];
//处理Excel导入时数据为空的情况
            foreach ($excel_array as $k => $v) {
                if (!empty($v[0] || $v[1] || $v[2])) {
                    $excel_list[] = $v;
                }
            }
            $cn = count($excel_list);

//循环遍历，组装数据进行入库
            foreach ($excel_list as $k => $v) {

                if (!empty($v[0]) && !empty($v[1])) {

                    $wh['fn'] = $v[0];
//                    var_dump($wh);die;
                    $res_info = db('back_query')->where($wh)->count();
                    if ($res_info == 0) {
                        $data = array(
                        'fn' => $v[1], //档案号
                        'site' => $v[2],
                        'name' => $v[3],
                        'indate' => date('Y/m/d',strtotime($v[4])),
                        'livedate' => date('Y/m/d',strtotime($v[5])),
                        'salary' => $v[6],
                        'insurance' => $v[7],
                        'socialsecuritybegin' => $v[8],
                        'socialsecuritystop' => $v[9],
                        'accumulationfundcity' => $v[10],
                        'accumulationfundbegin' => $v[11],
                        'accumulationfundstop' => $v[12],
                        'accumulationfundremarks' => $v[13],
                        'station' =>  $v[14],
                        'idnumber' => $v[15],
                        'birthday' => $v[16],
                        'age' => $v[17],
                        'issite' => $v[18],
                        'nowsite' => $v[19],
                        'workstatus' => $v[20],
                        'nowsitex' => $v[21],
                        'mobile' => $v[22],
                        'urgency' => $v[23],
                        'urgencyrelation' => $v[24],
                        'urgencymobile' => $v[25],
                        'bankname' =>     $v[26],
                        'banknumber' =>   $v[27],
                        'contracttype' => $v[28],
                        'contractstatus' => $v[29],
                        'contractbegin' => $v[30],
                        'contractend' => $v[31],
                        'contractremark' => $v[32],
                        'idcopy' => $v[33],
                        'bankcardcopy' => $v[34],
                        'staffentry' => $v[35],
                        'confirmation' => $v[36],
                        'social' => $v[37],
                        'haining' => $v[38],
                        'hourlyworke' => $v[39],
                        'statement' => $v[40],
                        'interview' => $v[41],
                        'job' => $v[42],
                        'employee' => $v[43],
                        'directory' => $v[44],
                        'registration' => $v[45],
                        'training' => $v[46],
                        'instructions' => $v[47],
                        'agreement' => $v[48]
                            // 'user_name' => $v[1],
                            // 'department' => $v[2],
                            // 'create_id' => $admin_id,
                            // 'create_time' => date('Y - m - d H:i:s'),
                        );
                        $datas[] = $data;
//                        var_dump($datas);die;
                    }

                } else {
                    $error_data = array(
                        'fn' => $v[0],
                    );
                    $data_errors[] = $error_data;

                }

            }
            $errors_data = count($data_errors);
            $repetition = $cn - $errors_data;

            $dateAll = db('back_query')->where('idnumber',$datas[0]['idnumber'])->find();

            if($dateAll['idnumber']==$datas[0]['idnumber']){

                $result = [
                    'code' => -1
                ];


                $success = db('back_querys')->insertAll($datas); //批量插入数据

                $result=array();
                $result['code']=-1;
                $result['msg']="导入失败";
                //$result['data']=$success;;

                return json_encode($result);die;
            }else{

                $success = db('back_query')->insertAll($datas); //批量插入数据

                $result=array();
                $result['code']=1;
                $result['msg']="导入成功";
                $result['data']=$success;;
                return json_encode($result);die;
            }
        }else{

        }
    }


    public function dell()
    {

        $roleId = input('query_id');

        $data = db('back_query')->where('query_id','=',$roleId)->delete();

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

    //导出
    public function export()
    {
        vendor("PHPExcel");

        $excel = new PHPExcel();

        $sheet = $excel ->getActiveSheet();


        $sheet->setCellValue('A1', '序号')
              ->setCellValue('B1', '档案号')
             ->setCellValue('C1', '项目点名称')
             ->setCellValue('D1', '员工姓名')
             ->setCellValue('E1', '入职日期')
             ->setCellValue('F1', '离职日期')
             ->setCellValue('G1', '基本工资')
             ->setCellValue('H1', '保险险种')
             ->setCellValue('I1', '社保起缴月份')
             ->setCellValue('J1', '社保停缴月份')
             ->setCellValue('K1', '公积金缴纳城市')
             ->setCellValue('L1', '公积金起缴月份')
             ->setCellValue('M1', '公积金停纳缴份')
             ->setCellValue('N1', '社保公积金备注')
             ->setCellValue('O1', '岗位')
             ->setCellValue('P1', '身份证号码')
             ->setCellValue('Q1', '出生日期')
             ->setCellValue('R1', '年龄')
             ->setCellValue('S1', '性别')
             ->setCellValue('T1', '户籍地址')
             ->setCellValue('W1', '现居住地址')
             ->setCellValue('X1', '用工形式')
             ->setCellValue('Y1', '现住地址')
             ->setCellValue('Z1', '联系方式')
             ->setCellValue('AA1', '紧急联系人')
             ->setCellValue('AB1', '与紧急联系人的关系')
             ->setCellValue('AC1', '紧急联系人电话')
             ->setCellValue('AD1', '代发银行')
             ->setCellValue('AE1', '银行卡号')
             ->setCellValue('AF1', '合同类型')
             ->setCellValue('AG1', '是否签订')
             ->setCellValue('AH1', '合同开始时间')
             ->setCellValue('AI1', '合同结束时间')
             ->setCellValue('AJ1', '合同备注')
             ->setCellValue('AK1', '身份证复印件')
             ->setCellValue('AL1', '银行卡复印件')
             ->setCellValue('AM1', '员工入职材料清单')
             ->setCellValue('AN1', '乙方确认函')
             ->setCellValue('AO1', '社保承诺书')
             ->setCellValue('AP1', '海宁缴保声明')
             ->setCellValue('AQ1', '小时工声明')
             ->setCellValue('AR1', '员工需求表')
             ->setCellValue('AS1', '面试记录表')
             ->setCellValue('AT1', '工作申请表')
             ->setCellValue('AU1', '员工手册B类签收单')
             ->setCellValue('AV1', '员工档案目录')
             ->setCellValue('AW1', '基层员工登记表')
             ->setCellValue('AX1', '培训反馈表')
             ->setCellValue('AY1', '员工须知')
             ->setCellValue('AZ1', '上岗协议');

        $data = db::name('back_query')->select();

        $i=2;
        foreach($data as $key=>$v){
                $sheet->setCellValue('A'.$i,$v['query_id']);
                $sheet->setCellValue('B'.$i,$v['fn']);
                 $sheet->setCellValue('C'.$i,$v['site']);
                 $sheet->setCellValue('D'.$i,$v['name']);
                 $sheet->setCellValue('E'.$i,$v['indate']);
                 $sheet->setCellValue('F'.$i,$v['livedate']);
                 $sheet->setCellValue('G'.$i,$v['salary']);
                 $sheet->setCellValue('H'.$i,$v['insurance']);
                 $sheet->setCellValue('I'.$i,$v['socialsecuritybegin']);
                 $sheet->setCellValue('J'.$i,$v['socialsecuritystop']);
                 $sheet->setCellValue('K'.$i,$v['accumulationfundcity']);
                 $sheet->setCellValue('L'.$i,$v['accumulationfundbegin']);
                 $sheet->setCellValue('M'.$i,$v['accumulationfundstop']);
                 $sheet->setCellValue('N'.$i,$v['accumulationfundremarks']);
                 $sheet->setCellValue('O'.$i,$v['station']);
                 $sheet->setCellValue('P'.$i,$v['idnumber']);
                 $sheet->setCellValue('Q'.$i,$v['birthday']);
                 $sheet->setCellValue('R'.$i,$v['age']);
                 $sheet->setCellValue('S'.$i,$v['sex']);
                 $sheet->setCellValue('T'.$i,$v['issite']);
                 $sheet->setCellValue('W'.$i,$v['nowsite']);
                 $sheet->setCellValue('X'.$i,$v['workstatus']);
                 $sheet->setCellValue('Y'.$i,$v['nowsitex']);
                 $sheet->setCellValue('Z'.$i,$v['mobile']);
                 $sheet->setCellValue('AA'.$i,$v['urgency']);
                 $sheet->setCellValue('AB'.$i,$v['urgencyrelation']);
                 $sheet->setCellValue('AC'.$i,$v['urgencymobile']);
                 $sheet->setCellValue('AD'.$i,$v['bankname']);
                 $sheet->setCellValue('AE'.$i,$v['banknumber']);
                 $sheet->setCellValue('AF'.$i,$v['contracttype']);
                 $sheet->setCellValue('AG'.$i,$v['contractstatus']);
                 $sheet->setCellValue('AH'.$i,$v['contractbegin']);
                 $sheet->setCellValue('AI'.$i,$v['contractend']);
                 $sheet->setCellValue('AJ'.$i,$v['contractremark']);
                 $sheet->setCellValue('AK'.$i,$v['idcopy']);
                 $sheet->setCellValue('AL'.$i,$v['bankcardcopy']);
                 $sheet->setCellValue('AM'.$i,$v['staffentry']);
                 $sheet->setCellValue('AN'.$i,$v['confirmation']);
                 $sheet->setCellValue('AO'.$i,$v['social']);
                 $sheet->setCellValue('AP'.$i,$v['haining']);
                 $sheet->setCellValue('AQ'.$i,$v['hourlyworke']);
                 $sheet->setCellValue('AR'.$i,$v['statement']);
                 $sheet->setCellValue('AS'.$i,$v['interview']);
                 $sheet->setCellValue('AT'.$i,$v['job']);
                 $sheet->setCellValue('AU'.$i,$v['employee']);
                 $sheet->setCellValue('AV'.$i,$v['directory']);
                 $sheet->setCellValue('AW'.$i,$v['registration']);
                 $sheet->setCellValue('AX'.$i,$v['training']);
                 $sheet->setCellValue('AAY'.$i,$v['instructions']);
                 $sheet->setCellValue('AAZ'.$i,$v['agreement']);
            $i++;
        }
        //var_dump($sheet);die;
        $files = '人员查询'.date('Y-m-d H:i:s');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$files.'.xls"');
        $objWriter = \PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function delete()
    {
        $id=input("query_id/a");

        $str = implode(",",$id) ;

        $ids = substr($str,0,strrpos($str,','));
        //var_dump($ids);die;

        $data=Db::name("back_query")->where("query_id in ($ids)")->delete();
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

    public function deltes()
    {
        $roleId = input('query_id');

        $data = db('back_query')->where('query_id','=',$roleId)->delete();

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

    public function import()
    {
//        echo 111;die;
        vendor("PHPExcel");
        vendor('PHPExcel . Classes . PHPExcel . IOFactory . PHPExcel_IOFactory');
        vendor('PHPExcel . Classes . PHPExcel . Reader . Excel5');
        $objPHPExcel = new \PHPExcel();

        $file = request()->file('file');

        if (empty($file)) {
            return $this->error('您未选择表格!!', url('ceshi/index'));
        }

        $file_types = explode(".", $_FILES ['file'] ['name']); // ["name"] => string(25) "excel文件名.xls"

        $file_type = $file_types [count($file_types) - 1];//xls后缀
        //var_dump($file_type);die;
        $file_name = $file_types [count($file_types) - 2];//xls去后缀的文件名

        /*判别是不是.xls文件，判别是不是excel文件*/
        if (strtolower($file_type) != "xls" && strtolower($file_type) != "xlsx") {
            return $this->error('不是xls或者不是xlsx类型结尾的!!', url('ceshi/index'));
            die;
        }

        $info = $file->move('public/excel');

        if ($info) {

            header("Content-type:text/html;charset=utf-8");

            $fileName = $info->getSaveName();

            //文件路径
            $filePath = 'public/excel/' . $fileName;

            $objReader = \PHPExcel_IOFactory::createReader('Excel5');

            //echo "<pre/>";
            //print_r($filePath);

            $obj_PHPExcel = $objReader->load($filePath, $encode = 'utf-8');

            //echo "<pre/>";
            //print_r($file);

            $excel_array = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式

//            print_r($excel_array);die;


            array_shift($excel_array);  //删除第一个数组(标题);

            $datas = [];

            $data_errors = [];
//处理Excel导入时数据为空的情况
            foreach ($excel_array as $k => $v) {
                if (!empty($v[0] || $v[1] || $v[2])) {
                    $excel_list[] = $v;
                }
            }
            $cn = count($excel_list);

//循环遍历，组装数据进行入库
            foreach ($excel_list as $k => $v) {

                if (!empty($v[0]) && !empty($v[1])) {

                    $wh['resume_data'] = $v[0];
//                    var_dump($wh);die;
                    $res_info = db('back_resume')->where($wh)->count();
                    if ($res_info == 0) {
                        $data = array(
                            'resume_data' => $v[0], //档案号

                            'resume_dq' => $v[1],

                            'resume_zw' => $v[2],

                            'resume_xmd' => $v[3],
                            'resume_name' => $v[4],
                            'resume_xb' => $v[5],
                            'resume_age' => $v[6],
                            'resume_xl' => $v[7],
                            'resume_gzjx' => $v[8],
                            'resume_qwzw' => $v[9],
                            'resume_qwdd' => $v[10],
                            'resume_qwxz' => $v[11],
                            'resume_tel' => $v[12],
                            'resume_bz' => $v[13],
                        );
                        $datas[] = $data;

                         var_dump($datas);die;
                    }
                } else {
                    $error_data = array(
                        'resume_data' => $v[0],
                    );
                    $data_errors[] = $error_data;

                }

            }
            $errors_data = count($data_errors);
            $repetition = $cn - $errors_data;

            $success = db('back_resume')->insert($datas);die; //批量插入数据
            $dateAll = db('back_resume')->where('idnumber',$datas[0]['idnumber'])->find();
            //var_dump($dateAll);die;
            if($dateAll=$datas[0]['idnumber']){
                $result = [
                    'code' => 1
                ];

                return json_encode($result);die;

                $success = db('back_query')->insertAll($datas); //批量插入数据
               // var_dump($success);die;
                $result=array();
                $result['code']=0;
                $result['msg']="";

                $result['data'] = $success;
                return json_encode($result);die;
            }else{
                $success = db('back_resume')->insertAll($datas); //批量插入数据
                $result=array();
                $result['file']=$filePath;
                $result['code']=1;
                $result['msg']="";

                $result['data'] = $success;

                return json_encode($result);die;
            }
        }else{

        }
    }

    public function addto()
    {
        if (request()->isPost()){

            $v = input();
           // var_dump($v);die;

            $dataAll = [
                'fn' => isset($v['fn'])?$v['fn']:'', //档案号
                'site' => isset($v['site'])?$v['site']:'',
                'name' => isset($v['name'])?$v['name']:'',
                'indate' => isset($v['indate'])?$v['indate']:'',
                'livedate' => isset($v['livedate'])?$v['livedate']:'',
                'salary' => isset($v['salary'])?$v['salary']:'',
                'insurance' => isset($v['insurance'])?$v['insurance']:'',
                'socialsecuritybegin' => isset($v['socialsecuritybegin'])?$v['socialsecuritybegin']:'',
                'socialsecuritystop' => isset($v['socialsecuritystop'])?$v['socialsecuritystop']:'',
                'accumulationfundcity' => isset($v['accumulationfundcity'])?$v['accumulationfundcity']:'',
                'accumulationfundbegin' => isset($v['accumulationfundbegin'])?$v['accumulationfundbegin']:'',
                'accumulationfundstop' => isset($v['accumulationfundstop'])?$v['accumulationfundstop']:'',
                'accumulationfundremarks' => isset($v['accumulationfundremarks'])?$v['accumulationfundremarks']:'',
                'station' =>  isset($v['station'])?$v['station']:'',
                'idnumber' => isset($v['idnumber'])?$v['idnumber']:'',
                'birthday' => isset($v['birthday'])?$v['birthday']:'',
                'age' => isset($v['age'])?$v['age']:'',
                'issite' => isset($v['issite'])?$v['issite']:'',
                'nowsite' => isset($v['nowsite'])?$v['nowsite']:'',
                'workstatus' => isset($v['workstatus'])?$v['workstatus']:'',
                'nowsitex' => isset($v['nowsitex'])?$v['nowsitex']:'',
                'mobile' => isset($v['mobile'])?$v['mobile']:'',
                'urgency' => isset($v['urgency'])?$v['urgency']:'',
                'urgencyrelation' => isset($v['urgencyrelation'])?$v['urgencyrelation']:'',
                'urgencymobile' => isset($v['urgencymobile'])?$v['urgencymobile']:'',
                'bankname' =>     isset($v['bankname'])?$v['bankname']:'',
                'banknumber' =>   isset($v['banknumber'])?$v['banknumber']:'',
                'contracttype' => isset($v['contracttype'])?$v['contracttype']:'',
                'contractstatus' => isset($v['contractstatus'])?$v['contractstatus']:'',
                'contractbegin' => isset($v['contractbegin'])?$v['contractbegin']:'',
                'contractend' => isset($v['contractend'])?$v['contractend']:'',
                'contractremark' => isset($v['contractremark'])?$v['contractremark']:'',
                'idcopy' => isset($v['idcopy'])?$v['idcopy']:'',
                'bankcardcopy' => isset($v['bankcardcopy'])?$v['bankcardcopy']:'',
                'staffentry' => isset($v['staffentry'])?$v['staffentry']:'',
                'confirmation' => isset($v['confirmation'])?$v['confirmation']:'',
                'social' => isset($v['social'])?$v['social']:'',
                'haining' => isset($v['haining'])?$v['haining']:'',
                'hourlyworke' => isset($v['hourlyworke'])?$v['hourlyworke']:'',
                'statement' => isset($v['statement'])?$v['statement']:'',
                'interview' => isset($v['interview'])?$v['interview']:'',
                'job' => isset($v['job'])?$v['job']:'',
                'employee' => isset($v['employee'])?$v['employee']:'',
                'directory' => isset($v['directory'])?$v['directory']:'',
                'registration' => isset($v['registration'])?$v['registration']:'',
                'training' => isset($v['training'])?$v['training']:'',
                'instructions' => isset($v['instructions'])?$v['instructions']:'',
                'agreement' => isset($v['agreement'])?$v['agreement']:''
            ];



            if (isset($v['query_id'])){

                $res = db::name('back_query')->where('query_id',$v['query_id'])->update($dataAll);
                return msg(1,$res,'');
            }else{
                $list = db::name('back_query')->insert($dataAll);
                return msg(1,$list,'');
            }
        }
    }

    public function powerDel()
    {
        $id=input("query_id/a");

        $str = implode(",",$id) ;

        $ids = substr($str,0,strrpos($str,','));


        $data=Db::name("back_query")->where("query_id in ($ids)")->delete();

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

    public function powerAdd()
    {
        echo 111;die;
    }

    public function perDel()
    {
        $roleId = input('query_id');

        $data = db('back_query')->where('query_id','=',$roleId)->delete();

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
}
