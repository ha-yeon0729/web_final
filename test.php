<?php
    $url="<script>alert(1)</script>";
    $str=htmlentities($url,ENT_QUOTES,"UTF-8");
    echo n12br($str);
?>