<?php
    require_once 'lib.php';

    $link= mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    $char=mysqli_set_charset($link,"utf8");
    if (!$char){
            err_message("UTF-8 문자셋을 설정하지 못했습니다.<br>");
        }
    $mid=$_GET['no'];
    $id=$_GET['id'];
    if (!isset($mid)){
        echo "ERROR 1!!";
    }
    else if (!isset($id)){
        echo "ERROR 2!!";
    }
    else{
        $filtered_id=mysqli_real_escape_string($link,$id);
        $sql="SELECT * FROM topic WHERE id=$filtered_id";
        $result=mysqli_query($link,$sql);
        $show=mysqli_fetch_array($result);
        $article=array(
            'title'=>$show['title'],
            'sentence'=>$show['sentence'],
            'created'=>$show['created'],
            'file_name'=>$show['file_address']
        );
        $filename= $article['file_name'];
        $writing_num=$filtered_id;    


}
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
                <h1>환영합니다</h1>
            </center>
        </div>
        <nav>
            <span><a href="register-form.php">회원가입</a></span>
            <span><a href="login-form.php">로그인</a></span> 
            <span><a href="index.php">목차</a></span>   
        </nav>    

        <h1><em><?=$article['title']?></em></h1>
        <pre><?=$article['sentence']?></pre>
        <?php 
            $filesize=filesize($show['file_address']);
            if ($filesize>0){
                echo '<img src='.$show['file_address'].' style="width:300px; height;auto;">';
            }
        ?>
        <br><br>
        <hr width="100%" size="1">
        <div class="borders">
            <h2><댓글 목록></h2>
            <hr width="100%" size="1">
            <h3>댓글은 로그인 후 볼 수 있습니다!</h3>
        </div>
    </body>
</html>