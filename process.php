<?php
/**
 * 处理逻辑
 */
session_start();
require_once 'db/userdb.php';

/**
 * 教师注册
 */
function Register()
{
    if(empty($_POST['name']))
    {
        header("location: register.php?errno=1");
        exit();
    }
    if(empty($_POST['password']))
    {
        header("location: register.php?errno=2");
        exit();
    }

    $name=$_POST['name'];
    $password1 = $_POST['password'];
    $password2 = "";
    !empty($_POST['passwordsec']) && $password2 = $_POST['passwordsec'];
    if($password1 != $password2)
    {
        header("location: register.php?errno=3");
        exit();
    }
    if(Exist($name))
    {
        header("location: register.php?errno=7");
        exit();
    }
    $ret = ModeRegister($name, $password1);
    //print_r($ret);
    if(!$ret)
    {
        setcookie('name',$_POST['name']);
        header("location: register.php?errno=8");
        exit();
    }
    echo "<script>alert('注册成功,请登录!');location.href='login.php';</script>";
}

/*录入信息*/
function insetinformation()
{
    if(empty($_SESSION['uid']))
    {
        //header('location:table.php');
        echo"<script>alert('您还未登录');location.href='table.php'</script>";
        return;
    }
    if(empty($_POST['uname']))
    {
        header("location: inset.php?errno=1");
        exit();
    }
    if(empty($_POST['normalscore']))
    {
        header("location: inset.php?errno=6");
        exit();
    }
    if(empty($_POST['examscore']))
    {
        header("location: inset.php?errno=4");
        exit();
    }
    $uname=$_POST['uname'];
    $normalscore=$_POST['normalscore'];
    $examscore=$_POST['examscore'];
    if(IsExist($uname))
    {
        header("location: inset.php?errno=7");
        exit();
    }
    if($_POST['normalscore']>20||$_POST['normalscore']<0)
    {
        echo"<script>alert('分数输入格式不对');location.href='table.php'</script>";
        return;
    }
     if($_POST['examscore']>100||$_POST['examscore']<0)
    {
        echo"<script>alert('分数输入格式不对');location.href='table.php'</script>";
        return;
    }
    $ret = ModeInsertInformation($uname, $normalscore,$examscore);
    if(!$ret)
    {
        setcookie('uname',$_POST['uname']);
        header("location: inset.php?errno=8");
        exit();
    }
  echo "<script>alert('录入成功!');location.href='table.php';</script>";
}

/**
 * 重置密码
 */
function ResetPassword()
{
    if(empty($_POST['email']))
    {
        header('location: index.php');
        exit();
    }
    if(empty($_POST['password']))
    {
        header('location: reset.php?errno=1');
        exit();
    }
    if(empty($_POST['passwordsec']))
    {
        header('location: reset.php?errno=1');
        exit();
    }
    $email = $_POST['email'];
    $isneed = ModeIsNeedVerify($email);
    if(!$isneed)
    {
        header('location: index.php');
        exit();
    }

    $password1 = $_POST['password'];
    $password2 = $_POST['passwordsec'];
    if($password1 != $password2)
    {
        header('location: reset.php?errno=2');
        exit();
    }
    ModeDelVerify($email);
    ModeResetPassword($email, $password1);
    echo '<script>alert("密码重置成功，请登录");location.href="login.php"</script>';
}

/**
 * 教师登录
 */
function Login()
{
    if(empty($_POST['name']))
    {
        header("location:login.php?errno=1");
        exit();
    }
    if(empty($_POST['password']))
    {
        setcookie('email',$_POST['email']);
        header("location:login.php?errno=2");
        exit();
    }
    $name=$_POST['name'];
    $password=$_POST['password'];
    $user=ModeLogin($name, $password);
    //print_r($user);
   if(!$user)
    {
        setcookie('uname',$_POST['uname']);
        header("location:login.php?errno=3");
        exit();
    }
    $_SESSION['name']=$user['name'];
    $_SESSION['uid'] = $user['uid'];
    echo "<script>alert('登录成功');location.href='index.php';</script>";
}

/**
 * 用户退出
 */
function Quit()
{
    if(empty($_SESSION['uid']))
    {
        header("location: index.php");
        return;
    }
    session_destroy();
    setcookie(session_name(),'', time()-1);
    unset($_SESSION);
    header("location: index.php");
}

//删除信息
function Delete()
{
      $uid=$_GET['uid'];
    $str=DeleteInfo($uid);
    if(!$str)
    {
        echo"<script>alert('删除失败');location.href='table.php'</script>";
        return;
    }
    else
        echo"<script>alert('删除成功');location.href='table.php'</script>";
}

//查询用户信息
function selectone()
{
    if(empty($_SESSION['uid']))
    {
        echo"<script>alert('您还未登录!');location.href='index.php'</script>";
        return;
    }
    if (empty($_POST['uname']))
    {
        echo "<script>alert('姓名不能为空');location.href='index.php'</script>";
         return;
    }
    $uname = $_POST['uname'];
   // echo $uname;
   if (!ModeGetOneUserInfo($uname))
    {
        echo "<script>alert('信息不存在');location.href='index.php'</script>";
       // return;
    }
    else
    {
        $info = ModeGetOneUserInfo($uname);
        if($uname!=$info['uname'])
        {
            echo"<script>alert('您所提交的信息不存在');location.href='index.php';</script>";
            //return;
        }
        else
        {
            header("location:index.php?type=1&uname={$info['uname']}");
            exit();
        }

    }
}

/**
 * 修改用户信息
 */
function Update()
{
    if(empty($_SESSION['uid']))
    {
        echo '<script>alert("请先登录!");location.href="table.php";</script>';
        return ;
    }
    if(empty($_POST['normalscore']))
    {
        header("location: inset.php?errno=6");
        exit();
    }
    if(empty($_POST['examscore']))
    {
        header("location: inset.php?errno=4");
        exit();
    }
    $uid=$_GET['uid'];
    $uname=$_POST['uname'];
    $normalscore=$_POST['normalscore'];
    $examscore=$_POST['examscore'];

    $ret =ModeUpdateUserInfo($uid,$uname, $normalscore,$examscore);
  if(!$ret)
    {
        setcookie('normalscore',$_POST['normalscore']);
        setcookie('examscore',$_POST['examscore']);
        header("location: update.php?errno=8");
        exit();
    }
    echo "<script>alert('修改成功!');location.href='table.php'</script>";
}

/**
 * 入口
 */
function main()
{
    if(empty($_GET['cmd']))
    {
        header('location: index.php');
        exit();
    }
    $fun = $_GET['cmd'];
    if(function_exists($fun))
    {
        $fun();
    }
    else {
        header('location: index.php');
        exit();
    }
}

main();