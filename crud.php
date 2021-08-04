<?php
require_once 'lib.php';
$link= mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);

// 에러
if (!$link){
    err_message("DB 연결에 실패했습니다.<br>");
}

$char=mysqli_set_charset($link,"utf8");
if (!$char){
    err_message("UTF-8 문자셋을 설정하지 못했습니다.<br>");
}

$no=$_SESSION["login_user_no"];

// 제목만 보이는 목차들 각각에 하이퍼링크 넣기 (쿼리스트링 포함)
$sql="SELECT * FROM topic";
$result=mysqli_query($link,$sql);
$list='';
while ($show=mysqli_fetch_array($result)){   
    if ($show['member_id']==$no)
    $list=$list."<li><a href=\"crud.php?no=$no&id={$show['id']}\">{$show['title']}</a></li>";
}

// 글 내용의 디폴트 값
$article=array(
    'title'=>'WELCOME',
    'sentence'=>'Read it!',
    'created'=>''
);

//링크의 디폴트 값
$update_link='';
$delete_link='';

// 글 제목을 클릭해서 topic table의 id값을 얻었다면
// 글 제목, 내용, 작성일 보여주기
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
    $update_link = '<a href="update.php?id='.$_GET['id'].'">수정하기</a>';
    $delete_link = '<a href="delete.php?id='.$_GET['id'].'">삭제하기</a>';
}

$write_link='<a href="create.php?no='.$no.'">작성하기</a>';
$logout_link='<a href="logout.php?no='.$no.'">로그아웃</a>';
?>

<!--화면 구성 -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>crud</title>
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
        <div>
            <h1>페이지를 멋지게 꾸며보세요!</h1>
        </div>
        <nav>        
            <span><?=$write_link?></span>        
            <span><?=$logout_link?></span>   
        </nav>
        목차
        <ol>
            <?=$list?>
        </ol>
        
        <h2><?=$article['title']?></h2>

        <?=$article['sentence']?><br><br>
        <?= "작성일 :" ?>
        <?=$article['created']?><br><br>

        
        <span class="active"><?=$update_link?></span>
        <span class="active"><?=$delete_link?></span>
        

    </body>
</html>
