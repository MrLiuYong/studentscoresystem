<?php
/*
 * user表相关的接口文件
 */

require_once 'dbbase.php';

/*
 * 根据telphone判断用户是否存在
 * 如果存在，返回true
 * 如果不存在，返回false
 */
function Exist($name)
{
    $sqlSql = "select uid from teacher where name='$name'";
    echo $sqlSql;
   /* echo $sqlSql;*/
    $result = mysql_query($sqlSql);
    if($result)
        return false;
    else
        return true;
}


function IsExist($uname)
{
    $sqlSql = "select uid from liuyong where uname='$uname'";
    $result = mysql_query($sqlSql);
    if($result)
        return false;
    else
        return true;
}
/*
 * 教师注册
 * 注册成功返回true，否则返回false
 */
function ModeRegister($name, $password)
{
    if(Exist($name))
        return false;// 当用户存在时，不允许注册
    $password = md5($password);
    $strSql = "insert into teacher(uid, name, password) VALUES (0, '$name', '$password')";
    //echo $strSql;
   $result = mysql_query($strSql);
    if(!$result)
    {
       return false;
    }
    return true;
}

//录入信息
function ModeInsertInformation($uname, $normalscore,$examscore)
{
    if(Exist($uname))
        return false;// 当用户存在时，不允许注册
    $total = $normalscore+$examscore*0.8;
    $strSql = "insert into liuyong(uid,uname,normalscore,examscore,totalscore) VALUES (0, '$uname', '$normalscore','$examscore','$total')";
   /* echo $strSql;*/
    $result = mysql_query($strSql);
    if(!$result)
    {
        return false;
    }
    return true;
}
//var_dump(ModeInsertInformation("勇s",'11','11'));
/*
 * 教师登录
 * 登录成功返回该用信息，否则返回false
 */
function ModeLogin($name, $password)
{
    $password = md5($password);
    // 233' or 1=1 or uname='
    $strSql = sprintf("select uid, name, password from teacher where name='%s' and password='%s'", $name, $password);
   // echo $strSql;
    $result = mysql_query($strSql);
    if(!$result)
    {
       // eLog("登录失败 $strSql " . mysql_error(), __FILE__, __LINE__);
        return false;
    }
    $row = mysql_fetch_row($result);
    if(!$row)
        return false;
    $user=array();
    $user['uid']=$row[0];
    $user['name']=$row[1];
    $user['password']=$row[2];
    return $user;
}

/**
 * 更新用户信息
 * 更新成功返回true，失败返回false
 */
function ModeUpdateUserInfo($uid,$uname, $normalscore,$examscore)
{
    $totalscore=$normalscore+$examscore*0.8;
    $strSqlFormat = "update liuyong set uname='%s',normalscore='%s',examscore='%s',totalscore='%s' where uid=%d";
    $strSql = sprintf($strSqlFormat,$uname,$normalscore,$examscore,$totalscore,$uid);
  //  echo $strSql;
    $result = mysql_query($strSql);
    if(!$result)
    {
        //eLog($strSql . " " . mysql_error(), __FILE__, __LINE__);
        return false;
    }
    $num = mysql_affected_rows();
    if ($num == 0)
        return false;
    return true;
}

/**
 * 获取单个用户信息
 * @param $uid
 * @return array|bool
 */
//获取教师信息
function ModeGetTeacherInfo($name)
{
    $stru="select uid, name from teacher where name='$name'";
    // echo $stru;
    $struu=mysql_query("$stru");
    if(!$struu)
        return false;
    $strr=mysql_fetch_row($struu);
    //mysql_free_result($struu);
    $user=array();

    $user['uid']=$strr[0];
    $user['name']=$strr[1];

    return $user;
}

