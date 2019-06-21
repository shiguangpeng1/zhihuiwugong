<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\Session;

class Index extends Common
{
    public function index()
    {
        $user = $this->user;

        return view('index',[
            'user'     => $user,

        ]);
    }


}
