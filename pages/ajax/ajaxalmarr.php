<?
require_once "../seguridad.php";
require_once "../../connections/connect.php";
require_once "../../functions/global.php";

$valor = $_POST["valor"];
//$valor='001';
//echo $valor;
$sql1 = $db->prepare("SELECT * FROM paramalmacen WHERE cod = '$valor'");
$sql1->execute();
$rs = $sql1->fetch(PDO::FETCH_ASSOC);	
//echo $rs['des'];
$data['value']= trim($rs['des']);
$json =json_encode($data);
echo $json;
?>
