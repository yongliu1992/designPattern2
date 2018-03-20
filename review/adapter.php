<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 15/01/2018
 * Time: 09:28
 */
/***
 * 适配器模式
 * 适配器模式 分为2种情况
 * 1、对象适配器
 * 2、类适配器
目标(Target)角色：定义客户端使用的与特定领域相关的接口，这也就是我们所期待得到的
源(Adaptee)角色：需要进行适配的接口
适配器(Adapter)角色：对Adaptee的接口与Target接口进行适配；适配器是本模式的核心，适配器把源接口转换成目标接口，此角色为具体类
四、适配器模式适用场景
1、你想使用一个已经存在的类，而它的接口不符合你的需求
2、你想创建一个可以复用的类，该类可以与其他不相关的类或不可预见的类协同工作
3、你想使用一个已经存在的子类，但是不可能对每一个都进行子类化以匹配它们的接口。对象适配器可以适配它的父类接口（仅限于对象适配器）
 */


//假如我们原来有个类是门,拥有开关等动作，但是现在要加入报警器功能，这个报警器与门其实不是一个概念，所以用接口来约束 下面这个例子是类适配器

abstract class Door
{
    abstract function  close();
    abstract function  open();
}

interface alarm
{
    function notice();
}

class myDoor extends Door implements alarm
{
    function close()
    {

    }

    function open()
    {

    }

    function notice()
    {
        echo '我是通知000';
    }
}
class client
{
    static function main()
    {
        $myDoor = new myDoor();
        $myDoor->notice();
    }
}
client::main();

//对象适配器，将实现了这个方法的对象放进来使用，客户端只要调用
class myDoor2 extends Door
{
    protected $alarm;

    public function __construct(alarm2 $alarm2)
    {
        $this->alarm = $alarm2;
    }

    function notice()
    {
        //委派调用 alarm2中的通知
      $this->alarm->notice();
    }

    function close()
    {

    }

    function open()
    {

    }

}

class alarm2 implements alarm
{
    function notice()
    {
       echo '我是通知001';
    }
}

class client2
{

    public static function main()
    {
        $alarm = new alarm2();
        $door = new myDoor2($alarm);
        $door->notice();
    }
}

client2::main();