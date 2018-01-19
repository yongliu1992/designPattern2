<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 19/01/2018
 * Time: 11:26
 */

//观察者模式
//在js中 有事件监听和事件响应 2种区别，事件响应 后面的事件会覆盖前面的事件，而事件监听不会

/**
 * 定义对象间的一种一对多的依赖关系，当一个对象的状态发生改变时，所有依赖于它的对象都得到通知并被自动更新【GOF95】
 * 又称为发布-订阅（Publish-Subscribe）模式、模型-视图（Model-View）模式、源-监听（Source-Listener）模式、或从属者(Dependents)模式
 *【观察者模式中主要角色】

1.抽象主题（Subject）角色：主题角色将所有对观察者对象的引用保存在一个集合中，每个主题可以有任意多个观察者。 抽象主题提供了增加和删除观察者对象的接口。
2.抽象观察者（Observer）角色：为所有的具体观察者定义一个接口，在观察的主题发生改变时更新自己。
3.具体主题（ConcreteSubject）角色：存储相关状态到具体观察者对象，当具体主题的内部状态改变时，给所有登记过的观察者发出通知。具体主题角色通常用一个具体子类实现。
4.具体观察者（ConcretedObserver）角色：存储一个具体主题对象，存储相关状态，实现抽象观察者角色所要求的更新接口，以使得其自身状态和主题的状态保持一致。

【观察者模式的优点和缺点】

观察者模式的优点：

1.观察者和主题之间的耦合度较小；
2.支持广播通信；

观察者模式的缺点：

由于观察者并不知道其它观察者的存在，它可能对改变目标的最终代价一无所知。这可能会引起意外的更新。


【观察者模式适用场景】

当一个抽象模型有两个方面，其中一个方面依赖于另一个方面。
当对一个对象的改变需要同时改变其它对象，而不知道具体有多少个对象待改变。
当一个对象必须通知其它对象，而它又不能假定其它对象是谁。换句话说，你不希望这些对象是紧密耦合的。

【观察者模式与其它模式】

1.中介者模式（Mediator）:通过封装复杂的更新语义，ChangeManager充当目标和观察者之间的中介者。
2.单例模式(singleton模式):ChangeManager可使用Singleton模式来保证它是唯一的并且是可全局访问的。
 这个地方完全可以 做成订单 支付成功进行一个通知处理，处理订单 发送推送通知等等
 */

namespace review;

class Order implements \SplSubject
{
    private $observers=[];
    //增加观察者
    function attach(\SplObserver $ob){
        return array_push($this->observers, $ob);
       // $this->observers[] = $ob;
    }

    //删除一个观察者
    function detach(\SplObserver $ob)
    {
        $index = array_search($ob,$this->observers);
        if ($index === FALSE || ! array_key_exists($index, $this->observers)) {
            return FALSE;
        }
        unset($this->observers[$index]);
        return TRUE;
    }

    function notify()
    {
        if (!is_array($this->observers)) {
            return FALSE;
        }

        foreach ($this->observers as $ob)
        {
            $ob->update($this);
        }
        return true;
    }
}

class ConcreteObserver implements \SplObserver {

    /**
     * 观察者的名称
     * @var <type>
     */
    private $_name;

    public function __construct($name) {
        $this->_name = $name;
    }

    /**
     * @param \SplSubject $spl
     */
    public function update(\SplSubject $spl) {
        echo 'Observer ', $this->_name, ' has notified.<br />';
    }

}

//实例化类：
$subject = new Order();

/* 添加第一个观察者 */
$observer1 = new ConcreteObserver('marry');
$subject->attach($observer1);

echo '<br /> The First notify: <br />';
$subject->notify();

/* 添加第二个观察者 */
$observer2 = new ConcreteObserver('benz');
$subject->attach($observer2);

echo '<br /> The Second notify: <br />';
$subject->notify();

/* 删除第一个观察者 */
$subject->detach($observer1);

echo '<br /> The Third notify: <br />';
$subject->notify();
