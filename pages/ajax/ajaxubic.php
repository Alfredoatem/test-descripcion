<?
require_once "../seguridad.php";
require_once "../../connections/connect.php";
require_once "../../functions/global.php";

$valor = $_POST["valor"];

$sql1 = $db->prepare("SELECT * FROM paramubic WHERE cod = '$valor'");
$sql1->execute();
$rs = $sql1->fetch(PDO::FETCH_ASSOC);	

$data['value']= trim($rs['des']);
$json =json_encode($data);
echo $json;
?>
