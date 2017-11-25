<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 25/11/2017
 * Time: 10:37
 */
class Test
{
    static function createDB()
    {
        $db = new DataBase();
        return $db;
    }
}

class DataBase
{

}
//为什么使用工厂模式
/*
 * 如果不使用工厂模式，每次都去new 一个新对象，如果类名发生变化，则每一个相关的都需要更改
 * 工厂模式 是很多高级设计模式 常用的一个基础模式
 *
 */