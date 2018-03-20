<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 2018/3/20
 * Time: 13:52
 */
namespace app;

interface  logger
{
    function save();
}

interface loggerFactory
{
    static  function createLog();
}

class fileLogger implements logger
{
    function save()
    {
      echo 'write log with file';
    }
}


class dbLogger implements logger
{
    function save()
    {
        echo 'write log with database';
    }
}

class fileLoggerFactory implements loggerFactory
{

    static function createLog()
    {
        return new fileLogger();
    }
}

class dbLoggerFactory implements loggerFactory
{
    static function createLog()
    {
        return new dbLogger();
    }
}

$a = fileLoggerFactory::createLog();
$a->save();

$db = dbLoggerFactory::createLog();
$db->save();

/**
 * 工厂方法模式是简单工厂模式的进一步抽象和推广。由于使用了面向对象的多态性，工厂方法模式保持了简单工厂模式的优点，而且克服了它的缺点。在工厂方法模式中，核心的工厂类不再负责所有产品的创建，而是将具体创建工作交给子类去做。这个核心类仅仅负责给出具体工厂必须实现的接口，而不负责哪一个产品类被实例化这种细节，这使得工厂方法模式可以允许系统在不修改工厂角色的情况下引进新产品。

2.10. 适用环境
在以下情况下可以使用工厂方法模式：

一个类不知道它所需要的对象的类：在工厂方法模式中，客户端不需要知道具体产品类的类名，只需要知道所对应的工厂即可，具体的产品对象由具体工厂类创建；客户端需要知道创建具体产品的工厂类。
一个类通过其子类来指定创建哪个对象：在工厂方法模式中，对于抽象工厂类只需要提供一个创建产品的接口，而由其子类来确定具体要创建的对象，利用面向对象的多态性和里氏代换原则，在程序运行时，子类对象将覆盖父类对象，从而使得系统更容易扩展。
将创建对象的任务委托给多个工厂子类中的某一个，客户端在使用时可以无须关心是哪一个工厂子类创建产品子类，需要时再动态指定，可将具体工厂类的类名存储在配置文件或数据库中。
 */