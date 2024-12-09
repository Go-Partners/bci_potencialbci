<?php

$envFilePath = '/home/potencialbci/secrets.env';
$envVariables = [];
$lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$allowedDomain = 'https://www.potencialbci.cl';
foreach ($lines as $line) {
    //echo "A";
    if ($line !== '' && strpos($line, '=') !== false && strpos($line, '#') !== 0) {
        list($key, $value) = explode('=', $line, 2);
        $key = strtoupper(str_replace(['.', '-'], '_', $key));
        if (preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $key)) {
            $envVariables[$key] = $value;
        } else {
        }
    }
}
foreach ($envVariables as $key => $value) {
    $value=addslashes($value);
    $value=htmlspecialchars($value);
    $key=htmlspecialchars($key);
    if (preg_match('/^[A-Z0-9_]{10,29}$/', $key)) {
        putenv("$key=$value");
    } else {
    }
}
require_once("../_config_.php");
$c_host = $databaselocation;
$c_user = $databaseuser;
$c_pass = $databasepass;
$c_db   = $databasename;
$Num_Rows_Default = 1;
$from_2022="notificaciones@potencialbci.cl";
$nombrefrom_2022="Potencial Bci";
$api_key_2022=getenv('api_key_2024');
$url_front="https://www.potencialbci.cl";
$url_base="https://www.potencialbci.cl";
$from="notificaciones@potencialbci.cl";
$nombrefrom="potencialbci";
$tipo="text/html";
$titulo1="";
$url=$url_base;
$texto_url="Ir a potencialbci";
$texto4="potencialbci.cl";
$periodo_A="2021";
$periodo_B="2022";
$periodo_C="2023";
?>