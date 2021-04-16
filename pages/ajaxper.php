<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

$valor = $_POST["valor"];

$sql1 = $db->prepare("SELECT * FROM nomadab:personal WHERE cod = '$valor'");
$sql1->execute();
$rs = $sql1->fetch(PDO::FETCH_ASSOC);	

$data['value']= trim($rs['apat'])." ".trim($rs['amat'])." ".trim($rs['nombre']);
$data['codigo']= trim($rs['cod']);
$data['cid']= trim($rs['cid']);
$json =json_encode($data);
echo $json;
?>
