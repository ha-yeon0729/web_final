<!DOCTYPE html>
<html>
    <head>
        <title>File Details</title>
</head>
<body>
    <?php
    if (!isset($_GET['file'])) // $ 변수가 설정됐으면 TRUE, 설정되지 않았으면 FALSE를 반환. !FALSE=TRUE니까 false면 echo가 동작하는 것
    {
        echo "You have not specified a file name.";
    }
    else{
        $uploads_dir='./uploads/';

        $the_file=basename($_GET['file']); //basename은 서버로 돌아오는 파일의 이름을 변경. 보안 고려.
        $safe_file=$uploads_dir.$the_file;
        echo '<h1>Details of File: '.$the_file.'</h1>';
        echo '<h2>File Data</h2>';
        echo 'File Last Accessed: '.date('Y F j (D) H:i', fileatime($safe_file)).'<br/>';
        echo 'File Last Modified: '.date('Y F j (D) H:i', filemtime($safe_file)).'<br/>';
        

    echo 'File Permissions: '.decoct(fileperms($safe_file)).'<br/>';
    echo 'File Type: '.filetype($safe_file).'<br/>';
    echo 'File Size: '.filesize($safe_file).' bytes<br>';

    echo '<h2>File Tests</h2>';
    echo 'is_dir: '.(is_dir($safe_file)? 'true' : 'false').'<br/>';
    echo 'is_executable: '.(is_executable($safe_file)? 'true' :'false').'<br/>';
    echo 'is_file: '.(is_file($safe_file)? 'true' : 'false').'<br/>';
    echo 'is_link: '.(is_link($safe_file)? 'true' : 'false').'<br/>';
    echo 'is_readable: '.(is_readable($safe_file)? 'true' : 'false').'<br/>';
    echo 'is_writable: '.(is_writeable($safe_file)? 'true':'false').'<br/>';
    }
?>
</body>
</html>
    