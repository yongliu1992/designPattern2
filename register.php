<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 25/11/2017
 * Time: 10:51
 */
/**
 * 注册器模式
 * 将对象 注册到一个全局注册树上
 * 与工厂方法+单例子 模式结合的时候，初始化的时候，拿到对象，注册到全局注册树，然后其他的需要用的时候 直接从这个注册树上拿
 */

class Register
{
    protected static  $objects;

    //设置对象别名
    static function set($alias,$object)
    {
        self::$objects[$alias] = $object;
    }

    //销毁注册树上的这个 别名的对象
    static function get($alias)
    {
        unset(self::$objects[$alias]);
    }
}

class Register2
{
    protected static $obj;

    static function set($alias,$object)
    {
        self::$obj[$alias] = $object;
    }

    static function get($alias)
    {
        unset(self::$obj[$alias]);
    }
}

