<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

$txtgest=$_POST['txtgest'];
$txtprev=$_POST['txtprev'];
$txtipo=$_POST['txtipo'];
$txtcorr=$_POST['txtcorr'];

try {
  if(verdescargo($txtgest,$txtprev,$txtcorr,$txtipo)=="1"){
    echo "No se puede eliminar!!! Tiene Descargo de Cuenta";  
  }else{
    $sqldel = "DELETE FROM maesigep WHERE gestion='$txtgest' AND nro='$txtprev' AND idprev='$txtcorr' AND tipo='$txtipo';";
    $sqldel.= "DELETE FROM detsigep WHERE gestion='$txtgest' AND nro='$txtprev' AND idprev='$txtcorr' AND tipo='$txtipo';";
    $qrydel = $db->prepare($sqldel);
    $qrydel->execute();
    echo "Ok";
  }
} catch (Exception $e) {
  echo "Error!! Intente Nuevamente";
  //echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>
