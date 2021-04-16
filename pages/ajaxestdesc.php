<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

$txtgest=$_POST['txtgest'];
$txtprev=$_POST['txtprev'];
$txtipo=$_POST['txtipo'];
$txtcorr=$_POST['txtcorr'];

$sql1 ="SELECT estado FROM descsigep WHERE gestion='$txtgest' AND nro='$txtprev' AND idprev='$txtcorr' AND tipo='$txtipo'";
$rs = $db->query($sql1)->fetch(PDO::FETCH_ASSOC);

$data['value'] = trim($rs['estado']);
$data['revisor'] = $_SESSION["sialmarev"];
$json =json_encode($data);
echo $json;
?>
