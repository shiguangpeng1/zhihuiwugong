<?php

namespace app\admin\Controller;

use think\Controller;
use think\Request;
use think\Db;
use think\Loader;
use PHPExcel;

class Personnel extends Controller
{
    public function resumes()
    {
        $user = session('admin');

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

            $role = db('back_resume')->where($where)->limit($tol,$limit)->select();
            //var_dump($role);die;
            $list = Db::name('back_resume')->where($where)->select();

            $count = count($list);

            $result=array();
            $result['code']=0;
            $result['msg']="";
            $result['count']=$count;
            $result['data'] = $role;

            return json_encode($result);

        }
        return view('resumes',['user'=>$user]);
    }

    public function del()
    {
        $user = session('admin');

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
        $user = session('admin');

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

        }
        return view('search',['user'=>$user]);
    }



    public function personnel()
    {
        $user = session('admin');

        if (request()->isPost()){

            //获取每页显示的条数
            $limit= Request::instance()->param('limit');
            //获取当前页数
            $page= Request::instance()->param('page');

            //计算出从那条开始查询
            $tol=($page-1)*$limit;

            //搜索
            $resumeName = input('name');
            //var_dump($resumeName);die;
            $resumeIDNumber = input('idnumber');

            $resumeDate = input('date');

            $where = '1=1';

            if (!empty($resumeName)){
                $where.= " and name like '%".$resumeName."%' ";
            }

            if (!empty($resumeIDNumber)){
                $where.= " and idnumber like '%".$resumeIDNumber."%' ";
            }

            if (!empty($resumedate)){
                $where.= " and date like '%".$resumedate."%' ";
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

        }
        return view('personnel',['user'=>$user]);
    }

    public function add()
    {
        vendor("PHPExcel");
        vendor("PHPExcel.Classes.PHPExcel");
        vendor('PHPExcel . Classes . PHPExcel . IOFactory . PHPExcel_IOFactory');
        vendor('PHPExcel . Classes . PHPExcel . Reader . Excel5');
        $objPHPExcel = new \PHPExcel();
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'excel');
        if ($info) {

            header("Content-type:text/html;charset=utf-8");

            $fileName = $info->getSaveName();

            //文件路径

            $filePath = 'public/excel/' . $fileName;

            $objReader = \PHPExcel_IOFactory::createReader('Excel5');

            $obj_PHPExcel = $objReader->load($_FILES ['file']['tmp_name'], $encode = 'utf-8');

            $excel_array = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
            // var_dump($excel_array);die;
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

                    $wh['fn'] = $v[2];

                    $res_info = db('back_query')->where($wh)->count();
                    if ($res_info == 0) {
                        $data = array(
                            'fn' => $v[1], //档案号

                        'site' => $v[2],

                        'name' => $v[3],

                        'indate' => $v[4],
                        'livedate' => $v[5],
                        'salary' => $v[6],
                        'insurance' => $v[7],
                        'socialsecuritybegin' => $v[8],
                        'socialsecuritystop' => $v[9],
                        'accumulationfundcity' => $v[10],
                        'accumulationfundbegin' => $v[11],
                        'accumulationfundstop' => $v[12],
                        'accumulationfundremarks' => $v[13],
                        'station' => $v[14],
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
                        'bankname' => $v[26],
                        'banknumber' => $v[27],
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

                        // var_dump($datas);die;
                    }
                } else {
                    $error_data = array(
                        'fn' => $v[0],
                        // 'user_name' => $v[1],
                        // 'department' => $v[2],
                        // 'create_id' => $admin_id,
                        // 'create_time' => date('Y - m - d H:i:s'),
                    );
                    $data_errors[] = $error_data;

                }

            }
            $errors_data = count($data_errors);
            $repetition = $cn - $errors_data;
            $idnumber = db('back_query')->column('idnumber');
           // var_dump($idnumber);die;
            $dateAll = db('back_query')->where('idnumber',$idnumber[0])->find();
            //var_dump($dateAll);die;
            if($dateAll==$idnumber[0]){
                $success = db('back_query')->insertAll($datas); //批量插入数据
                $result=array();
                $result['code']=0;
                $result['msg']="";

                $result['data'] = $success;
                return json_encode($result);die;
            }else{
                $success = db('back_querys')->insertAll($datas); //批量插入数据
                $result=array();
                $result['code']=0;
                $result['msg']="";

                $result['data'] = $success;
               // return json_encode($result);die;
            }



        }else{

        }
    }


    public function dell()
    {
        //user = session('admin');

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
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="人员查询.xls"');
        $objWriter = \PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $objWriter->save('php://output');
    }
}