<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 2018/3/6
 * Time: 11:43
 */

/**
 * 反射 反射 程序员的快乐!
 * 工具类，使用该类来实现自动依赖注入。
 *
 */

class Ioc
{
    public static function getInstance($className)
    {
        $paramArr = self::getMethodParams($className);

        return (new ReflectionClass($className))->newInstanceArgs($paramArr);
    }

    static function make($className,$methodName,$params=[])
    {
        $instance = self::getInstance($className);
        $paramArr = self::getMethodParams($className,$methodName);

        return $instance->{$methodName}(...array_merge($paramArr,$params));
    }

   static function getMethodParams($className , $methodName= '__construct')
   {
        $class = new ReflectionClass($className);
        $paramArr = [];
        if($class->hasMethod($methodName))
        {
            $construct = $class->getMethod($methodName);

            $params = $construct->getParameters();
            if(count($params)>0)
            {
                // 判断参数类型
                foreach ($params as $key => $param) {

                    if ($paramClass = $param->getClass()) {

                        // 获得参数类型名称
                        $paramClassName = $paramClass->getName();

                        // 获得参数类型
                        $args = self::getMethodParams($paramClassName);
                        $paramArr[] = (new ReflectionClass($paramClass->getName()))->newInstanceArgs($args);

                    }else{
                        $paramArr[] = $param;
                    }
                }
            }
        }
       return $paramArr;
   }
}

class A {

    protected $cObj;

    /**
     * 用于测试多级依赖注入 B依赖A，A依赖C
     * @param C $c [description]
     */
    public function __construct(C $c) {

        $this->cObj = $c;
    }

    public function aa() {

        echo 'this is A->test';
    }

    public function aac() {

        $this->cObj->cc();
    }
}

class B {

    protected $aObj;

    /**
     * 测试构造函数依赖注入
     * @param A $a [使用引来注入A]
     */
    public function __construct(A $a) {

        $this->aObj = $a;
    }

    /**
     * [测试方法调用依赖注入]
     * @param  C      $c [依赖注入C]
     * @param  string $b [这个是自己手动填写的参数]
     * @return [type]    [description]
     */
    public function bb(C $c, $b) {

        $c->cc();
        echo "\r\n";

        echo 'params:' . $b;
    }

    /**
     * 验证依赖注入是否成功
     * @return [type] [description]
     */
    public function bbb() {

        $this->aObj->aac();
    }
}

class C {

    public function cc() {

        echo 'this is C->cc';
    }
}

// 使用Ioc来创建B类的实例，B的构造函数依赖A类，A的构造函数依赖C类。
$bObj = Ioc::getInstance('B');
$bObj->bbb(); // 输出：this is C->cc ， 说明依赖注入成功。
exit;
// 打印$bObj
//var_dump($bObj);

Ioc::make('B', 'bb', ['this is param b']);