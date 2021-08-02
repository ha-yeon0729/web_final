<?php
require_once 'lib.php';

//MySQL 서버 연결 및 데이터베이스 선택
$link=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if (!$link){
    err_message("DB 연결에 실패했습니다.<br>");
}

$char=mysqli_set_charset($link,"utf8");
if (!$char){
    err_message("UTF-8 문자셋을 설정하지 못했습니다.<br>");
}

(!empty($_POST["userid"]))? $userid=mysqli_real_escape_string($link,trim($_POST["userid"])) :err_message("회원 아이디를 입력하세요.");
(!empty($_POST["password"])) ? $password=mysqli_real_escape_string($link, trim($_POST["password"])) : err_message("비밀번호를 입력하세요");
(!empty($_POST["repassword"]))?$repassword=mysqli_real_escape_string($link, trim($_POST["repassword"])) : err_message("두 번째 비밀번호를 입력하세요");
(!empty($_POST["username"]))?$username=mysqli_real_escape_string($link,trim($_POST["username"])):err_message("회원 이름을 입력하세요");
(!empty($_POST["email"]))?$email=mysqli_real_escape_string($link,trim($_POST["email"])):err_message("이메일 주소를 입력하세요");
(!empty($_POST["phone"]))?$phone=mysqli_real_escape_string($link,trim($_POST["phone"])):err_message("연락처를 입력하세요");

if ($password<> $repassword){
    err_message("비밀번호가 일치하지 않습니다.");
}

if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    err_message("이메일 주소형식에 맞지 않습니다.");
}

if (!preg_match("/^[a-zA-Z]+[0-9A-Za-z]{3,15}$/",$userid)){
    err_message("아이디는 4-16자의 영문 또는 숫자로만 구성이 가능하며 첫 글자는 영문으로 시작해야 합니다.");
}


 $sql="INSERT INTO book_members
    (userid, `password`, username, email, phone)
    VALUES
    ('{$userid}', md5('{$password}'),'{$username}','{$email}','{$phone}');";
 

$result=mysqli_query($link,$sql);
if (!$result){
    err_message("SQL에 오류가 있습니다.<br>");
}

if (mysqli_affected_rows($link)==0){
    err_message("회원가입에 실패했습니다.");
}

mysqli_close($link);
err_message("회원 가입에 성공했습니다.","login-form.php");

?>