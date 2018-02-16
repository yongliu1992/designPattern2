<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 2018/2/16
 * Time: 19:27
 */
/*
 *
 * 桥接模式是软件设计模式中最复杂的模式之一，它把事物对象和其具体行为、具体特征分离开来，使它们可以各自独立的变化。事物对象仅是一个抽象的概念。如“圆形”、“三角形”归于抽象的“形状”之下，而“画圆”、“画三角”归于实现行为的“画图”类之下，然后由“形状”调用“画图”。

理解桥接模式，重点需要理解如何将抽象化(Abstraction)与实现化(Implementation)脱耦，使得二者可以独立地变化。桥接模式提高了系统的可扩充性，在两个变化维度中任意扩展一个维度，都不需要修改原有系统。

角色：

Abstraction：定义抽象的接口，该接口包含实现具体行为、具体特征的Implementor接口

Refined Abstraction：抽象接口Abstraction的子类，依旧是一个抽象的事物名

Implementor：定义具体行为、具体特征的应用接口

ConcreteImplementor：实现Implementor接口


 */
interface  DrawingAPI
{
    public function drawCircle($x,$y,$radius);
}

class  DrawingAPI1 implements  DrawingAPI
{
    function drawCircle($x, $y, $radius)
    {
        echo "API1.circle at (".$x.','.$y.') radius '.$radius.'<br>';

    }
}


class DrawingAPI2 implements DrawingAPI
{
    public function drawCircle($x,$y,$radius)
    {
        echo "API2.circle at (".$x.','.$y.') radius '.$radius.'<br>';
    }
}

/**
 *shape接口
 */
interface Shape{
    public function draw();
    public function resize($radius);
}

class CircleShape implements Shape
{
    private $x;
    private $y;
    private $radius;
    private $drawingAPI;
    function __construct($x,$y,$radius,DrawingAPI $drawingAPI)
    {
        $this->x = $x;
        $this->y = $y;
        $this->radius = $radius;
        $this->drawingAPI = $drawingAPI;
    }

    public function draw()
    {
        $this->drawingAPI->drawCircle($this->x,$this->y,$this->radius);
    }

    public function resize($radius)
    {
        $this->radius = $radius;
    }
}


$shape1 = new CircleShape(1,2,4,new DrawingAPI1());
$shape2 = new CircleShape(1,2,4,new DrawingAPI2());
$shape1->draw();
$shape2->draw();
$shape1->resize(10);
$shape1->draw();

