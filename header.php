<?php

$myinfo = '<button id="login" onclick="javascirpt:location.href=\'login.php\';">登录</button>
            <button id="register" onclick="javascirpt:location.href=\'register.php\';">注册';
if(!empty($_SESSION['uid']))
{
    require_once 'db/userdb.php';
    $userinfo = ModeGetTeacherInfo($_SESSION['name']);
    $nm = empty($userinfo['name']) ? $userinfo['uid'] : $userinfo['name'];
    $myinfoformat = '
            <div class="my-icon"></div>
            <div class="my-uname"><!--<a href=0.php?>-->%s<!--</a>--></div><div class="my-quit"><a href="process.php?cmd=quit">退出</a></div> ';
    $myinfo = sprintf($myinfoformat, $userinfo['name'],$nm);
}
?>

<div class="nav">
    <div class="nav-contain">
        <div class="logo">
           <a href="index.php"> <img src="img/php.jpg"  style="width: 60px;" ></a>
        </div>
        <div class="serach">
            <h5>学生成绩信息管理系统</h5>
        </div>
        <div class="opertor">
            <?php echo $myinfo; ?>
            <!--<div class="my-icon"><img src="img/icon.png"></div>
            <div class="my-uname">熊贤贺</div>-->
            <!--<button id="login" onclick="javascirpt:location.href='login.php';">登录</button>
            <button id="register" onclick="javascirpt:location.href='register.php';">注册</button>-->
        </div>
    </div>
</div>