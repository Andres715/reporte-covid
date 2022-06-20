<?php

    require_once("./generate-report.php");

    $url = "https://www.datos.gov.co/resource/gt2j-8ykr.json";
    $res = json_decode(file_get_contents($url));

    var_dump($res);

    

?>