<?php

 /* $dbhost="localhost";
  $dbuser="root";
  $dbpassword="";
  mysql_query('set names utf-8');
  $dbDatabase="pv";
  $con=mysql_query($dbhost,$dbuser,$dbpassword) or die('数据库连接失败');
  mysql_select_db($dbDatabase);*/
 require_once'db/dbbase.php';

//记录访客信息
function ModeAddVisitRecord($hostuid,  $visitip)
{
    $vtime = time();
    $strSql = "insert into visit(hostuid,visitip,visittime) VALUES ($hostuid,  '$visitip', $vtime)";
    $result = mysql_query($strSql);
    if(!$result)
    {
        //eLog($strSql . " " . mysql_error(), __FILE__, __LINE__);
        return false;
    }
    return true;
}

//访问量
 function ModeVisitNum($uid)
 {
     $strSql="select count(*) from visit where hostuid=$uid";
     $result=mysql_query($strSql);
     if(!$result)
     {
       /*  eLog($strSql."".mysql_error(),__FILE__,__LINE__);*/
         return false;
     }
     $row=mysql_fetch_row($result);
     if(!$row)
     {
         return 0;
     }
     return $row[0];
 }


?>