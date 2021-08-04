<?php
    require_once 'lib.php';
    $no=$_SESSION["login_user_no"];
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
        <h1>글을 작성해 보세요!</h1>
        <form action="create_process.php?id=<?=$no;?>" method="post" enctype="multipart/form-data">
            <p>제목 : <input type="text" name="title"></p>
            내용 
            <div><textarea name="sentence"></textarea></div>
            
            <p></p>
           
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
            <input type="file" name="the_file" id="the_file" />
            

            <td class="form-data">
            <input type="submit" value="생성" class="form-button" id="submit">
            </td>

        </form>

    </body>
        
</html>




