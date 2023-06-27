<?php

require_once './php-jws-master/src/JWS.php';
//La libreria esta basada en el RFC7515

use Gamegos\JWS;

$headers = [
    'alg' => 'RS512',       //es requerrido
    'typ' => 'JWT'
];

$payload = [
    'sub' => 'kike@example.com',
    'iat' => '1402993531'
];

$jws = new Gamegos\JWS\JWS();

// ENCODE: Con este metodo firmamos con la llave privada
$privateKey = file_get_contents(__DIR__ . '/firmaprivada.key');
$jwsString  = $jws->encode($headers, $payload, $privateKey);

printf("encode:\n%s\n\n", $jwsString); //eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJzb21lb25lQGV4YW1wbGUuY29tIiwiaWF0IjoiMTQwMjk5MzUzMSJ9.AXce7-bXUYkhKzAd5aRGpiTH3IqDIw5V1nORSUKgNAz8zvyFZ5Leq8P6IfpZ9vFj3tKeIyME0TZAUM9Lmpt1lwSEZj7u4_pRQox5Jt79gjA4bjX0_ZurR7lPOVXd8srcb8QQeW2RL7Ul5VMfbcqr6_lc8tilG_qZB6r9UhLNrRs
echo "<br><br>";

/**Firmamos el JSON */
$json = [
    "mijson"   => "json firmado",
    "tokenJWS" => $jwsString
];

echo json_encode($json);
echo "<br><br>";

$file = 'firmado_json_jws.json';
file_put_contents($file, json_encode($json));

//Decode
/**Necesitamos la key publica y la firma creada para verificar */

$publicKey = file_get_contents(__DIR__ . '/firmapublica.key');

$decode = $jws->verify($jwsString, $publicKey);

echo '<br>';
print_r($decode);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button type="button" onclick="descargarJson('DTE'); return false;">Descargar Archivo Firmado</button>
</body>
</html>

<script>

    /**
     * Funcion encargada de crear un elemento A para poder descargar un archivo JSON firmado
     */
    var descargarJson = (nomArchivo) =>{
        element = document.createElement('a');
        element.setAttribute('href', 'http://localhost/jws/firmado_json_jws.json');                       //Ubicacion del archivo fisico
        element.setAttribute('download', nomArchivo);       //Nombre del archivo

        document.body.appendChild(element);
        element.click();
    }
</script>