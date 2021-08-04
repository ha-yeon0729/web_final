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


$sql="SELECT * FROM topic";
$result=mysqli_query($link,$sql);
$list='';
while ($show=mysqli_fetch_array($result)){
    $list=$list."<li><a href=\"crud.php?id={$show['id']}\">{$show['title']}</a></li>";
}

$article=array(
    'title'=>'WELCOME',
    'sentence'=>'Read it!',
    'created'=>''
);

$update_link='';
if (isset($_GET['id'])){
    $filtered_id=mysqli_real_escape_string($link,$_GET['id']);
    $sql="SELECT * FROM topic WHERE id={$filtered_id}";

    $result=mysqli_query($link,$sql);
    $show=mysqli_fetch_array($result);
    $article=array(
        'title'=>$show['title'],
        'sentence'=>$show['sentence'],
        'created'=>$show['created']
    );
    $update_link = '<a href="update.php?id='.$_GET['id'].'">수정</a>';

}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>글 작성</title>
        <link href ="style.css" rel="stylesheet" type="text/css">
        <style>
            body{
                    background-image: url('../pictures/ssg.png');
                    background-position: bottom bottom;
                    background-attachment: local;
                    background-repeat: no-repeat;
            }
        </style>
    </head>
    <body>
        <form action="update_process.php" method="post">
            <input type="hidden" name="id" value="<?=$_GET['id']?>">
            <p><input type="text" name="title" placeholder="제목" value="<?=$article['title']?>"></p>
            <p><textarea name="sentence" placeholder="내용"><?=$article['sentence']?></textarea></p>           
              
            <input type="submit" value="수정" class="form-button" id="submit">
        </form>
    </body>
</html>
