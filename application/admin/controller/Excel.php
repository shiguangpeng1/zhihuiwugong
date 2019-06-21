<?php

namespace app\admin\controller;

use app\admin\model\ExcelModel;
use think\Cache;
use think\Controller;
use think\Request;
use think\Db;
use think\response\Json;
use think\Session;

class Excel extends Common
{



    //人员简历导入
    public function up_resume()
    {
        $file=Request::instance()->file('file');

        if(empty($file)){
            $data['code']=0;
            $data['msg']="请上传文件";
            return json($data);
            exit();
        }

        $info = $file->validate(['ext'=>'xls,xlsx'])->move(ROOT_PATH . 'public' . DS . 'Uploads/file');
        if($info){
            $filename = $info->getSaveName();
            $allurl=ROOT_PATH . 'public' . DS . 'Uploads/file/'.$filename;
        }else{
            // 上传失败获取错误信息
            $data['code']=0;
            $data['msg']=$file->getError();
            return json($data);
            exit();
        }
        //处理数据
        $update=new ExcelModel();
        $upfile=$update->importExecl($allurl);//传入完整的文件路径，返回的数据从下表2开始处理
        Db::startTrans();
        for ($i=2;$i<=count($upfile);$i++){
            if(empty($upfile[$i]['E'])){
                $data['code']=0;
                $data['msg']=$i."行信息不完善";
                Db::rollback();
                return json($data);
                exit();
            }
            $datas['resume_data']=$upfile[$i]['A'];
            $datas['resume_dq']=$upfile[$i]['B'];
            $datas['resume_zw']=$upfile[$i]['C'];
            $datas['resume_xmd']=$upfile[$i]['D'];
            $datas['resume_name']=$upfile[$i]['E'];
            $datas['resume_xb']=$upfile[$i]['F'];
            $datas['resume_age']=$upfile[$i]['G'];
            $datas['resume_xl']=$upfile[$i]['H'];
            $datas['resume_gzjx']=$upfile[$i]['I'];
            $datas['resume_qwzw']=$upfile[$i]['J'];
            $datas['resume_qwdd']=$upfile[$i]['K'];
            $datas['resume_qwxz']=$upfile[$i]['L'];
            $datas['resume_tel']=$upfile[$i]['M'];
            $datas['resume_bz']=$upfile[$i]['N'];
            $updatas=Db::name('back_resume')->insertGetId($datas);
            if(!$updatas){
                $data['code']=0;
                $data['msg']=$i."行插入失败";
                Db::rollback();
                return json($data);
                exit();
            }
        }

        $data['code']=1;
        $data['msg']=$i."行数据执行完成";
        Db::commit();
        return json($data);
        exit();
    }



