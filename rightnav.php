<?php

if(empty($_SESSION['name']))
{
    //echo "<script>alert('请先登录');location.href='login.php';</script>";
   /*header("location: login.php");
    exit();*/
}
?>
<ul>
    <!--<li><a href="0.php" target="left">个人信息</a></li>-->
    <li><a href="inset.php"  target="left">录入信息</a></li>
    <li><a href="1.php?type=1"  target="left">考试分数</a></li>
    <li><a href="1.php?type=2"  target="left">平时分数</a></li>
    <li><a href="1.php?type=3"  target="left">总分</a></li>
</ul>



