<!DOCTYPE html>
<html>
    <head>
        <title>Browse Directories</title>
    </head>
    <body>
    <h1>Browsing</h1>

<?php
    $current_dir='./uploads/';
    $dir=opendir($current_dir);

    echo '<p>Upload directory is '.$current_dir.'</p>';
    echo '<p>Directory List:</p><ul>';

    while (false!==($files=readdir($dir)))
    {
        if ($files!= "." && $files!="..") //디렉터리의 내역을 읽으면 현재 디렉터리를 의미하는 .과 부모 디렉터리를 의미하는 ..도 같이 나타난다. 따라서 여기서는 이 코드를 추가하여 보이지 않게 했다. 
        {
            echo '<li><a href="filedetails.php?file='.$files.'">'.$files.'</a></li>';
        }
    }
    echo '</ul>';
    closedir($dir);
    ?>
</body>
</html>