<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 26/01/2018
 * Time: 11:11
 */

/**
 * Interface iComm
 * 命令链 模式以松散耦合主题为基础，发送消息、命令和请求，或通过一组处理程序发送任意内容。
 * 每个处理程序都会自行判断自己能否处理请求。
 * 如果可以，该请求被处理，进程停止。
 * 我们可以为系统添加或移除处理程序，而不影响其他处理程序
 */
interface  iComm
{
    function onCommand($name,$args);
}


class iCommChain
{
    private $chain=[];

    function add(iComm $c)
    {
        array_push($this->chain,$c);
    }

    function run($name,$args)
    {
        foreach ($this->chain as $cmd)
        {
            if($cmd->onCommand($name,$args))
            {
                return '';
            }
        }
    }
}

class userComm implements iComm
{
    function onCommand($name, $args)
    {
        if($name=='user')
        {
            echo '用户，我可以处理';
            return true;
        }return false;

    }
}


class mailComm implements iComm
{
    function onCommand($name, $args)
    {
        if($name=='mail')
        {
            echo '邮件，我可以处理';
            return true;
        }return false;
    }
}

$cc = new iCommChain();
$cc->add(new userComm());
$cc->add(new mailComm());
$cc->run('mail','world');
