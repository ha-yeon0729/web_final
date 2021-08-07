<?php
    require_once 'lib.php';
    $link= mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    if (!$link){
        err_message("DB 연결에 실패했습니다.<br>");
    }

    $char=mysqli_set_charset($link,"utf8");
    if (!$char){
        err_message("UTF-8 문자셋을 설정하지 못했습니다.<br>");
    }
    $filtered=array(
        'reply'=>mysqli_real_escape_string($link,$_POST['reply']),
        'writing_num'=>mysqli_real_escape_string($link,$_POST['글_번호'])
    );

    $no=$_SESSION["login_user_no"];

    $sql="INSERT INTO Reply
        (writing_num,member_id,replies,created)
    VALUES('{$filtered['writing_num']}','$no','{$filtered['reply']}',NOW())";

    $result=mysqli_query($link,$sql);
    $id=$filtered['writing_num'];

    if (!$result){
    err_message("SQL에 오류가 있습니다.<br>");
    } else{
        err_message("성공적으로 댓글을 작성했습니다!","crud.php?no=$no&id=$id");
    }
?>
  