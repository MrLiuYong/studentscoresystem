<?php
session_start();
//error_reporting(0);

/*if(empty($_SESSION['name']))
{
    header('location:login.php');
    exit();
}*/
require_once 'db/userdb.php';

$type=$_GET['type'];
switch ($type)
{
    case 1:
        $questionInfos = DbGetAllInfoOrderByExamScore();
        $typeTitle = "考试分数";
        break;
    case 2:
        $questionInfos = DbGetAllInfoOrderByNormalscore();
        $typeTitle = "平时分数";
        break;
    case 3:
        $questionInfos = DbGetAllInfoOrderByTotalScore();
        $typeTitle = "总分";
        break;
   /* default:
        $questionInfos =  DbGetAllInfoOrderByTotalScore();
        $typeTitle = "总分";
        break;*/
}
$table = "<table  style='border: 1px solid ;margin: 10px auto;width:100%;text-align: center'>
  <tr>
  <th style=' background-color: #4A8091;'>序号</th>
  <th style=' background-color: #4A8091;'>姓名</th>
  <th style=' background-color: #4A8091;'>平时分数</th>
  <th style=' background-color: #4A8091;'>考试分数</th>
  <th style=' background-color: #4A8091;'>总分</th>
  </tr>";
$questionHtmlFormat ="
  <tr>
  <td  style='background-color: #c7ddef;'>%d</td>
  <td  style='background-color: #c7ddef;'>%s</td>
  <td  style='background-color: #c7ddef;'>%s</td>
  <td  style='background-color: #c7ddef;'>%s</td>
  <td  style='background-color: #c7ddef;'>%s</td>
  </tr>
";
$questionHtmls = "";

if(!empty($questionInfos))
{
    for ($i = 0; $i < count($questionInfos); $i++)
    {
        $uname = $questionInfos[$i]['uname'];
        $uid = $questionInfos[$i]['uid'];
        $examscore = $questionInfos[$i]['examscore'];
        $normalscore = $questionInfos[$i]['normalscore'];
        $totalscore = $questionInfos[$i]['totalscore'];
        $temp = sprintf($questionHtmlFormat,
            $uid,
            $uname/*$questionInfos[$i]['telephone']*/,
            $normalscore,
            $examscore,
            $totalscore
        );
       // echo $temp;
        $questionHtmls .= $temp;
    }
    $table .= $questionHtmls."</table>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>STUDENTSCORE</title>
</head>
<body>
            <?php echo $table; ?>
</body>
</html>