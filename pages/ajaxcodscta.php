<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

$codt = $_POST["codt"];
$codst = $_POST["codst"];

$sql1 = $db->prepare("SELECT max(cod) ucod FROM conpre20:sctas WHERE cod[1,2] = '".$codt.$codst."'");
$sql1->execute();
$rs = $sql1->fetch(PDO::FETCH_ASSOC);	

$data['value']= trim($rs['ucod']);
$data['tipocod']= $codt.$codst;
$data['longitud'] = strlen(trim($rs['ucod']))-2;
$json =json_encode($data);
echo $json;
?>
