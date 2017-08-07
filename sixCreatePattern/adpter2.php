<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/8/2
 * Time: 23:59
 */
//抽象成绩操作类：目标接口
interface ScoreOperation
{
    public function sort($array); //成绩排序

    public function search($array, $key); //成绩查找
}

//快速排序类：适配者
class QuickSort
{
    public function quickSort($array)
    {
        $this->sort($array, 0, count($array) - 1);
        return $array;
    }

    public function sort($array, $p, $r)
    {
        $q = 0;
        if ($p < $r) {
            $q = $this->partition($array, $p, $r);
            $this->sort($array, $p, $q - 1);
            $this->sort($array, $q + 1, $r);
        }
    }

    public function partition($a, $p, $r)
    {
        $x = $a[$r];
        $j = $p - 1;
        for ($i = $p; $i <= $r - 1; $i++) {
            if ($a[$i] <= $x) {
                $j++;
               $this-> swap($a, $j, $i);
            }
        }
        $this->swap($a, $j + 1, $r);
        return $j+1;
	}

    public function swap($a, $i, $j)
    {
        $t = $a[$i];
        $a[$i] = $a[$j];
        $a[$j] = $t;
    }
}

//二分查找类：适配者
class BinarySearch
{
    public function binarySearch($array, $key)
    {
        $low = 0;
        $high = count($array) - 1;
        while ($low <= $high) {
            $mid = ($low + $high) / 2;
            $midVal = $array[$mid];
            if ($midVal < $key) {
                $low = $mid + 1;
            } else if ($midVal > $key) {
                $high = $mid - 1;
            } else {
                return 1; //找到元素返回1
            }
        }
        return -1;  //未找到元素返回-1
    }
}

//操作适配器：适配器
class OperationAdapter implements ScoreOperation
{
    private $sortObj; //定义适配者QuickSort对象
    private $searchObj; //定义适配者BinarySearch对象

    public function OperationAdapter()
    {
        $this->sortObj = new QuickSort();
        $this->searchObj = new BinarySearch();
    }

    public function sort($array)
    {
        return $this->sortObj->quickSort($array); //调用适配者类QuickSort的排序方法
    }

    public function search($array, $key)
    {
        return $this->searchObj->binarySearch($array, $key); //调用适配者类BinarySearch的查找方法
    }
}

//为了让系统具备良好的灵活性和可扩展性，我们引入了xml
//simplexml_load_file();
?>
//编写如下客户端测试代码：
<!--class Client {]
<!--public static function index($args) {-->
<!--ScoreOperation operation;  //针对抽象目标接口编程-->
<!--operation = (ScoreOperation)XMLUtil.getBean(); //读取配置文件，反射生成对象-->
<!--$scores[] = {84,76,50,69,90,91,88,96}; //定义成绩数组-->
<!--$result[];-->
<!--$score;-->
<!---->
<!--System.out.println("成绩排序结果：");-->
<!--result = operation.sort(scores);-->
<!---->
<!--//遍历输出成绩-->
<!--for($i : scores) {-->
<!--System.out.print(i + ",");-->
<!--}-->
<!--System.out.println();-->
<!---->
<!--System.out.println("查找成绩90：");-->
<!--score = operation.search(result,90);-->
<!--if (score != -1) {-->
<!--System.out.println("找到成绩90。");-->
<!--}-->
<!--else {-->
<!--System.out.println("没有找到成绩90。");-->
<!--}-->
<!---->
<!--System.out.println("查找成绩92：");-->
<!--score = operation.search(result,92);-->
<!--if (score != -1) {-->
<!--System.out.println("找到成绩92。");-->
<!--}-->
<!--else {-->
<!--System.out.println("没有找到成绩92。");-->
<!--}-->
<!--}-->
<!--}-->
<!--编译并运行程序，输出结果如下：-->
<!--成绩排序结果：-->
<!--50,69,76,84,88,90,91,96,-->
<!--查找成绩90：-->
<!--找到成绩90。-->
<!--查找成绩92：-->
<!--没有找到成绩92。-->
<!--在本实例中使用了对象适配器模式，同时引入了配置文件，将适配器类的类名存储在配置文件中。如果需要使用其他排序算法类和查找算法类，可以增加一个新的适配器类，使用新的适配器来适配新的算法，原有代码无须修改。通过引入配置文件和反射机制，可以在不修改客户端代码的情况下使用新的适配器，无须修改源代码，符合“开闭原则”。-->