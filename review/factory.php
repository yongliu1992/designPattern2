<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 02/02/2018
 * Time: 23:07
 */
//工厂模式
class Button{/* ...*/}
class WinButton extends Button{/* ...*/}
class MacButton extends Button{/* ...*/}
interface ButtonFactory
{
    public function createButton($type);
}

class MyButtonFactory implements ButtonFactory{
    // 实现工厂方法
    public function createButton($type){
        switch($type){
            case 'Mac':
                return new MacButton();
            case 'Win':
                return new WinButton();
        }
    }
}

$button  = new MyButtonFactory();
var_dump($button->createButton('Mac'));
var_dump($button->createButton('Win'));
//工厂模式与简单工厂模式区别 简单工厂模式 是定义一个创建对象的接口，子类自己决定实现哪个类，而工厂模式是取到对象，由服务端 选择执