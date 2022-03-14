<?
//require_once "seguridad.php";
require_once "../../connections/connect.php";
require_once "../../functions/global.php";

$dcto=$_POST['txtdcto'];
$nro=$_POST['txtnro'];
$gestion=$_POST['txtgestion'];
//$txtcorr=$_POST['txtcorr'];
if (isset($_POST['delete'])){
    try {
        if(verdescargo($dcto,$nro,$gestion)=="1"){
          echo "No se puede eliminar!!! Tiene Descargo de Cuenta";  
        }else{
          $sqldel = "DELETE FROM ingteso WHERE dcto='$dcto' AND nro='$nro' AND gestion='$gestion'";
          //$sqldel = "DELETE FROM ingteso WHERE gestion='$txtgest' AND nro='$txtprev' AND idprev='$txtcorr' AND tipo='$txtipo';";
          //$sqldel.= "DELETE FROM detsigep WHERE gestion='$txtgest' AND nro='$txtprev' AND idprev='$txtcorr' AND tipo='$txtipo';";
          $qrydel = $db->prepare($sqldel);
          $qrydel->execute();
          echo "Ok";
        }
      } catch (Exception $e) {
        echo "Error!! Intente Nuevamente";
        //echo 'Excepción capturada: ',  $e->getMessage(), "\n";
      }
}

?>
