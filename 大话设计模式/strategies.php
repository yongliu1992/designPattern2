<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 2018/3/10
 * Time: 22:17
 */


abstract class CashSuper
{
    abstract function acceptCash($money);
}

class CashNormal extends CashSuper
{
    function acceptCash($money)
    {
        return $money;
    }
}

class CashRebate extends CashSuper
{
    private $moneyRebate;

    function acceptCash($money)
    {
        return $this->moneyRebate * $money;
    }
    function __construct($moneyRebate)
    {
        $this->moneyRebate = $moneyRebate;
    }

}

class CashReturn extends CashSuper
{
    private $moneyCondition,$moneyReturn;

    function __construct($moneyCondition,$moneyReturn)
    {
        $this->moneyCondition = $moneyCondition;
        $this->moneyReturn    = $moneyReturn;
    }

    function acceptCash($money)
    {
        //如果大于返利条件， 减去返利值
        if($money>=$this->moneyCondition)
        {
            $money = $money - floor($money/$this->moneyCondition) * $this->moneyReturn;
        }
        return $money;
    }

}

class CashFactory
{
    static public function createCashAccept($type)
    {
         $cs = null;
        switch ( $type )
        {
            case 'normal':
                $cs = new CashNormal();
                break;
            case "return":
                $cs = new CashReturn("300","100");
                break;
            case "rebate":
                $cs = new CashRebate("0.8");
                break;
        }
        return $cs;
    }
}

//以上是简单工厂
//策略模式 它定义了算法家族，分别封装起来，让他们之间可以相互替换，此模式让算法的变化，不会影响到算法的客户。DP

class CashContent
{
    private $cs;
    function __construct(CashSuper $cs)
    {
        $this->cs = $cs;
    }
    function getResult($money)
    {
        return $this->cs->acceptCash($money);
    }
}

//再改造 策略+简单工厂

class CashContent2
{
    private $cs;
    function __construct($type)
    {
        $cs = null;
        switch ( $type )
        {
            case 'normal':
                $cs = new CashNormal();
                break;
            case "return":
                $cs = new CashReturn("300","100");
                break;
            case "rebate":
                $cs = new CashRebate("0.8");
                break;
        }
        $this->cs = $cs;

    }

    function getResult($money)
    {
        return $this->cs->acceptCash($money);
    }
}

$a = new CashContent2('return');
echo $a->getResult(300);
$a = new CashContent2('rebate');
echo $a->getResult(300);

//策略算法与简单工厂结合 降低了耦合
//策略模式优点 1定义了一系列可重用的算法或行为 2简化了单元测试，每个算法都有自己的类，可以单独测试DPE
//基本策略模式里面所用具体实现的职责有客户端对象承担，并转给策略模式的Context对象DPE，这个并没有减轻客户端压力
//当策略模式与工厂模式结合后，选择具体实现的职责也有Context来承担，减少了客户端的职责。
//后面可以用反射技术 来更加优化这段代码，反射反射 程序员的快乐，解决依赖注入。