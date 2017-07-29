<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/7/29
 * Time: 19:18
 *
 * 完整解决方案
 * Sunny公司开发人员决定使用工厂方法模式来设计日志记录器，其基本结构如图3所示：
 *
 *
 *
 * Logger接口充当抽象产品，其子类FileLogger和DatabaseLogger充当具体产品，LoggerFactory接口充当抽象工厂，其子类FileLoggerFactory和DatabaseLoggerFactory充当具体工厂。完整代码如下所示：
 *
 *  */
//日志记录器接口：抽象产品
interface Logger
{
    public function writeLog();
}

//数据库日志记录器：具体产品
class DatabaseLogger implements Logger
{
    public function writeLog()
    {
        echo("数据库日志记录。");
    }
}

//文件日志记录器：具体产品
class FileLogger implements Logger
{
    public function writeLog()
    {
        echo("文件日志记录。");
    }
}

//日志记录器工厂接口：抽象工厂
interface LoggerFactory
{
    public function createLogger(Logger $l);
}

//数据库日志记录器工厂类：具体工厂
class DatabaseLoggerFactory implements LoggerFactory
{
    public function createLogger(Logger $a)
    {
        //连接数据库，代码省略
        //创建数据库日志记录器对象
        $logger = new DatabaseLogger($a);
        //初始化数据库日志记录器，代码省略
        return $logger;
    }
}

//文件日志记录器工厂类：具体工厂
class FileLoggerFactory implements LoggerFactory
{
    public function createLogger(Logger $l)
    {
        //创建文件日志记录器对象
        $logger = new FileLogger($l);
        //创建文件，代码省略
        return $logger;
    }
}

//      编写如下客户端测试代码：

class Client
{
    public static function create(String $args)
    {

        $factory = new FileLoggerFactory(); //可引入配置文件实现
        $logger = $factory->createLogger();
        $logger->writeLog();
    }
}

/*
 *
文件日志记录。

4 反射与配置文件
       为了让系统具有更好的灵活性和可扩展性，Sunny公司开发人员决定对日志记录器客户端代码进行重构，使得可以在不修改任何客户端代码的基础上更换或增加新的日志记录方式。
       在客户端代码中将不再使用new关键字来创建工厂对象，而是将具体工厂类的类名存储在配置文件
（如XML文件）中，通过读取配置文件获取类名字符串，再使用php的反射机制，根据类名字符串生成对象。
在整个实现过程中需要用到两个技术：php反射机制与配置文件读取。
软件系统的配置文件通常为XML文件，我们可以使用DOM (Document Object Model)、
SimepleXML等技术来处理XML文件
。关于DOM、SAX、StAX等技术的详细学习大家可以参考其他相关资料，在此不予扩展。
 */

$c = new Reflection($name);
$instance = $c->newInstanceArgs($args);
return $instance;


//如果使用皮质文件 会更好
/**
 * 引入XMLUtil类和XML配置文件后，如果要增加新的日志记录方式，只需要执行如下几个步骤：
 * (1) 新的日志记录器需要继承抽象日志记录器Logger；
 * (2) 对应增加一个新的具体日志记录器工厂，继承抽象日志记录器工厂LoggerFactory，并实现其中的工厂方法createLogger()，设置好初始化参数和环境变量，返回具体日志记录器对象；
 * (3) 修改配置文件config.xml，将新增的具体日志记录器工厂类的类名字符串替换原有工厂类类名字符串；
 * (4) 新增的具体日志记录器类和具体日志记录器工厂类，运行客户端测试类即可使用新的日志记录方式，而原有类库代码无须做任何修改，完全符合“开闭原则”。
 * 通过上述重构可以使得系统更加灵活，由于很多设计模式都关注系统的可扩展性和灵活性，因此都定义了抽象层，在抽象层中声明业务方法，而将业务方法的实现放在实现层中。
 *
 */


