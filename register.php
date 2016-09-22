<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>STUDENTSCORE</title>
   <link href="css/main.css" rel="stylesheet">
    <link href="css/answer.css" rel="stylesheet">
    <link href="css/myquestion.css" rel="stylesheet">
    <link href="css/register.css" rel="stylesheet">
    <style>
        table{

            border-collapse: collapse;/*合并单元格*/
            line-height: 2;
            border-spacing: 0;/*表格之间空隙为0*/
            width:100%;
            text-align: center;
        }
        th{
            background-color: #4A8091;
        }
        td{
            /* width: 40px;*/
            /*  background-color: #c7ddef;*/
        }
        .id{
            width: 100%;
            line-height:2 ;
        }
        table *{
            border: 1px solid ;
        }
        tr{
            line-height: 2;
        }
    </style>

</head>
<body>
<?php require_once 'header.php';?>
<div class="main-content">
    <div class="left-content">
        <div class="title">
            <strong>注册教师信息</strong>
        </div>

        <div class="register-contain">
            <form action="process.php?cmd=register" method="post">
                <input type="text" name="name" placeholder="姓名" value="<?php echo empty($_COOKIE['name'])?'':$_COOKIE['name']?>">
                <input id="password" type="password" name="password" placeholder="【密码】">
                <input id="passwordsec" type="password" name="passwordsec" placeholder="【再次密码】">
                <input id="bntregistere" type="submit" name="submit" value="一定要输入信息哦">
            </form>
            <div class="errormsg">
                <?php
               if(!empty($_GET['errno']))
                {
                    $errno = $_GET['errno'];
                    switch ($errno)
                    {
                        case 1: echo '* name不能为空';break;
                        case 2: echo '* password不能为空';break;
                        case 3: echo '* 两次密码不一致';break;
                        case 7: echo '* 用户名已经被注册';break;
                        case 8: echo '* 服务器繁忙，请稍后再试';break;
                    }
                }
                ?>
            </div>
        </div>

    </div>
    <div class=" right-nav">
    <?php require_once 'rightnav.php';?>
        </div>
</div>
<?php require_once 'footer.php';?>
</body>
</html>



<!--<html>
<head>
    <title></title>
    <style>
        table{

            border-collapse: collapse;/*合并单元格*/
            line-height: 2;
            border-spacing: 0;/*表格之间空隙为0*/
            width:100%;
            text-align: center;
        }
        th{
            background-color: #4A8091;
        }
        td{
            /* width: 40px;*/
            /*  background-color: #c7ddef;*/
        }
        .id{
            width: 100%;
            line-height:2 ;
        }
        table *{
            border: 1px solid ;
        }
        tr{
            line-height: 2;
        }
    </style>
</head>
<body>
<div class="table">
    <form action="process.php?cmd=register" method="post">
        <table>
            <tr>
                <th>姓名(中文简体字)</th>
                <td><input class="id" type="text" name="uname" value="<?php /*echo empty($_COOKIE['uname'])?'':$_COOKIE['uname']*/?>"></td>
            </tr>
            <tr>
                <th>平时成绩(20%)</th>
                <td><input class="id" type="text" name="normalscore"></td>
            </tr>
            <tr>
                <th>考试成绩(80%)</th>
                <td><input class="id" type="text" name="examscore"></td>
            </tr>
            <tr>
                <th colspan="2"><input type="submit" value="录入"></th>
            </tr>
        </table>
    </form>
    <?php
/*    if(!empty($_GET['errno']))
    {
        $errno = $_GET['errno'];
        switch ($errno)
        {
            case 1: echo '* uname不能为空';break;
            case 4: echo '* 考试分数不能为空';break;
            case 6: echo '* 平时分数不能为空';break;
            case 7: echo '* 用户已经存在';break;
            case 8: echo '* 服务器繁忙，请稍后再试';break;
        }
    }
    */?>
</div>
</body>
</html>-->