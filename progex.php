<?php
chdir('./uploads/');

echo '<h1>Using exec()</h1>';
echo '<pre>';
exec('ls -la',$result);

foreach($result as $line)
{
    echo $line.PHP_EOL;
}

echo '</pre>';
echo '<hr />';

//passthru() 함수 사용
echo '<h1>Using passthru()</h1>';
echo '<pre>';
passthru('ls -la');
echo '</pre>';
echo '<hr />';

//system() 함수 사용 시
echo '<h1>Using system()</h1>';
echo '<pre>';
$result=system('ls -la');
echo '</pre>';
echo '<hr />';