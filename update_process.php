<?php
    require_once 'lib.php';
    $link= mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    //
    if (!$link){
        err_message("DB 연결에 실패했습니다.<br>");
    }


    $char=mysqli_set_charset($link,"utf8");
    if (!$char){
        err_message("UTF-8 문자셋을 설정하지 못했습니다.<br>");
    }

    $filtered=array(
        'id'=>mysqli_real_escape_string($link,$_POST['id']),
        'title'=>mysqli_real_escape_string($link,$_POST['title']),
        'sentence'=>mysqli_real_escape_string($link,$_POST['sentence'])
    );

    $sql="UPDATE topic
        SET
            title='{$filtered['title']}',
            sentence='{$filtered['sentence']}'
        WHERE
            id={$filtered['id']}";

    $result=mysqli_query($link,$sql);


    if (!$result){
        err_message("SQL에 오류가 있습니다.<br>");
        } else{
            err_message("성공적으로 글을 수정했습니다!","crud.php");
        }

?>