//查询单个学生信息
function ModeGetOneUserInfo($uname)
{
    $stru="select uid, uname, normalscore,examscore,totalscore from liuyong where uname='$uname'";
    //echo $stru;
   $struu=mysql_query("$stru");
    if(!$struu)
        return false;
    $strr=mysql_fetch_row($struu);
    //mysql_free_result($struu);
    $user=array();
    $user['uid']=$strr[0];
    $user['uname']=$strr[1];
    $user['normalscore']=$strr[2];
    $user['examscore']=$strr[3];
    $user['totalscore']=$strr[4];
    return $user;
}

//通过uid获取用户信息
function ModeGetOneUserInfoByUid($uid)
{
    $stru="select uid, uname, normalscore,examscore,totalscore from liuyong where uid='$uid'";
    // echo $stru;
    $struu=mysql_query("$stru");
    if(!$struu)
        return false;
    $strr=mysql_fetch_row($struu);
    //mysql_free_result($struu);
    $user=array();

    $user['uid']=$strr[0];
    $user['uname']=$strr[1];
    $user['normalscore']=$strr[2];
    $user['examscore']=$strr[3];
    $user['totalscore']=$strr[4];

    return $user;
}
//修改密码
function ModeResetPassword($uname,$password)
{
    $password=md5($password);
    $strSql="update user set password='$password' where uname=$uname";
    //echo $strSql;
    $result=mysql_query($strSql);
    if(!$result)
    {
        return false;
    }
    return true;
}

//根据考试总分排序，获取所有学生信息
/*,SUM (normalscore,examscore*0.8) as totalscore */
function DbGetAllInfoOrderByTotalScore()
{
    $strSql='select uid,uname,normalscore,examscore,totalscore from liuyong order by totalscore desc';
    $result=mysql_query($strSql);
    if(!$result)
    {
        //eLog(mysql_error() . " " . $strSql, __FILE__, __LINE__);
        return false;
    }
    $info = array();
    $i = 0;
    while($row = mysql_fetch_row($result))
    {
        $info[$i]['uid'] = $row[0];
        $info[$i]['uname'] = $row[1];
        $info[$i]['normalscore'] = $row[2];
        $info[$i]['examscore'] = $row[3];
        $info[$i]['totalscore'] = $row[4];
        $i++;
    }
    mysql_free_result($result);
    return $info;
}
//根据考试分数排序，获取所有学生信息
function DbGetAllInfoOrderByExamScore()
{
    $strSql='select uid,uname,normalscore,examscore,totalscore from liuyong order by examscore desc';
    $result=mysql_query($strSql);
    if(!$result)
    {
        //eLog(mysql_error() . " " . $strSql, __FILE__, __LINE__);
        return false;
    }
    $info = array();
    $i = 0;
    while($row = mysql_fetch_row($result))
    {
        $info[$i]['uid'] = $row[0];
        $info[$i]['uname'] = $row[1];
        $info[$i]['normalscore'] = $row[2];
        $info[$i]['examscore'] = $row[3];
        $info[$i]['totalscore'] = $row[4];
        $i++;
    }
    mysql_free_result($result);
    return $info;

}

//根据平时分数排序，获取所有学生信息
function DbGetAllInfoOrderByNormalscore()
{
    $strSql='select uid,uname,normalscore,examscore,totalscore from liuyong order by normalscore desc';
    $result=mysql_query($strSql);
    if(!$result)
    {
        //eLog(mysql_error() . " " . $strSql, __FILE__, __LINE__);
        return false;
    }
    $info = array();
    $i = 0;
    while($row = mysql_fetch_row($result))
    {
        $info[$i]['uid'] = $row[0];
        $info[$i]['uname'] = $row[1];
        $info[$i]['normalscore'] = $row[2];
        $info[$i]['examscore'] = $row[3];
        $info[$i]['totalscore'] = $row[4];
        $i++;
    }
    mysql_free_result($result);
    return $info;

}

//删除信息

function DeleteInfo($uid)
{
    $strSql="delete from liuyong where uid=$uid";
    $result=mysql_query($strSql);
    return $result;

}