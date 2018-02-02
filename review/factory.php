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