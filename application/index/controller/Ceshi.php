<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Loader;
use PHPExcel;

class Ceshi extends controller
{

    public function in()
    {
        $start = date('Y-m-01 00:00:00');
        var_dump($start);die;
        $end = date('Y-m-d H:i:s');
        //SELECT * FROM `table_name` WHERE `time` >= unix_timestamp('”.$start.”') AND `time` <= unix_timestamp('$end');
    }
    public function index()
    {
        return view('index');
    }

    public function add()
    {

        if (request()->isPost()) {

            vendor("PHPExcel");

            //设置文件上传的最大限制
            ini_set('memory_limit', '1024M');

            //防止乱码
            header("Content-type:text/html;charset=utf-8");


            $objPHPExcel = new \PHPExcel();

            $file = request()->file('file');

            if (empty($file)) {
                return $this->error('您未选择表格!!', url('ceshi/index'));
            }

            $file_types = explode(".", $_FILES ['file'] ['name']); // ["name"] => string(25) "excel文件名.xls"

            $file_type = $file_types [count($file_types) - 1];//xls后缀

            $file_name = $file_types [count($file_types) - 2];//xls去后缀的文件名

            /*判别是不是.xls文件，判别是不是excel文件*/
            if (strtolower($file_type) != "xls" && strtolower($file_type) != "xlsx") {
                return $this->error('不是xls或者不是xlsx类型结尾的!!', url('ceshi/index'));
                die;
            }

            $extension = strtolower(pathinfo($_FILES ['file']['name'], PATHINFO_EXTENSION));

            if ($extension == "xlsx") {
                //2007(相当于是打开接收的这个excel)
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            } else {
                //2003(相当于是打开接收的这个excel)
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }

            $objContent = $objReader->load($_FILES ['file']['tmp_name'], $encode = 'utf-8');

            $sheetContent = $objContent->getSheet(0)->toArray();
            //var_dump($sheetContent);die;
            unset($sheetContent[0]);

            foreach ($sheetContent as $k => $v) {

                $arr['fn'] = $v[1]; //档案号

                $arr['site'] = $v[2];

                $arr['name'] = $v[3];

                $arr['indate'] = $v[4];
                $arr['livedate'] = $v[5];
                $arr['salary'] = $v[6];
                $arr['insurance'] = $v[7];
                $arr['socialsecuritybegin'] = $v[8];
                $arr['socialsecuritystop'] = $v[9];
                $arr['accumulationfundcity'] = $v[10];
                $arr['accumulationfundbegin'] = $v[11];
                $arr['accumulationfundstop'] = $v[12];
                $arr['accumulationfundremarks'] = $v[13];
                $arr['station'] = $v[14];
                $arr['idnumber'] = $v[15];
                $arr['birthday'] = $v[16];
                $arr['age'] = $v[17];
                $arr['issite'] = $v[18];
                $arr['nowsite'] = $v[19];
                $arr['workstatus'] = $v[20];
                $arr['nowsitex'] = $v[21];
                $arr['mobile'] = $v[22];
                $arr['urgency'] = $v[23];
                $arr['urgencyrelation'] = $v[24];
                $arr['urgencymobile'] = $v[25];
                $arr['bankname'] = $v[26];
                $arr['banknumber'] = $v[27];
                $arr['contracttype'] = $v[28];
                $arr['contractstatus'] = $v[29];
                $arr['contractbegin'] = $v[30];
                $arr['contractend'] = $v[31];
                $arr['contractremark'] = $v[32];
                $arr['idcopy'] = $v[33];
                $arr['bankcardcopy'] = $v[34];
                $arr['staffentry'] = $v[35];
                $arr['confirmation'] = $v[36];
                $arr['social'] = $v[37];
                $arr['haining'] = $v[38];
                $arr['hourlyworke'] = $v[39];
                $arr['statement'] = $v[40];
                $arr['interview'] = $v[41];
                $arr['job'] = $v[42];
                $arr['employee'] = $v[43];
                $arr['directory'] = $v[44];
                $arr['registration'] = $v[45];
                $arr['training'] = $v[46];
                $arr['instructions'] = $v[47];
                $arr['agreement'] = $v[48];
                $res[] = $arr;
            }
            //die;
            $res = Db::name('back_query')->insertAll($res);
            if ($res) {
                echo "成功";
            } else {
                echo "失败";
            }

        }

    }

    //批量导入

    public function import_excel()
    {
        vendor("PHPExcel");
        vendor('PHPExcel.PHPExcel.Reader.Excel5');
        header("content-type:text/html;charset=utf-8");

        //上传excel文件

        $file = request()->file('file');

        //移到/public/uploads/excel/下

        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . 'excel');

        //上传文件成功

