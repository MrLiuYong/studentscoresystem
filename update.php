<?php
require_once'db/userdb.php';
if(empty($_GET['uid']))
{
    header('location:table.php');
    exit();
}
$info=ModeGetOneUserInfoByUid($_GET['uid']);
?>

<html>
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
    <form action='process.php?cmd=Update&uid=<?php echo $info['uid']?>' method="post">
        <table>
            <tr>
                <th>姓名(中文简体字)</th>
                <td><input class='id' type='text' name='uname' value='<?php echo $info['uname'];?>'></td>
            </tr>
            <tr>
                <th>平时成绩(20%)</th>
                <td><input class='id' type='text' name='normalscore'></td>
            </tr>
            <tr>
                <th>考试成绩(80%)</th>
                <td><input class='id' type='text'  name='examscore'></td>
            </tr>
            <tr>
                <th colspan='2'><input type='submit' value='提交修改'></th>
            </tr>
        </table>
    </form>
    <?php
    if(!empty($_GET['errno']))
    {
        $errno = $_GET['errno'];
        switch ($errno)
        {
            case 4: echo '* 考试分数不能为空';break;
            case 6: echo '* 平时分数不能为空';break;
            case 8: echo '* 服务器繁忙，请稍后再试';break;
        }
    }
    ?>
</div>
</body>
</html>