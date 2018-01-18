<?php
/**
 * Created by PhpStorm.
 * User: yongLiu
 * Date: 18/01/2018
 * Time: 09:35
 */

class Sing
{
    static protected $instance;
    private $number;

   final protected function __construct()
    {
        $this->number=mt_rand();
    }

    static function getInstance()
    {
        if(self::$instance==null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    function getNumber()
    {
        echo $this->number.'<br/>';
    }

}

for ($i=0;$i<10;$i++)
{
    Sing::getInstance()->getNumber();
}

for ($i=0;$i<7;$i++)
{
    Sing::getInstance()->getNumber();
}