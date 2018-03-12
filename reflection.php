<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 2018/3/12
 * Time: 13:32
 */
//反射 相关技术

class Ioc {

    // 获得类的对象实例
    public static function getInstance($className) {

        $paramArr = self::getMethodParams($className);

        return (new ReflectionClass($className))->newInstanceArgs($paramArr);
    }

    /**
     * 执行类的方法
     * @param  [type] $className  [类名]
     * @param  [type] $methodName [方法名称]
     * @param  [type] $params     [额外的参数]
     * @return [type]             [description]
     */
    public static function make($className, $methodName, $params = []) {

        // 获取类的实例
        $instance = self::getInstance($className);

        // 获取该方法所需要依赖注入的参数
        $paramArr = self::getMethodParams($className, $methodName);

        return $instance->{$methodName}(...array_merge($paramArr, $params));
    }

    /**
     * 获得类的方法参数，只获得有类型的参数
     * @param  [type] $className   [description]
     * @param  [type] $methodsName [description]
     * @return [type]              [description]
     */
    protected static function getMethodParams($className, $methodsName = '__construct') {

        // 通过反射获得该类
        $class = new ReflectionClass($className);
        $paramArr = []; // 记录参数，和参数类型

        // 判断该类是否有构造函数
        if ($class->hasMethod($methodsName)) {
            // 获得构造函数
            $construct = $class->getMethod($methodsName);

            // 判断构造函数是否有参数
            $params = $construct->getParameters();

            if (count($params) > 0) {

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

class Person
{
    protected  $monkey;
    function __construct(Monkey $monkey)
    {
       $this->monkey = $monkey->name;
    }

    function speak(Teacher $t)
    {
        echo $t->name.'教我们'.'人的始祖是'.$this->monkey;
    }
}

class Teacher
{
    public $name;
    function __construct()
    {
        $this->name='伟大的教师';
    }

}

class Monkey
{
    public $name;
    function __construct()
    {
        $this->name = '猿猴';
    }
}

$bObj = Ioc::getInstance('Person');
$bObj->speak(new Teacher()); // 输出：this is C->cc ， 说明依赖注入成功。
echo '<br/>';
Ioc::make('Person', 'speak', ['']);
exit;
// 打印$bObj


