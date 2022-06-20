<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $url = "https://www.datos.gov.co/resource/gt2j-8ykr.json";
    $res = json_decode(file_get_contents($url));
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte COVID-19 CO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    
    <div class="container d-flex align-content-center justify-content-center flex-column" style="height: 100vh">
        <h1>Generar Reporte Covid-19 Colombia &#x1F1E8;&#x1F1F4;</h1>
        <a href="./generate-report.php" class="btn btn-primary">Generar Reporte</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>