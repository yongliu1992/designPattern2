<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/7/30
 * Time: 22:10
 */
//饿汉式单例类不能实现延迟加载，不管将来用不用始终占据内存；懒汉式单例类线程安全控制烦琐，而且性能受影响。可见，无论是饿汉式单例还是懒汉式单例都存在这样那样的问题，有没有一种方法，能够将两种单例的缺点都克服，而将两者的优点合二为一呢？答案是：Yes！下面我们来学习这种更好的被称之为Initialization Demand Holder (IoDH)的技术。
 //     在IoDH中，我们在单例类中增加一个静态(static)内部类，在该内部类中创建单例对象，再将该单例对象通过getInstance()方法返回给外部使用，实现代码如下所示：
//Initialization on Demand Holder
class Singleton
{
    private static $instance;
    private $number;

    private function __construct()
    {
        $this->number=mt_rand();
    }

    private static function HolderClass()
    {
        if(!self::$instance ){
        self::$instance = new self();
        }

    }

    public static function getInstance()
    {
        self::HolderClass();
        return self::$instance;
    }

    public static function index()
    {

        $s1 = Singleton::getInstance();
        $s2 = Singleton::getInstance();
        var_dump($s1 == $s2);
        var_dump($s1->number);
        var_dump($s2->number);

    }
}
Singleton::index();

    /*   编译并运行上述代码，运行结果为：true，即创建的单例对象s1和s2为同一对象。
    由于静态单例对象没有作为Singleton的成员变量直接实例化，
    */