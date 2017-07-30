<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/7/30
 * Time: 21:44
 */
/*负载均衡器的设计与实现
       Sunny软件公司承接了一个服务器负载均衡(Load Balance)软件的开发工作，
该软件运行在一台负载均衡服务器上，可以将并发访问和数据流量分发到服务器集群中的多台设备上进行并发处理，
提高系统的整体处理能力，缩短响应时间。由于集群中的服务器需要动态删减，且客户端请求需要统一分发，因
此需要确保负载均衡器的唯一性，只能有一个负载均衡器来负责服务器的管理和请求的分发，否则将会带来服务器状态的不一致以及请求分配冲突等问题。
如何确保负载均衡器的唯一性是该软件成功的关键。
      Sunny公司开发人员通过分析和权衡，决定使用单例模式来设计该负载均衡器，
将负载均衡器LoadBalancer设计为单例类，其中包含一个存储服务器信息的集合serverList，每次在serverList中随机选择一台服务器来响应客户端的请求，实现代码如下所示：*/

//负载均衡器LoadBalancer：单例类，真实环境下该类将非常复杂，包括大量初始化的工作和业务方法，考虑到代码的可读性和易理解性，只列出部分与模式相关的核心代码
class LoadBalancer {
    //私有静态成员变量，存储唯一实例
private static  $instance = null;
    //服务器集合
public  $serverList = null;

    //私有构造函数
private function __construct() {
$this->serverList = [];
}

    //公有静态成员方法，返回唯一实例
    public static function getLoadBalancer() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    //增加服务器
    public function addServer($server) {
    $this->serverList[] = $server;
}

    //删除服务器
    public function removeServer($server) {
    unset($this->serverList[$server]);
}

    //使用Random类随机获取服务器
    public function getServer() {

         $i = mt_rand(0,count($this->serverList)-1);

        return $this->serverList[$i];
    }
}
    //  编写如下客户端测试代码：
class Client {
public static function index() {
    //创建四个LoadBalancer对象
$balancer1 = LoadBalancer::getLoadBalancer();
$balancer2 = LoadBalancer::getLoadBalancer();
$balancer3 = LoadBalancer::getLoadBalancer();
$balancer4 = LoadBalancer::getLoadBalancer();

    //判断服务器负载均衡器是否相同
if ($balancer1 == $balancer2 && $balancer2 == $balancer3 && $balancer3 == $balancer4) {
echo("服务器负载均衡器具有唯一性！");
}


        //增加服务器
        $balancer1->addServer("Server 1");
        $balancer1->addServer("Server 2");
        $balancer1->addServer("Server 3");
        $balancer1->addServer("Server 4");
    echo '<br/>';
        //模拟客户端请求的分发
        for ($i = 0; $i < 10; $i++) {
    $server = $balancer1->getServer();
            echo("分发请求至服务器： " . $server.'<br/>');
      }
    }
}
Client::index();
    /*   输出结果如下：
服务器负载均衡器具有唯一性！
分发请求至服务器：  Server 1
分发请求至服务器：  Server 3
分发请求至服务器：  Server 4
分发请求至服务器：  Server 2
分发请求至服务器：  Server 3
分发请求至服务器：  Server 2
分发请求至服务器：  Server 3
分发请求至服务器：  Server 4
分发请求至服务器：  Server 4
分发请求至服务器：  Server 1
        虽然创建了四个LoadBalancer对象，但是它们实际上是同一个对象，因此，通过使用单例模式可以确保LoadBalancer对象的唯一性。*/