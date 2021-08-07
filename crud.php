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

    /* 대충 댓글 옆에 자기 아이디도 나타내게 하고 싶어하는 코드
    $namesql="SELECT userid FROM book_members WHERE `no`={$no}";
    $nameresult=mysqli_query($link,$namesql);
    $nameshow="<li>".mysqli_fetch_assoc($nameresult)."</li>";
    */

    // 제목만 보이는 목차들 각각에 하이퍼링크 넣기 (쿼리스트링 포함)
    $sql="SELECT * FROM topic";
    $result=mysqli_query($link,$sql);
    $list='';
    while ($show=mysqli_fetch_array($result)){   //의문. $show 선언이 여기서 되는 겨??
        if ($show['member_id']==$no)
        $list=$list."<li><a href=\"crud.php?no=$no&id={$show['id']}\">{$show['title']}</a></li>";
    }

    // 글 내용의 디폴트 값
    $article=array(
        'title'=>'WELCOME',
        'sentence'=>'Read it!',
        'created'=>'',
        'file_name'=>''
    );

    //링크의 디폴트 값
    $update_link='';
    $delete_link='';
    $filename='';
    $writing_num='';
    // 글 제목을 클릭해서 topic table의 id값을 얻었다면
    // 글 제목, 내용, 작성일, 파일 이름 보여주기
    if (isset($_GET['id'])){
        $filtered_id=mysqli_real_escape_string($link,$_GET['id']);
        $sql="SELECT * FROM topic WHERE id={$filtered_id}";

        $result=mysqli_query($link,$sql);
        $show=mysqli_fetch_array($result);
        $article=array(
            'title'=>$show['title'],
            'sentence'=>$show['sentence'],
            'created'=>$show['created'],
            'file_name'=>$show['file_address']
        );
        $update_link = '<a href="update.php?id='.$_GET['id'].'">수정하기</a>';
        $delete_link = '<a href="delete.php?id='.$_GET['id'].'">삭제하기</a>';
        $filename= $article['file_name'];
        $writing_num=$filtered_id;    
        //댓글 보여주기
        $Sql="SELECT * FROM Reply";
        $Result=mysqli_query($link,$Sql);
        $List='';
        while ($Show=mysqli_fetch_array($Result)){
            if ($Show['writing_num']==$writing_num){
                $ans=$Show['replies'];
                $List=$List."<li>$ans</li>";
                // 댓글 옆에 자기 아이디도 나타내게 하려면.....$List=$List.$ans;
            }
        }
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
            <center>
                <h1>페이지를 멋지게 꾸며보세요!</h1>
            </center>
        </div>
        <nav>        
            <span><?=$write_link?></span>        
            <span><?=$logout_link?></span>   
        </nav>
        
        목차
        <ol>
            <?=$list?>
        </ol>
        <hr width="100%" color ="sky blue" size="2"></hr>
        
        <h1><em><?=$article['title']?></em></h1>
        <pre><ol><span style="background-color : #FBEFFB;"><?=$article['sentence']?></span></ol></pre>

        <?php echo '<img src='.$show['file_address'].' style="width:300px; height;auto;">';?><br><br>        

        <?= $filename ?>
        
        <form action="download.php" method="POST">
            <input type="submit" name="download_button" value= "파일 다운로드">
            <input type="hidden" name="addr" value=<?=$article['file_name']?>>
        </form> 
       
        <br><br>
        
        <?=$article['created']?><br><br>

        <span class="active"><?=$update_link?></span>
        <span class="active"><?=$delete_link?></span>
        
        <br><br>
       
        <!-- 댓글 기능 -->
        <hr width="100%" size="1">
        <h2>댓글 목록</h2>
        <tr>
            <form action="reply.php" method="post">
                <td><textarea name="reply"></textarea></td>
                <input type="hidden" name="글_번호" value=<?=$writing_num?>>
                <td><input type="submit" value="작성" class="form-button" id="submit"></td>
            </form>
        </tr>    
        <?=/*$nameshow."".*/$List?>        

        <br><br>
    </body>
</html>
