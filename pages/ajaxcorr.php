<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

$txtgest=$_POST['txtgest'];
$txtprev=$_POST['txtprev'];
$txtipo=$_POST['txtipo'];

try {
  $sql1 = $db->prepare("SELECT nvl(max(idprev),0) idp FROM maesigep WHERE gestion='$txtgest' AND nro='$txtprev' AND tipo='$txtipo'");
  $sql1->execute();
  $rs = $sql1->fetch(PDO::FETCH_ASSOC);	
  $idprev = $rs['idp']+1;
  echo $idprev;
} catch (Exception $e) {
  echo "Error!! No se genero el Correlativo del Preventivo";
}
?>
