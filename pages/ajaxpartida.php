<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

$valor = $_POST["valor"];
$part = substr($valor,0,3);
$spart = substr($valor,-2);  
$desc = ($spart=='00')?bpart($part):bspart($part,$spart);

$data['value']= $desc;
$json =json_encode($data);
echo $json;
?>