        if ($info) {

            //引入PHPExcel类


            //获取上传后的文件名

            $fileName = $info->getSaveName();

            //文件路径

            $filePath = 'public/uploads/excel/' . $fileName;

            //实例化PHPExcel类

            $PHPReader = new PHPExcel();

            //读取excel文件

            $objPHPExcel = $PHPReader::load($filePath);

            //读取excel文件中的第一个工作表

            $sheet = $objPHPExcel->getSheet(0);

            $allRow = $sheet->getHighestRow();  //取得总行数

            //$allColumn = $sheet->getHighestColumn();  //取得总列数

            //从第二行开始插入，第一行是列名

            for ($j = 2; $j <= $allRow; $j++) {

                $data['name'] = $objPHPExcel->getActiveSheet()->getCell("A" . $j)->getValue();

                $data['tel'] = $objPHPExcel->getActiveSheet()->getCell("B" . $j)->getValue();

                $data['addr'] = $objPHPExcel->getActiveSheet()->getCell("C" . $j)->getValue();
                var_dump($data);
                die;
                $last_id = Db::table('users')->insertGetId($data);//保存数据，并返回主键id

                if ($last_id) {

                    echo "第" . $j . "行导入成功，users表第:" . $last_id . "条！<br/>";

                } else {

                    echo "第" . $j . "行导入失败！<br/>";

                }

            }

        } else {

            echo "上传文件失败！";

        }
    }

    function upExecel()
    {

//判断是否选择了要上传的表格
        if (empty($_POST['myfile'])) {
            echo "<script>alert(您未选择表格);history.go(-1);</script>";
        }

//获取表格的大小，限制上传表格的大小5M
        $file_size = $_FILES['myfile']['size'];
        if ($file_size > 5 * 1024 * 1024) {
            echo "<script>alert('上传失败，上传的表格不能超过5M的大小');history.go(-1);</script>";
            exit();
        }

//限制上传表格类型
        $file_type = $_FILES['myfile']['type'];
//application/vnd.ms-excel  为xls文件类型
        if ($file_type != 'application/vnd.ms-excel') {
            echo "<script>alert('上传失败，只能上传excel2003的xls格式!');history.go(-1)</script>";
            exit();
        }

//判断表格是否上传成功
        if (is_uploaded_file($_FILES['myfile']['tmp_name'])) {
            require_once 'PHPExcel.php';
            require_once 'PHPExcel/IOFactory.php';
            require_once 'PHPExcel/Reader/Excel5.php';
            //以上三步加载phpExcel的类

            $objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
            //接收存在缓存中的excel表格
            $filename = $_FILES['myfile']['tmp_name'];
            $objPHPExcel = $objReader->load($filename); //$filename可以是上传的表格，或者是指定的表格
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            // $highestColumn = $sheet->getHighestColumn(); // 取得总列数

            //循环读取excel表格,读取一条,插入一条
            //j表示从哪一行开始读取  从第二行开始读取，因为第一行是标题不保存
            //$a表示列号
            for ($j = 2; $j <= $highestRow; $j++) {
                $a = $objPHPExcel->getActiveSheet()->getCell("A" . $j)->getValue();//获取A(业主名字)列的值
                $b = $objPHPExcel->getActiveSheet()->getCell("B" . $j)->getValue();//获取B(密码)列的值
                $c = $objPHPExcel->getActiveSheet()->getCell("C" . $j)->getValue();//获取C(手机号)列的值
                $d = $objPHPExcel->getActiveSheet()->getCell("D" . $j)->getValue();//获取D(地址)列的值

                //null 为主键id，自增可用null表示自动添加
                $sql = "INSERT INTO house VALUES(null,'$a','$b','$c','$d')";
                // echo "$sql";
                // exit();
                $res = mysql_query($sql);
                if ($res) {
                    echo "<script>alert('添加成功！');window.location.href='./test.php';</script>";

                } else {
                    echo "<script>alert('添加失败！');window.location.href='./test.php';</script>";
                    exit();
                }
            }
        }
        upExecel();
    }

//调用


    public function ce()
    {
        vendor("PHPExcel");
        vendor("PHPExcel.Classes.PHPExcel");
        vendor('PHPExcel . Classes . PHPExcel . IOFactory . PHPExcel_IOFactory');
        vendor('PHPExcel . Classes . PHPExcel . Reader . Excel5');
        $objPHPExcel = new \PHPExcel();
       // header("content-type:html")
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'excel');//上传验证后缀名,以及上传之后移动的地址
        //var_dump($info);die;
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
    
     if (!empty($v[0]) && !empty($v[0])) {
            //var_dump($v[0]);die;
         $wh['fn'] = $v[2];
          
         // var_dump($wh);die;
         //var_dump($wh);die;
        // $wh['is_deleted'] = '1';
         $res_info = db('back_query')->where($wh)->count();
         // var_dump($res_info);die;
         if ($res_info == 0) {
             $data = array(
                 'fn' => $v[1],
                 'site' => $v[2],

                'name' => $v[3]
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
             'fn' => $v[1],
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
 $success = db('back_query')->insertAll($datas); //批量插入数据
 var_dump($success);die;
 if ($success) {
     $cn_fail = count($data_errors);
     $content = "批量新增抽奖参与者名单记录：" . json_encode($data);
     $this->writelog($admin_id, $content, '4');//4出席成员
     $error = $cn - $success;
     $error_all = $error - $cn_fail;
     $data = array(
         'code' => 1,
         'message' => "总{$cn}条，导入成功{$success}条，其中失败{$cn_fail}条,重复{$error_all}条",
         'result' => $data_errors,
     );
     return json($data);
 }
 return json(['code' => 1, 'message' => "总{$cn}条，导入成功0条，其中重复{$repetition}条,失败{$errors_data}条", 'result' => $data_errors]);
} else {
            // 上传失败获取错误信息
            return json(['code' => 2, 'message' => '导入失败', 'result' => null]);
        }

    }


}



