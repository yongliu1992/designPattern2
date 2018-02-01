<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 01/02/2018
 * Time: 13:25
 */
//抽象工厂
namespace review;
interface  AbstractFactory
{
    function createUser();
    function createOrder();
}

class User{}
class Orders{}
class ChinaUser extends User{};
class AlienUser extends Orders{};

class chinaOrder extends Orders{};
class AlienOrder extends Orders{};



class ChinaFactory implements AbstractFactory
{
    function createUser()
    {
        return new ChinaUser();
    }

    function createOrder()
    {
        return new chinaOrder();
    }
}

class AlienFactory implements AbstractFactory
{
    function createOrder()
    {
        return new AlienOrder();
    }

    function createUser()
    {
       return new AlienUser();
    }
}