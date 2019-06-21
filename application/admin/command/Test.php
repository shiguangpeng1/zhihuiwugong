<?php
namespace app\admin\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;

class Test extends Command
{
    protected function configure()
    {
        $this->setName('test')->setDescription('Here is the remark ');
    }

    protected function execute(Input $input, Output $output)
    {
//        echo 111;die;
        $input=date("Y-n-j",(time()+86400*30));

        $data=db::query("SELECT if(DATEDIFF(CURDATE(),'.$input.')<=30,'即将到期','-') as expire");

        var_dump($data);
    }

}