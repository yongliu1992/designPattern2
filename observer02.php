<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/4/1
 * Time: 下午8:21
 */
/*
 * php已经帮我们准备好了两个接口，我们没有必要重造轮子，这两个接口分别是SplObserver和SplSubject，关于这两个接口的定义，可以查看以下官方文档：

SplObserver：http://php.net/manual/zh/class.splobserver.php
SplSubject：http://php.net/manual/zh/class.splsubject.php

 */
class Phone implements SplObserver{
    private $tem;

    public function update(SplSubject $subject){
        $this->tem = $subject->item;
        echo $this->tem.'from phone ';
    }
}

class Watch implements SplObserver{
    private $tem;
    public function update(SplSubject $subject){
        $this->tem = $subject->item;
        echo $this->tem.'from watch ---->';
    }
}

class Items implements SplSubject {
    protected $observers;
    public $item='hello'; //如果使用保护属性或者私有属性 传递给其他类的时候 需要使用到单独的函数去输出这个值
    function attach(SplObserver  $obj){
        $this->obsevers[] = $obj;
    }

    function notify(){
        foreach ($this->obsevers as $v){
            $v->update($this);
        }
    }

    function change($c=''){
        if($c)$this->item=$c;
        $this->notify();
    }

    /* (non-PHPdoc)
     * @see SplSubject::detach()
     */
    public function detach(SplObserver $observer) {
        // TODO Auto-generated method stub
        $key = array_search($observer, $this->observers, true);
        if($key){
            unset($this->observers[$key]);
        }
    }

}
$item = new Items();
$item->attach(new Watch());
$item->attach(new Phone());
$item->change();
echo '<br>';
$item->change('my');

exit;
//class Iphone implements SplObserver{
//    private $_temperature;
//    private $_pressure;
//    private $_humidity;
//    /* (non-PHPdoc)
//     * @see Equipment::update()
//     */
//    public function update(SplSubject $subject) {
//        // TODO Auto-generated method stub
//        $this->_temperature = $subject->getTemperature();
//        $this->_pressure = $subject->getPressure();
//        $this->_humidity = $subject->getHumidity();
//
//        $this->display();
//    }
//    /* (non-PHPdoc)
//     * @see Equipment::display()
//     */
//    public function display() {
//        // TODO Auto-generated method stub
//        echo "Current conditions:<br />
//                temperature:$this->_temperature;<br />
//                pressure:$this->_pressure;<br />
//                humidity:$this->_humidity;<br />
//                    --From Iphone client<br />";
//    }
//
//
//
//}
//
//class Iwatch implements SplObserver{
//    private $_temperature;
//    private $_pressure;
//    private $_humidity;
//    /* (non-PHPdoc)
//     * @see Equipment::update()
//     */
//    public function update(SplSubject $subject) {
//        // TODO Auto-generated method stub
//        $this->_temperature = $subject->getTemperature();
//        $this->_pressure = $subject->getPressure();
//        $this->_humidity = $subject->getHumidity();
//
//        $this->display();
//    }
//    /* (non-PHPdoc)
//     * @see Equipment::display()
//     */
//    public function display() {
//        // TODO Auto-generated method stub
//        echo "Current conditions:<br />
//                temperature:$this->_temperature;<br />
//                pressure:$this->_pressure;<br />
//                humidity:$this->_humidity;<br />
//                    --From Iwatch client<br />";
//    }
//
//}
//
//class Mac implements SplObserver{
//    private $_temperature;
//    private $_pressure;
//    private $_humidity;
//    /* (non-PHPdoc)
//     * @see Equipment::update()
//     */
//    public function update(SplSubject $subject) {
//        // TODO Auto-generated method stub
//        $this->_temperature = $subject->getTemperature();
//        $this->_pressure = $subject->getPressure();
//        $this->_humidity = $subject->getHumidity();
//
//        $this->display();
//    }
//    /* (non-PHPdoc)
//     * @see Equipment::display()
//     */
//    public function display() {
//        // TODO Auto-generated method stub
//        echo "Current conditions:<br />
//                temperature:$this->_temperature;<br />
//                pressure:$this->_pressure;<br />
//                humidity:$this->_humidity;<br />
//                    --From Mac client<br />";
//    }
//}
//
//class WeatherData implements SplSubject{
//    protected $observers;
//    private $_temperature;
//    private $_pressure;
//    private $_humidity;
//
//    /* (non-PHPdoc)
//     * @see Subject::notify()
//     */
//    public function notify() {
//        foreach ($this->observers as $observer){
//            $observer->update($this);
//        }
//    }
//
//    public function dataChange($temperature, $pressure, $humidity){
//        $this->_temperature = $temperature;
//        $this->_pressure = $pressure;
//        $this->_humidity = $humidity;
//
//        $this->notify();
//    }
//
//    public function getTemperature(){
//        return $this->_temperature;
//    }
//
//    public function getPressure(){
//        return $this->_pressure;
//    }
//
//    public function getHumidity(){
//        return $this->_humidity;
//    }
//    /* (non-PHPdoc)
//     * @see SplSubject::attach()
//     */
//    public function attach(SplObserver $observer) {
//        // TODO Auto-generated method stub
//        $this->observers[] = $observer;
//    }
//
//    /* (non-PHPdoc)
//     * @see SplSubject::detach()
//     */
//    public function detach(SplObserver $observer) {
//        // TODO Auto-generated method stub
//        $key = array_search($observer, $this->observers, true);
//        if($key){
//            unset($this->observers[$key]);
//        }
//    }
//
//
//
//}
//
//$subject = new WeatherData();
//$observer1 = new Iwatch();
//$observer2 = new Iphone();
//$observer3 = new Mac();
//$subject->attach($observer1);
//$subject->attach($observer2);
//$subject->attach($observer3);
//
//$subject->dataChange('38摄氏度', '气压好高啊', '很湿润');