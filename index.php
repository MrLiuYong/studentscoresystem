<?php
session_start();

error_reporting(0);
/*if(empty($_SESSION['name']))
{
    header('location:login.php');
    exit();
}*/
require_once'visitNum.php';
// 记录访客信息
$clientIP = $_SERVER['REMOTE_ADDR'];
ModeAddVisitRecord( $_SESSION['uid'], $clientIP);
//访问量
$visitnum=ModeVisitNum($_SESSION['uid']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WEB~HTML~CSS</title>
    <link href="css/main.css" rel="stylesheet">
    <link href="css/answer.css" rel="stylesheet">
</head>
<body>
<?php
require_once"header.php";

$type=$_GET['type'];
$uname=$_GET['uname'];
if($type==1)
{
    $Format ="<iframe  height='600px' width='750px' name='left' frameborder='0' src=\"table.php?uname=$uname\"></iframe>";
    $htmlFormat=sprintf($Format);
}
else{
    $Format ='<iframe  height="600px" width="750px" name="left" frameborder="0" src="table.php"></iframe>
';
    $htmlFormat=sprintf($Format);
}
?>

</div>
<div class="main-content">
    <div class="left-content">
        <div class="title">
            <strong>主页</strong>
        </div>
        <div class="main-body" style="">
              <?php echo $htmlFormat;?>

       </div>
         <div class="other">
            <h2> 总访问量:<?php echo $visitnum;?></h2>
         </div>
        <div class="select">
            <form action="process.php?cmd=selectone" method="post">
            <h2>查询单个学生信息：<input type="text" name="uname" value="<?php echo($_COOKIE['uname'])?'':$_COOKIE['uname'] ?>" placeholder="请输入姓名"></h2>
            <input  type="submit" value="搜索">
            </form>
        </div>
    </div>
    <div class="right-nav">
        <div class="menu">
            <?php
            require_once'rightnav.php';
            ?>
        </div>
    </div>
</div>
<div class="footer"></div>
</body>
</html>