<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

$valor = $_POST["valor"];
$part = $_POST["part"];

$sql1 = $db->prepare("SELECT * FROM paramspart WHERE pcod = '$part' AND cod = '$valor'");
$sql1->execute();
$rs = $sql1->fetch(PDO::FETCH_ASSOC);	
$desc = ($valor=='00')?bpart($part):trim($rs['des']);

$data['value']= $desc;
$json =json_encode($data);
echo $json;
?>
