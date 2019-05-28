<?php

namespace app\admin\Controller;

use think\Controller;
use think\Request;
use think\Db;

class Console extends Controller
{
    public function index()
    {
        $user = session('admin');

//        $start = date('Y-m-01 00:00:00');
//        $end = date('Y-m-d H:i:s');
//        SELECT * FROM `table_name` WHERE `time` >= unix_timestamp('”.$start.”') AND `time` <= unix_timestamp('$end');

        //本月在职数据
        $Onthejob = db::query("SELECT count(indate) as zai FROM back_query WHERE DATE_FORMAT( indate,'%Y%m') = DATE_FORMAT( CURDATE( ) , '%Y%m')");

        $zai = $Onthejob[0]['zai'];
        //本月离职数据
        $Onthejob = db::query("SELECT count(livedate) as li FROM back_query WHERE DATE_FORMAT( livedate,'%Y%m') = DATE_FORMAT( CURDATE( ) , '%Y%m')");

        $li = $Onthejob[0]['li'];

        $salary = db::query("SELECT count(salary) as li FROM back_query WHERE DATE_FORMAT( indate,'%Y%m') = DATE_FORMAT( CURDATE( ) , '%Y%m')");

        $salary = $salary[0]['li'];

        $insured = db::query("SELECT count(socialsecuritybegin) as insured FROM back_query WHERE DATE_FORMAT( indate,'%Y%m') = DATE_FORMAT( CURDATE( ) , '%Y%m')");


        $insured = $insured[0]['insured'];

        $startime = strtotime('30 days');

        $time = db::query('select contractremark from back_query');
        $c = strtotime($time[0]['contractremark']);

        $surplus = db::query("select count(contractremark) as num from back_query where '.$c.'<".$startime);

        $surpluss = $surplus[0]['num'];

        return view('console',[
            'user'     => $user,
            'zai'      => $zai,
            'li'       => $li,
            'salary'   => $salary,
            'insured'  => $insured,
            'surplus'  => $surpluss
        ]);
    }
}
