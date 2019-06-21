<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;


class Console extends Common
{
    public function index()
    {
        $user = $this->user;

        //在职人数
        $zai=Db::name('back_query')->where(['sfzz'=>"是"])->count();

        //离职人数
        $lznum=0;
        $where['sfzz']="否";
        $li=Db::name('back_query')->where($where)->field('livedate')->select();
        foreach ($li as $k=>$v){
            if(date('Y-m')==date('Y-m',strtotime($v['livedate']))){
                $lznum++;
            }
        }

        //参保人数
        unset($where);
        $stime=strtotime(date('Y-m'));
        $etime=strtotime(date('Y-m',strtotime('+1 month')));
        $where['yufen']=['between',"$stime,$etime"];
        $insured=Db::name('back_social')->where($where)->count();

        //发薪人数
        unset($where);
        $where['date']=date('Y-m');
        $salary=Db::name('back_wages')->where($where)->count();

        //下月合同到期人数
        $nextuser=0;
        $surpluss=Db::name('back_query')->field('contractend')->select();
        foreach ($surpluss as $k=>$v){
            if(((strtotime($v['contractend'])-time())/86400)<=30&&((strtotime($v['contractend'])-time())/86400)>0){
                $nextuser++;
            }
        }


        $wheres['age']=['egt',49];
        $lists=array();
        $role = db('back_query')->where($wheres)->select();
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
        $txuser=count($lists);


        return view('console',[
            'user'     => $user,
            'zai'      => $zai,
            'li'       => $lznum,
            'salary'   => $salary,
            'insured'  => $insured,
            'surplus'  => $nextuser,
            'txuser'   => $txuser
        ]);
    }
}
