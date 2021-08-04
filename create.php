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
        <form action="create_process.php?id=<?=$no;?>" method="post">
            <p><input type="text" name="title" placeholder="제목"></p>
            <p><textarea name="sentence" placeholder="내용"></textarea></p>

            <td class="form-data">
            <input type="submit" value="생성" class="form-button" id="submit">
            </td>
        </form>
    </body>
</html>




