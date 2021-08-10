<?php
    require_once 'lib.php';
    $link= mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    $char=mysqli_set_charset($link,"utf8");
    if (!$char){
            err_message("UTF-8 문자셋을 설정하지 못했습니다.<br>");
        }
    $no=$_SESSION['login_user_no'];
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
        $filtered_mid=mysqli_real_escape_string($link,$mid);
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
        $writer_num=$filtered_mid;

        //댓글 보여주기
        $Sql="SELECT * FROM Reply";
        $Result=mysqli_query($link,$Sql);
        $List='';
        $writer='';
        while ($Show=mysqli_fetch_array($Result)){
            if ($Show['writing_num']==$writing_num){
                $rep=$Show['replies'];
                $time=$Show['created'];
                $List=$List."$rep&nbsp;&nbsp;$time";
            
                 //댓글 작성자 보여주기
                $namesql="SELECT userid,`no` FROM book_members";
                $nameresult=mysqli_query($link,$namesql);
                if (!$nameresult){
                    echo "SQL에 오류가 있습니다.";
                    exit();
                }
                while($row=mysqli_fetch_array($nameresult)){ //검색된 결과셋에서 레코드 하나를 가져옴
                    if ($row["no"]==$Show['member_id']){ //검색된 결과가 있으면
                        $_SESSION['replywriter']=$row["userid"];
                        $replywriter=$_SESSION['replywriter'];
                        $List=$List."&nbsp;[$replywriter 님]<br>";
                    }
                }
            }
        }
        //글 작성자 보여주기
        $namesql="SELECT username,`no` FROM book_members";
        $nameresult=mysqli_query($link,$namesql);
        if (!$nameresult){
            echo "SQL에 오류가 있습니다.";
            exit();
        }
        while ($row=mysqli_fetch_array($nameresult)){
            if ($writer_num==$row["no"]){
                $_SESSION['writer']=$row['username'];
                $writer=$_SESSION['writer'];
            }
        }
    }
    $nameshow=$_SESSION['nameshow'];
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
                <h1>다른 사람들이 쓴 글을 둘러보고 있는 중입니다....</h1>
            </center>
        </div>
        <nav>
            <span><a href="create.php?no=<?=$no?>">작성하기</a></span>
            <span><a href="logout.php?no=<?=$no?>">로그아웃</a></span>
            <span><a href="indexlogin.php">목차</a></span>
            <span style="float:right"><a href="crud.php?no=$no"><?=$nameshow?></a>님 환영합니다!</span>
        </nav>
        <h1><em><?=$article['title']?></em></h1>
        <span style="float:right">작성자 : <?=$writer?></span>
        <pre><?=$article['sentence']?></pre>
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
        <br>
        <span style="float:right"><?=$article['created']?></span><br>

        <hr width="100%" size="1">
        <tr>
            <h2>댓글을 남겨 보세요!</h2>
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
    </body>
</html>