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

    // 파일 업로드
    if ($_FILES['the_file']['error']>0)
    {
        echo 'Problem: ';
        switch ($_FILES['the_file']['error'])
        {
        case 1:
            echo 'File exceeded upload_max_filesize.'; //php.ini의 max_filesize 초과
            break;
        case 2:
            echo 'File exceeded max_file-size.';
            break;
        case 3:
            echo 'File only partially uploaded.';
            break;
        case 4:
            echo 'No file uploaded.';
            break;
        case 6:
            echo 'Cannot upload file: No temp directory specified.';
            break;
        case 7:
            echo 'Upload failed: Cannot write to disk.';
            break;
        case 8:
            echo 'A PHP extension blocked the file upload.';
            break;        
        }
        exit;
    }

    //원하는 곳으로 파일을 이동시킨다.
    $uploaded_file = './uploads/'.$_FILES['the_file']['name'];

    if (is_uploaded_file($_FILES['the_file']['tmp_name']))
    {
        if (!move_uploaded_file($_FILES['the_file']['tmp_name'], $uploaded_file))
        {
            echo 'Problem: Could not move file to destination directory.';
            exit;
        }
    }
    else{
        echo 'Problem: Possible file upload attack. Filename: ';
        echo $_FILES['the_file']['name'];
        exit;
    }

    echo 'File uploaded successfully.';


    // 내가 추가=> 제목, 내용이 빈칸일 때 입력하라는 코드.
    (!empty($_POST["title"]))? $userid=mysqli_real_escape_string($link,trim($_POST["title"])): err_message("제목을 입력하세요");
    (!empty($_POST["sentence"]))? $password=mysqli_real_escape_string($link,trim($_POST["sentence"])):err_message("내용을 입력하세요");

    $filtered=array(
        'title'=>mysqli_real_escape_string($link,$_POST['title']),
        'sentence'=>mysqli_real_escape_string($link,$_POST['sentence'])
    );


    // $_SESSION['file_addr']=$uploaded_file; 
    $no=$_SESSION["login_user_no"];

    $sql="INSERT INTO topic
        (title, sentence, created, member_id, file_address)
        VALUES('{$filtered['title']}', '{$filtered['sentence']}',NOW(),'$no','{$uploaded_file}')";

    $result=mysqli_query($link,$sql);

    if (!$result){
        err_message("SQL에 오류가 있습니다.<br>");
        } else{
            err_message("성공적으로 글을 작성했습니다!","crud.php?no=$no");
        }
?>