    //人员管理导入
    public function up_per()
    {
        $file=Request::instance()->file('file');
        $types=Request::instance()->param('types');//类型名称：1跳过 2重复导入
        if(empty($file) && Cache::get('up_per')===false){
            $data['code']=0;
            $data['msg']="请上传文件";
            return json($data);
            exit();
        }
        if(!empty($file)){
            $info = $file->validate(['ext'=>'xls,xlsx'])->move(ROOT_PATH . 'public' . DS . 'Uploads/file');
            if($info){
                $filename = $info->getSaveName();
                $allurl=ROOT_PATH . 'public' . DS . 'Uploads/file/'.$filename;
            }else{
                // 上传失败获取错误信息
                $data['code']=0;
                $data['msg']=$file->getError();
                return json($data);
                exit();
            }
            //处理数据
            $update=new ExcelModel();
            $upfile=$update->importExecl($allurl);//传入完整的文件路径，返回的数据从下表2开始处理
            $arr=['list'=>$upfile,'count'=>count($upfile)];
            Cache::set('up_per',$arr);
            /*dump(Cache::get('up_per'));
            exit();*/
            $a=3;
        }else{
            $upfile=Cache::get('up_per');
            $a=Cache::get('up_pernum');
        }


        Db::startTrans();
        for ($i=$a;$i<=count($upfile);$i++){
            if(empty($upfile[$i]['A'])||empty($upfile[$i]['B'])||empty($upfile[$i]['C'])){
                $data['code']=0;
                $data['msg']=$i."行信息不完善";
                Db::rollback();
                return json($data);
                exit();
            }

             if(empty($types)){//如果没有传类型，正常执行添加
                 /* 执行档案号和身份证号是否有重复的判断*/
                 $dah=Db::name('back_query')->where(['fn'=>$upfile[$i]['A']])->find();
                 if($dah){
                     $data['code']=2;
                     $data['msg']=$i."行档案号信息重复";
                     Db::rollback();
                     return json($data);
                     exit();
                 }
                 $sfz=Db::name('back_query')->where(['idnumber'=>$upfile[$i]['O']])->find();
                 if($sfz){
                     $data['code']=2;
                     $data['msg']=$i."行身份证重复";
                     Db::rollback();
                     return json($data);
                     exit();
                 }
             }

            $datas['fn']=$upfile[$i]['A'];
            $datas['site']=$upfile[$i]['B'];
            $datas['name']=$upfile[$i]['C'];
            $datas['indate']=$upfile[$i]['D'];
            $datas['livedate']=$upfile[$i]['E'];
            $datas['salary']=$upfile[$i]['F'];
            $datas['insurance']=$upfile[$i]['G'];
            $datas['socialsecuritybegin']=$upfile[$i]['H'];
            $datas['socialsecuritystop']=$upfile[$i]['I'];
            $datas['accumulationfundcity']=$upfile[$i]['J'];
            $datas['accumulationfundbegin']=$upfile[$i]['K'];
            $datas['accumulationfundstop']=$upfile[$i]['L'];
            $datas['accumulationfundremarks']=$upfile[$i]['M'];
            $datas['station']=$upfile[$i]['N'];
            $datas['idnumber']=$upfile[$i]['O'];
            $datas['birthday']=$upfile[$i]['P'];
            $datas['age']=$upfile[$i]['Q'];
            $datas['sex']=$upfile[$i]['R'];
            $datas['issite']=$upfile[$i]['S'];
            $datas['nowsite']=$upfile[$i]['T'];
            $datas['workstatus']=$upfile[$i]['U'];
            $datas['nowsitex']=$upfile[$i]['V'];
            $datas['mobile']=$upfile[$i]['W'];
            $datas['urgency']=$upfile[$i]['X'];
            $datas['urgencyrelation']=$upfile[$i]['Y'];
            $datas['urgencymobile']=$upfile[$i]['Z'];
            $datas['bankname']=$upfile[$i]['AA'];
            $datas['banknumber']=$upfile[$i]['AB'];
            $datas['contracttype']=$upfile[$i]['AC'];
            $datas['contractstatus']=$upfile[$i]['AD'];
            $datas['contractbegin']=$upfile[$i]['AE'];
            $datas['contractend']=$upfile[$i]['AF'];
            $datas['contractremark']=$upfile[$i]['AG'];
            $datas['idcopy']=$upfile[$i]['AH'];
            $datas['bankcardcopy']=$upfile[$i]['AI'];
            $datas['staffentry']=$upfile[$i]['AJ'];
            $datas['confirmation']=$upfile[$i]['AK'];
            $datas['social']=$upfile[$i]['AL'];
            $datas['haining']=$upfile[$i]['AM'];
            $datas['hourlyworke']=$upfile[$i]['AN'];
            $datas['statement']=$upfile[$i]['AO'];
            $datas['interview']=$upfile[$i]['AP'];
            $datas['job']=$upfile[$i]['AQ'];
            $datas['employee']=$upfile[$i]['AR'];
            $datas['directory']=$upfile[$i]['AS'];
            $datas['registration']=$upfile[$i]['AT'];
            $datas['training']=$upfile[$i]['AU'];
            $datas['instructions']=$upfile[$i]['AV'];
            $datas['agreement']=$upfile[$i]['AW'];

            if(empty($types)){//正常添加数据
                $updatas=Db::name('back_query')->insertGetId($datas);
                if(!$updatas){
                    $data['code']=0;
                    $data['msg']=$i."行插入失败";
                    Db::rollback();
                    return json($data);
                    exit();
                }
            }elseif ($types==2){//重复导入
                $updatas=Db::name('back_query')->insertGetId($datas);
                if(!$updatas){
                    $data['code']=0;
                    $data['msg']=$i."行插入失败";
                    Db::rollback();
                    return json($data);
                    exit();
                }
            }
            Cache::set('up_pernum',$i);
        }

        $data['code']=1;
        $data['msg']=$i."行数据执行完成";
        Db::commit();
        Cache::rm('up_pernum');
        Cache::rm('up_per');
        return json($data);
        exit();
    }







    //人员管理导出
    public function out_per()
    {
        $userdata=Db::name('back_query')->select();
        foreach ($userdata as $k=>$v){
            unset($userdata[$k]['query_id']);
        }
        $title=['档案号','项目地点','员工姓名','入职日期','离职日期','基本工资','保险险种','社保起缴月份','社保停缴月份','公积金缴纳城市','公积金起缴月份','公积金停缴月份','社保公积金备注','岗位','身份证号','出生日期','年龄','性别','户籍地址','现居住地址','用工形式','现住地址','联系方式','紧急联系人','与紧急联系人关系','紧急联系人电话','代发银行','银行卡号','合同类型','是否签订','合同开始日期','合同结束日期','合同备注','身份证复印件','银行卡复印件','员工入职材料清单','乙方确认函','社保承诺书','海宁缴保声明','小时工声明','员工需求表','面试记录表','工作申请表','员工手册B类签收单','员工档案目录','基层员工等级表','培训反馈表','员工须知','上岗协议'];
        $dowexcel=new ExcelModel();
        $dowexcel->exportExcel($title,$userdata,"人员管理数据",'./',true);
    }




