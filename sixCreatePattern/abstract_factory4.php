<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/7/30
 * Time: 15:58
 */

/*完整解决方案
       Sunny公司开发人员使用抽象工厂模式来重构界面皮肤库的设计，
      SkinFactory接口充当抽象工厂，其子类SpringSkinFactory和SummerSkinFactory充当具体工厂，接口Button、TextField和ComboBox充当抽象产品，其子类SpringButton、SpringTextField、SpringComboBox和SummerButton、SummerTextField、SummerComboBox充当具体产品。完整代码如下所示：*/

//在本实例中我们对代码进行了大量简化，实际使用时，界面组件的初始化代码较为复杂，还需要使用JDK中一些已有类，为了突出核心代码，在此只提供框架代码和演示输出。
//按钮接口：抽象产品
interface Button
{
    public function display();
}

//Spring按钮类：具体产品
class SpringButton implements Button
{
    public function display()
    {
        echo("显示浅绿色按钮。").'<br/>';
    }
}

//Summer按钮类：具体产品
class SummerButton implements Button
{
    public function display()
    {
        echo("显示浅蓝色按钮。").'<br/>';
    }
}

//文本框接口：抽象产品
interface TextField
{
public function display();
}

//Spring文本框类：具体产品
class SpringTextField implements TextField
{
    public function display()
    {
        echo("显示绿色边框文本框。").'<br/>';
    }
}

//Summer文本框类：具体产品
class SummerTextField implements TextField
{
    public function display()
    {
        echo("显示蓝色边框文本框。").'<br/>';
    }
}

//组合框接口：抽象产品
interface ComboBox
{
public function display();
}

//Spring组合框类：具体产品
class SpringComboBox implements ComboBox
{
public function display()
{
echo("显示绿色边框组合框。").'<br/>';
}
}

//Summer组合框类：具体产品
class SummerComboBox implements ComboBox
{
    public function display()
    {
        echo("显示蓝色边框组合框。").'<br/>';
    }
}

//界面皮肤工厂接口：抽象工厂
interface SkinFactory
{
public function createButton();
public function createTextField();
public function createComboBox();
}

//Spring皮肤工厂：具体工厂
class SpringSkinFactory implements SkinFactory
{
    public function createButton()
    {
        return new SpringButton();
    }

    public function createTextField()
    {
        return new SpringTextField();
    }

    public function createComboBox()
    {
        return new SpringComboBox();
    }
}

//Summer皮肤工厂：具体工厂
class SummerSkinFactory implements SkinFactory
{
    public function createButton()
    {
        return new SummerButton();
    }

    public function createTextField()
    {
        return new SummerTextField();
    }

    public function createComboBox()
    {
        return new SummerComboBox();
    }
}
    //   为了让系统具备良好的灵活性和可扩展性，我们引入了工具类XML配置文件


class Client
{
    public static function create()
    {
//使用抽象层定义

        $factory = new SpringSkinFactory();
        $bt = $factory->createButton();
        $tf = $factory->createTextField();
        $cb = $factory->createComboBox();
        $bt->display();
        $tf->display();
        $cb->display();

    }
}
Client::create();

/*    输出结果如下：
显示浅绿色按钮。
显示绿色边框文本框。
显示绿色边框组合框。
如果需要更换皮肤，只需修改配置文件即可，在实际环境中，我们可以提供可视化界面，
例如菜单或者窗口来修改配置文件，用户无须直接修改配置文件。
如果需要增加新的皮肤，只需增加一族新的具体组件并对应提供一个新的具体工厂，
修改配置文件即可使用新的皮肤，原有代码无须修改，符合“开闭原则”。*/