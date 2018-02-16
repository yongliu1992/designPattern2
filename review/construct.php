<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 2018/2/9
 * Time: 17:32
 */

/**
 * 建造者模式

又名：生成器模式，是一种对象构建模式。它可以将复杂对象的建造过程抽象出来（抽象类别），使这个抽象过程的不同实现方法可以构造出不同表现（属性）的对象。

建造者模式是一步一步创建一个复杂的对象，它允许用户只通过指定复杂对象的类型和内容就可以构建它们，用户不需要知道内部的具体构建细节。
例如，一辆汽车由轮子，发动机以及其他零件组成，对于普通人而言，我们使用的只是一辆完整的车，这时，我们需要加入一个构造者，让他帮我们把这些组件按序组装成为一辆完整的车。
角色：

Builder：抽象构造者类，为创建一个Product对象的各个部件指定抽象接口。

ConcreteBuilder：具体构造者类，实现Builder的接口以构造和装配该产品的各个部件。定义并明确它所创建的表示。提供一个检索产品的接口

Director：指挥者，构造一个使用Builder接口的对象。

Product：表示被构造的复杂对象。ConcreateBuilder创建该产品的内部表示并定义它的装配过程。

包含定义组成部件的类，包括将这些部件装配成最终产品的接口。

 */
namespace review\builder;

abstract class Builder
{
    protected $car;
    abstract function buildPartA();
    abstract function buildPartB();
    abstract function buildPartC();
    abstract function getResult();
}



class Car
{
    protected $partA;
    protected $partB;
    protected $partC;

    public function setPartA($str){
        $this->partA = $str;
    }

    public function setPartB($str){
        $this->partB = $str;
    }

    public function setPartC($str){
        $this->partC = $str;
    }

    public function show()
    {
        echo "这辆车由：".$this->partA.','.$this->partB.',和'.$this->partC.'组成';
    }
}

class CarBuilder extends Builder
{
    function __construct()
    {
        $this->car = new Car();
    }
    public function buildPartA(){
        $this->car->setPartA('发动机');
    }

    public function buildPartB(){
        $this->car->setPartB('轮子');
    }

    public function buildPartC(){
        $this->car->setPartC('其他零件');
    }

    public function getResult(){
        return $this->car;
    }
}


class Director
{
    public $myBuilder;

    public function startBuild()
    {
        $this->myBuilder->buildPartA();
        $this->myBuilder->buildPartB();
        $this->myBuilder->buildPartC();
        return $this->myBuilder->getResult();
    }

    public function setBuilder(Builder $builder)
    {
        $this->myBuilder = $builder;
    }
}

$carBuilder = new CarBuilder();
$director = new Director();
$director->setBuilder($carBuilder);
$newCar = $director->startBuild();
$newCar->show();