    //工资核算提交导入
    public function up_sub()
    {
        $file=Request::instance()->file('file');

        if(empty($file)){
            $data['code']=0;
            $data['msg']="请上传文件";
            return json($data);
            exit();
        }

        $info = $file->validate(['ext'=>'xls,xlsx'])->move(ROOT_PATH . 'public' . DS . 'Uploads/file');
        if($info){
            $filename = $info->getSaveName();
            $allurl=ROOT_PATH . 'public' . DS . 'Uploads/file/'.$filename;
        }else{
            // 上传失败获取错误信息
            $data['code']=0;
            $data['msg']=$file->getError();
            return json($data);
            exit();
        }
        //处理数据
        $update=new ExcelModel();
        $upfile=$update->importExecl($allurl);//传入完整的文件路径，返回的数据从下表2开始处理
        Db::startTrans();
        for ($i=2;$i<=count($upfile);$i++){
            if(empty($upfile[$i]['A'])||empty($upfile[$i]['C'])){
                $data['code']=0;
                $data['msg']=$i."行信息不完善";
                Db::rollback();
                return json($data);
                exit();
            }
            $datas['staffid']=$upfile[$i]['A'];
            $datas['site']=$upfile[$i]['B'];
            $datas['idnumber']=$upfile[$i]['C'];
            $datas['name']=$upfile[$i]['D'];
            $datas['date']=$upfile[$i]['E'];
            $datas['worktype']=$upfile[$i]['F'];
            $datas['signdays']=$upfile[$i]['G'];
            $datas['salary']=$upfile[$i]['H'];
            $datas['socialsecurity']=$upfile[$i]['I'];
            $datas['reservedfunds']=$upfile[$i]['J'];
            $datas['taxsalary']=$upfile[$i]['K'];
            $datas['deduct']=$upfile[$i]['L'];
            $datas['personaltax']=$upfile[$i]['M'];
            $datas['truesalary']=$upfile[$i]['N'];
            $datas['signature']=$upfile[$i]['O'];

            $updatas=Db::name('back_wages')->insertGetId($datas);
            if(!$updatas){
                $data['code']=0;
                $data['msg']=$i."行插入失败";
                Db::rollback();
                return json($data);
                exit();
            }
        }

        $data['code']=1;
        $data['msg']=$i."行数据执行完成";
        Db::commit();
        return json($data);
        exit();
    }




    //社保费用核算导入
    public function up_soc()
    {
        $file=Request::instance()->file('file');

        if(empty($file)){
            $data['code']=0;
            $data['msg']="请上传文件";
            return json($data);
            exit();
        }

        $info = $file->validate(['ext'=>'xls,xlsx'])->move(ROOT_PATH . 'public' . DS . 'Uploads/file');
        if($info){
            $filename = $info->getSaveName();
            $allurl=ROOT_PATH . 'public' . DS . 'Uploads/file/'.$filename;
        }else{
            // 上传失败获取错误信息
            $data['code']=0;
            $data['msg']=$file->getError();
            return json($data);
            exit();
        }
        //处理数据
        $update=new ExcelModel();
        $upfile=$update->importExecl($allurl);//传入完整的文件路径，返回的数据从下表2开始处理

        Db::startTrans();
        for ($i=2;$i<=count($upfile);$i++){
            if(empty($upfile[$i]['A'])||empty($upfile[$i]['B'])){
                $data['code']=0;
                $data['msg']=$i."行信息不完善";
                Db::rollback();
                return json($data);
                exit();
            }
            $datas['socialSecurityNumber']=$upfile[$i]['A'];
            $datas['name']=$upfile[$i]['B'];
            $datas['sex']=$upfile[$i]['C'];
            $datas['IDNumber']=$upfile[$i]['D'];
            $datas['censusRegister']=$upfile[$i]['E'];
            $datas['declare']=$upfile[$i]['F'];
            $datas['basics']=$upfile[$i]['G'];
            $datas['endowmentInsurance']=$upfile[$i]['H'];
            $datas['medicalInsurance']=$upfile[$i]['I'];
            $datas['unemploymentInsurance']=$upfile[$i]['J'];
            $datas['largeMedicalInsurance']=$upfile[$i]['K'];
            $datas['personalTotal']=$upfile[$i]['L'];
            $datas['cendowmentInsurance']=$upfile[$i]['M'];
            $datas['cmedicalInsurance']=$upfile[$i]['N'];
            $datas['cunemploymentInsurance']=$upfile[$i]['O'];
            $datas['cemploymentInjuryInsurance']=$upfile[$i]['P'];
            $datas['cmaternityInsurance']=$upfile[$i]['Q'];
            $datas['clargeMedicalInsurance']=$upfile[$i]['R'];
            $datas['companyTotal']=$upfile[$i]['S'];
            $datas['total']=$upfile[$i]['T'];
            $datas['site']=$upfile[$i]['U'];
            $datas['daytime']=$upfile[$i]['V'];

            $updatas=Db::name('back_social')->insertGetId($datas);
            if(!$updatas){
                $data['code']=0;
                $data['msg']=$i."行插入失败";
                Db::rollback();
                return json($data);
                exit();
            }
        }

        $data['code']=1;
        $data['msg']=$i."行数据执行完成";
        Db::commit();
        return json($data);
        exit();
    }

}