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

// 내가 추가
(!empty($_POST["title"]))? $userid=mysqli_real_escape_string($link,trim($_POST["title"])): err_message("제목을 입력하세요");
(!empty($_POST["sentence"]))? $password=mysqli_real_escape_string($link,trim($_POST["sentence"])):err_message("내용을 입력하세요");

$filtered=array(
    'title'=>mysqli_real_escape_string($link,$_POST['title']),
    'sentence'=>mysqli_real_escape_string($link,$_POST['sentence'])
);

$no=$_SESSION["login_user_no"];

$sql="INSERT INTO topic
    (title, sentence, created, member_id)
    VALUES('{$filtered['title']}', '{$filtered['sentence']}',NOW(),'$no')";

$result=mysqli_query($link,$sql);

 if (!$result){
    err_message("SQL에 오류가 있습니다.<br>");
    } else{
        err_message("성공적으로 글을 작성했습니다!","crud.php?no=$no");
    }
?>