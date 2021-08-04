<?php
    require_once 'lib.php';
    $link= mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    
    $no=$_SESSION["login_user_no"];
    "INSERT INTO Reply
    (member_id,replies)
    VALUES('$no','{$_POST['reply']}')";
    err_message("성공적으로 댓글을 작성했습니다!");
?>