<?php
    define("DBHOST","localhost");
    define("DBUSER","dbuser");
    define("DBPASS","dbpass");
    define("DBNAME","webdb_book");

    error_reporting(E_ALL);
    ini_set('display_errors','1');

    session_start();

    function err_message($msg, $uri=null){
        if (isset($uri)){
            echo "<html><head><script>
            alert(\"{$msg}\");
            location.href='{$uri}';     
            </script><head><html>";
        } //location.href 는 이 에러 메시지를 띄운 다음 이동할 페이지를 가리킨다. 
        else{
            echo "<html><head><script>
            alert(\"{$msg}\");
            history.go(-1);
            </script></head></html>";
        }       //만약 함수 인자에 url을 생략하면 그 전 페이지로 이동한다. 
        exit();
    }
?>