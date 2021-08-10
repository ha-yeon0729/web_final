<?php
    require_once 'lib.php';
    $link= mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
            $char=mysqli_set_charset($link,"utf8");
    if (!$char){
            err_message("UTF-8 문자셋을 설정하지 못했습니다.<br>");
        }
    $no=$_SESSION['login_user_no'];
    $nameshow=$_SESSION['nameshow'];    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>처음화면</title>
    </head>
    <link href ="style.css" rel="stylesheet" type="text/css">
        <style>
            body{
                    background-image: url('../pictures/ssg.png');
                    background-position: bottom bottom;
                    background-attachment: local;
                    background-repeat: no-repeat;
            }
        </style>
        <style type="text/css">
            a:link { font-weight:bold; text-decoration:underline; }
            a:visited { text-decoration:underline; }
            a:active { text-decoration:underline; }
            a:hover { color:purple; font-weight:bold; text-decoration:underline; }
        </style> 
    <body>
        <div>
            <center>
            <h1>다른 사람들이 쓴 글을 확인해보세요!</h1>
            </center>
        </div>
        <nav>
            <span><a href="create.php?no=<?=$no?>">작성하기</a></span>
            <span><a href="logout.php?no=<?=$no?>">로그아웃</a></span>
            <span style="float:right"><a href="crud.php?no=$no"><?=$nameshow?></a>님 환영합니다!</span>
        </nav>
    </body>
    
</html>
<?php

    $sql="SELECT * FROM topic";
    $result=mysqli_query($link,$sql);
    $list='';
    echo '<ol>';
    while ($show=mysqli_fetch_array($result)){
        $title=$show['title'];
        $mid=$show['member_id'];
        $id=$show['id'];
        
        echo '<div class="borders"><li><a href="showlogin.php?no='.$mid.'&id='.$id.'">'.$show['title'].'</a></li></div>';
        
    }
    echo '</ol>';
?>
