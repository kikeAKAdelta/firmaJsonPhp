<?php

require_once './php-jws-master/src/JWS.php';
//La libreria esta basada en el RFC7515

use Gamegos\JWS;

$headers = [
    'alg' => 'HS256',       //es requerrido
    'typ' => 'JWT'
];

$payload = [
    'sub' => 'kike@example.com',
    'iat' => '1402993531'
];

$key = 'some-secret-for-hmac';

$jws = new Gamegos\JWS\JWS();

// ENCODE: este metodo verifica que la llave sea correcta
$jwsString = $jws->encode($headers, $payload, $key);

printf("encode:\n%s\n\n", $jwsString); //eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJzb21lb25lQGV4YW1wbGUuY29tIiwiaWF0IjoiMTQwMjk5MzUzMSJ9.0lgcQRnj_Jour8MLdIc71hPjjLVcQAOtagKVD9soaqU%

echo "<br><br>";

/**Firmamos el JSON */
$json = [
    "mijson" => "json firmado",
    "tokenJWS" => $jwsString
];

echo json_encode($json);
echo "<br><br>";

//decode
/**Necesitamos la key (clave con la cual creamos la firma) y la firma creada */
$decode = $jws->verify($jwsString, $key);

echo '<br>';
print_r($decode);




?>