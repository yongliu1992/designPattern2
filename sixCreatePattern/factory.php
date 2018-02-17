<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/7/29
 * Time: 18:42


简单工厂模式虽然简单，但存在一个很严重的问题。当系统中需要引入新产品时，由于静态工厂方法通过所传入参数的不同来创建不同的产品，这必定要修改工厂类的源代码，将违背“开闭原则”，如何实现增加新产品而不影响已有代码？工厂方法模式应运而生，本文将介绍第二种工厂模式——工厂方法模式。

1 日志记录器的设计
       Sunny软件公司欲开发一个系统运行日志记录器(Logger)，该记录器可以通过多种途径保存系统的运行日志，如通过文件记录或数据库记录，用户可以通过修改配置文件灵活地更换日志记录方式。在设计各类日志记录器时，Sunny公司的开发人员发现需要对日志记录器进行一些初始化工作，初始化参数的设置过程较为复杂，而且某些参数的设置有严格的先后次序，否则可能会发生记录失败。如何封装记录器的初始化过程并保证多种记录器切换的灵活性是Sunny公司开发人员面临的一个难题。
       Sunny公司的开发人员通过对该需求进行分析，发现该日志记录器有两个设计要点：
       (1) 需要封装日志记录器的初始化过程，这些初始化工作较为复杂，例如需要初始化其他相关的类，还有可能需要读取配置文件（例如连接数据库或创建文件），导致代码较长，如果将它们都写在构造函数中，会导致构造函数庞大，不利于代码的修改和维护；
       (2) 用户可能需要更换日志记录方式，在客户端代码中需要提供一种灵活的方式来选择日志记录器，尽量在不修改源代码的基础上更换或者增加日志记录方式。
       Sunny公司开发人员最初使用简单工厂模式对日志记录器进行了设计，初始结构如图1所示：
 */

interface  Talk
{
    function say();
}

class Talker implements Talk
{
    function say()
    {
        echo __METHOD__;
    }
}

class Dog implements Talk
{
    function say()
    {
        echo __METHOD__;
    }
}

class talkFactory
{
    function createTalk(Talk $talk)
    {
        $t = new $talk;
        return $t;
    }
}
$c = new talkFactory();
$c->createTalk(new Talker())->say();
echo '<br/>';
$c->createTalk(new Dog())->say();
exit;


interface Logger
{
    //log里面还可以定一些相关需要的需求
    function writeLog();
};

class FileLogger  implements Logger
{
    function writeLog(){
        echo __METHOD__;
    }
}

class DataBaseLogger implements Logger
{
    function writeLog(){
        echo __METHOD__;
    }
}

class LoggerFactory {
    function createLogger(Logger $name){
        //根据$name 进行判断 创建对象 返回
        $obj = new $name;
        return $obj;
    }
}


$client = new LoggerFactory();
$obj = $client->createLogger(new DataBaseLogger());
$obj->writeLog();


/**
 *
为了突出设计重点，我们对上述代码进行了简化，省略了具体日志记录器类的初始化代码。在LoggerFactory类中提供了静态工厂方法createLogger()，用于根据所传入的参数创建各种不同类型的日志记录器。通过使用简单工厂模式，我们将日志记录器对象的创建和使用分离，客户端只需使用由工厂类创建的日志记录器对象即可，无须关心对象的创建过程，但是我们发现，虽然简单工厂模式实现了对象的创建和使用分离，但是仍然存在如下两个问题：
(1) 工厂类过于庞大，包含了大量的if…else…代码，导致维护和测试难度增大；
(2) 系统扩展不灵活，如果增加新类型的日志记录器，必须修改静态工厂方法的业务逻辑，违反了“开闭原则”。
如何解决这两个问题，提供一种简单工厂模式的改进方案？这就是本文所介绍的工厂方法模式的动机之一。
 */