<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 24/01/2018
 * Time: 01:07
 */

/***
 * Class temp
 * 模板模式
 *   优点
 *      1.具体细节步骤实现定义在子类中，子类定义详细处理算法是不会改变算法整体结构。
 *      2.代码复用的基本技术
 *      3.控制反转，通过一个父类调用其子类的操作，通过子类对父类进行扩展增加新的行为，符合“开闭原则”
 *   缺点
 *      按照面向对象思维，父类负责抽象，子类负责具象，但是模板模式 刚好相反，子类的实现结果 影响父类的结果
 *  应用场景
 *  多个子类有共有的方法，并且逻辑基本相同
 *  重要、复杂的算法，可以把核心算法设计为模板方法，周边的相关细节功能则由各个子类实
 *  重构时，模板方法是一个经常使用的方法，把相同的代码抽取到父类中，然后通过构造函数约束其行为。
 */
abstract class  temp
{
 final    function test()
    {
        $this->doTemp();
        echo 1;
    }
    abstract function doTemp();
}


class  temp2 extends temp
{
    function doTemp()
    {
        echo mt_rand();
    }

}

$a = new temp2();
$a->test();

echo '<br/>';
//利用委托+接口约束 来完成类似效果
interface  temp3
{
    function doTemp();
}

class temp4
{
    function test(temp3 $a)
    {
        $a->doTemp();
    }

}

class tempInt implements temp3
{
    function doTemp()
    {
        echo mt_rand();
    }
}

$t4 = new temp4();
$t4->test(new tempInt());
