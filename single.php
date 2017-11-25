<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/4/8
 * Time: 23:11
 */

/**
 * Class Single
 * 为什么要用单例模式
 * 比如说这一个应用程序 多次创建  多次创建一个类，这其实是一种资源浪费，他要开辟内存空间，分配内存 等等 其实只要一次即可
 * 比如说 连接数据库，
 * 如何 使用单粒模式
 * 将构造方法 设置私有的 或者保护的
 * 将克隆 方法 设置私有或保护的
 * 创建一个静态方法，new自己
 * 再设置一个属性  设置保护 或者私有的静态变量，否则
 *
 */

class Single {
    static $obj=null;
    public $number='';
    /**
     * @param null $obj
     */
    public static function setObj($obj)
    {
        self::$obj = $obj;
    }
    //防止被外部勾走
    private function __construct()
    {
        $this->number = mt_rand();
    }

    public static function getInstance(){
        if(self::$obj == null ){
            self::$obj = new Single();
        }
        return self::$obj;
    }

    public function printNumber(){
        echo $this->number;
    }
    //防止被外部克隆
    private function __clone(){}

}

$obj = Single::getInstance();
$obj->printNumber();
echo '<br/>';
$obj = Single::getInstance();
$obj->printNumber();