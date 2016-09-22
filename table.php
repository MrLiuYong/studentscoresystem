

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style type="text/CSS">
        <!--
        .page a:link {
            color: #0000FF;
            text-decoration: none;
        }
        .page a:visited {
            text-decoration: none;
            color: #0000FF;
        }
        .page a:hover {
            text-decoration: none;
            color: #0000FF;
        }
        .page a:active {
            text-decoration: none;
            color: #0000FF;
        }
        .page{color:#0000FF;}
        -->
        tr:hover {
            text-decoration: none;
            color: #0000FF;
            font-weight: 300;
        }
        tr{
            line-height: 40px;
        }
    </style>
</head>
<body>
<table width="530" height="103" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">

    <?php
    require_once'db/dbbase.php';
    require_once'db/userdb.php';


    $Page_size=4;//设置页面显示的记录数
    $result=mysql_query('select * from liuyong');
    $count = mysql_num_rows($result);
    $page_count = ceil($count/$Page_size);

    $init=1;
    $page_len=7;
    $max_p=$page_count;
    $pages=$page_count;

    //判断当前页码
    if(empty($_GET['page'])||$_GET['page']<0){
        $page=1;
    }else {
        $page=$_GET['page'];
    }

    $offset=$Page_size*($page-1);// $offset:页面开始位置  $Page_size:结束位置
    $sql="select * from liuyong limit $offset,$Page_size";//分页查找 select *from 表名 limit $offset.$page_size
    $result=mysql_query($sql);
    echo"<table  style='border: 1px solid ;margin: 10px auto;width:100%;text-align: center'  >" ;
    echo"<tr '>
  <th style=' background-color: #4A8091;'>序号</th>
  <th style=' background-color: #4A8091;'>姓名</th>
  <th style=' background-color: #4A8091;'>平时分数</th>
  <th style=' background-color: #4A8091;'>考试分数</th>
  <th style=' background-color: #4A8091;'>总分</th>
  <th style=' background-color: #4A8091;' colspan='2' >操作</th>
</tr>";
    if(isset($_GET['uname']))
    {
         $uname=$_GET['uname'];
         $info=ModeGetOneUserInfo($uname);
             echo"<tr>";
             echo"<td style='background-color: #c7ddef;'>{$info['uid']}</td>";
             echo"<td style='background-color: #c7ddef;'>{$info['uname']}</td>";
             echo"<td style='background-color: #c7ddef;'>{$info['normalscore']}</td>";
             echo"<td style='background-color: #c7ddef;'>{$info['examscore']}</td>";
             echo"<td style='background-color: #c7ddef;'>{$info['totalscore']}</td>";
             echo"<td style='background-color: #c7ddef;'><a href='process.php?cmd=Delete&uid={$info['uid']}'>删除</a></td>";
             echo"<td style='background-color: #c7ddef;'><a href='update.php?uid={$info['uid']}'>修改</a></td>";
             echo"</tr>";
    }
    else
    {
        while($row=mysql_fetch_array($result))
        {
            echo"<tr>";
            echo"<td style='background-color: #c7ddef;'>{$row['uid']}</td>";
            echo"<td style='background-color: #c7ddef;'>{$row['uname']}</td>";
            echo"<td style='background-color: #c7ddef;'>{$row['normalscore']}</td>";
            echo"<td style='background-color: #c7ddef;'>{$row['examscore']}</td>";
            echo"<td style='background-color: #c7ddef;'>{$row['totalscore']}</td>";
            echo"<td style='background-color: #c7ddef;'><a href='process.php?cmd=Delete&uid={$row['uid']}'>删除</a></td>";
            echo"<td style='background-color: #c7ddef;'><a href='update.php?uid={$row['uid']}'>修改</a></td>";
            echo" </tr>";
        }
    }
    echo"</table>";

    $page_len = ($page_len%2)?$page_len:$page_len+1;//页码个数
    $pageoffset = ($page_len-1)/2;//页码个数左右偏移量

    $key='<div class="page">';
    $key.="<span>$page/$pages</span> "; //第几页,共几页
    if($page!=1){
        $key.="<a href=\"".$_SERVER['PHP_SELF']."?page=1\">第一页</a> "; //第一页
        $key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".($page-1)."\">上一页</a>"; //上一页
    }else {
        $key.="第一页 ";//第一页
        $key.="上一页"; //上一页
    }
    if($pages>$page_len){
//如果当前页小于等于左偏移
        if($page<=$pageoffset){
            $init=1;
            $max_p = $page_len;
        }else{//如果当前页大于左偏移
//如果当前页码右偏移超出最大分页数
            if($page+$pageoffset>=$pages+1){
                $init = $pages-$page_len+1;
            }else{
//左右偏移都存在时的计算
                $init = $page-$pageoffset;
                $max_p = $page+$pageoffset;
            }
        }
    }
    for($i=$init;$i<=$max_p;$i++){
        if($i==$page){
            $key.=' <span>'.$i.'</span>';
        } else {
            $key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".$i."\">".$i."</a>";
        }
    }
    if($page!=$pages){
        $key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".($page+1)."\">下一页</a> ";//下一页
        $key.="<a href=\"".$_SERVER['PHP_SELF']."?page={$pages}\">最后一页</a>"; //最后一页
    }else {
        $key.="下一页 ";//下一页
        $key.="最后一页"; //最后一页
    }
    $key.='</div>';
    ?>
   <tr>
        <td colspan="2" bgcolor="#E0EEE0"><div align="center"><?php echo $key?></div></td>
    </tr>
</table>
</body>
</html>
