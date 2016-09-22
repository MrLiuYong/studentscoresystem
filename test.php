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
       <form action="process.php" method="post">
       <table>
           <tr>
               <th>姓名(中文简体字)</th>
                <td><input class="id" type="text" name="uname" value="<?php echo empty($_COOKIE['uname'])?'':$_COOKIE['uname']?>"></td>
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
   </div>
</body>
</html>