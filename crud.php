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

    // 로그인 한 사용자 이름
    $namesql="SELECT username,`no` FROM book_members";
    $nameresult=mysqli_query($link,$namesql);
    if (!$nameresult){
        echo "SQL에 오류가 있습니다.";
        exit();
    }    
    while($row=mysqli_fetch_array($nameresult)){ //검색된 결과셋에서 레코드 하나를 가져옴
        if ($row["no"]==$no){ //검색된 결과가 있으면
            $nameshow = $row["username"];
            $_SESSION['nameshow']=$nameshow;
        }
    }
    
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
    $List='';
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
            'file_name'=>$show['file_address'],
            'writer'=>$show['member_id']
        );
        $update_link = '<a href="update.php?id='.$_GET['id'].'">수정하기</a>';
        $delete_link = '<a href="delete.php?id='.$_GET['id'].'">삭제하기</a>';
        $filename= $article['file_name'];
        $writing_num=$filtered_id;    

        //댓글 보여주기
        $Sql="SELECT * FROM Reply";
        $Result=mysqli_query($link,$Sql);
        if (!$Result){
            echo "SQL에 오류가 있습니다.";
            exit();          
        }
        while ($Show=mysqli_fetch_array($Result)){
            if ($Show['writing_num']==$writing_num){
                $rep=$Show['replies'];
                $time=$Show['created'];
                $List=$List."$rep&nbsp;&nbsp;$time";
            }
            //댓글 작성자 보여주기
            if ($Show['writing_num']==$_GET['id']){
                    $namesql="SELECT username,`no` FROM book_members";
                    $nameresult=mysqli_query($link,$namesql);
                    if (!$nameresult){
                        echo "SQL에 오류가 있습니다.";
                        exit();
                    }
                    while($row=mysqli_fetch_array($nameresult)){ //검색된 결과셋에서 레코드 하나를 가져옴
                        if ($row["no"]==$Show['member_id']){ //검색된 결과가 있으면
                            $_SESSION['replywriter']=$row["username"];
                            $replywriter=$_SESSION['replywriter'];
                            $List=$List."&nbsp;$replywriter 님<br>";
                }
            }
        }
    }
}
    $write_link='<a href="create.php?no='.$no.'">작성하기</a>';
    $all_link='<a href="indexlogin.php">목차</a>';
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
        <style type="text/css">
            a:link { font-weight:bold; text-decoration:underline; }
            a:visited { text-decoration:underline; }
            a:active { text-decoration:underline; }
            a:hover { color:purple; font-weight:bold; text-decoration:underline; }
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
            <span><?= $all_link?></span>  
            <span><?=$logout_link?></span> 
            <span style="float:right"><a href="crud.php?no=$no"><?=$nameshow?></a>님 환영합니다!</span></nav>
        <hr width="100%" color ="sky blue" size="2"></hr> 
        <h3> <?=$nameshow?> 님의 글 목록 </h3>
        <ol>
            <?=$list?>
        </ol>
        <hr width="100%" color ="sky blue" size="2"></hr>    
    
        <h1><em><?=$article['title']?></em></h1>

        <pre><?= $article['sentence']?></pre>
        
        <?php 
            $filesize=filesize($show['file_address']);
            if ($filesize>0){
                echo '<img src='.$show['file_address'].' style="width:300px; height;auto;">';
            }
        ?>
        <br><br>        
        
        <form action="download.php" method="POST">
            <input type="submit" name="download_button" value= "파일 다운로드" style="CURSOR:pointer;" title=<?= $filename ?>>
            <input type="hidden" name="addr" value=<?=$article['file_name']?>>
        </form>        
        <br><br>     
        <?=$article['created']?><br><br>
        <span class="active"><?=$update_link?></span>
        <span class="active"><?=$delete_link?></span>      
        <br><br>      
       
        <!-- 댓글 기능 -->
        <hr width="100%" size="1">
        <h2>댓글을 남겨 보세요!</h2>
        <tr>
            <form action="reply.php" method="post">
                <td><textarea name="reply"></textarea></td>
                <input type="hidden" name="글_번호" value=<?=$writing_num?>>
                <td><input type="submit" value="작성" class="form-button" id="submit"></td>
            </form>
        </tr>    
        <div class="borders">
            <h3><댓글 목록></h3>
            <hr width="100%" size="1">
            <?=$List?>
        </div>
        <br><br>
    </body>
</html>