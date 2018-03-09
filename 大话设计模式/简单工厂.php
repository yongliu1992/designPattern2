<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 2018/3/9
 * Time: 11:48
 */
namespace Head;
abstract  class Operation
{
    protected $a,$b;


    public function setA($a)
    {
        $this->a = $a;
    }

    public function setB($b)
    {
        $this->b = $b;
    }

    abstract function getResult();

}


class Add extends Operation
{
    function getResult()
    {
        return $this->a + $this->b;
    }
}

class Sub extends Operation
{
    function getResult()
    {
      return $this->a-$this->b;
    }
}

class operateFactory
{
    static public function createOperation($operation)
    {

        switch ($operation) {
            case '+':
                $obj = new Add();
                break;
            case '-':
                $obj = new Sub();
                break;
        }
        return $obj;
    }
}
// 客户端代码
$operation = OperateFactory::createOperation('+');
$operation->setA(1);
$operation->setB(2);
echo $operation->getResult()."\n";

/*如果不使用工厂模式，每次都去new 一个新对象，如果类名发生变化，则每一个相关的都需要更改
提供了静态工厂方法createOperation()，用于根据所传入的参数创建各种不同的对象并返回。

*/
