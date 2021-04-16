<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

$txtgest=$_POST['txtgest'];
$txtprev=$_POST['txtprev'];
$txtipo=$_POST['txtipo'];
$txtcorr=$_POST['txtcorr'];
$txtfini=$_POST['txtfini'];
$txtffin=$_POST['txtffin'];
$txtobs=utf8_decode($_POST['txtobs']);

try {
  if(verpartpas($txtgest,$txtprev,$txtcorr,$txtipo)=="0"){
    echo "<strong>Error. No Puede Registrar!!</strong> La Partida No corresponde a Pasajes y/o Viaticos";
  }else{
    if(verpasajes($txtgest,$txtprev,$txtcorr,$txtipo)=="1"){
      $sql = "UPDATE pyvsigep SET inicom='$txtfini', fincom='$txtffin', obs='$txtobs',";
      $sql.= "usr_ins='".$_SESSION["sialmausr"]."', fec_ins='".date('d/m/Y')."' ";
      $sql.= "WHERE gestion='$txtgest' AND nro='$txtprev' AND idprev='$txtcorr' AND tipo='$txtipo'";
      $query = $db->prepare($sql);
      $query->execute();
      echo "Actualizado";
    }else{
      $sql = "INSERT INTO pyvsigep VALUES ('$txtgest','$txtprev','$txtcorr','$txtfini','$txtffin','$txtobs',";
      $sql.= "'".$_SESSION["sialmausr"]."','".date('d/m/Y')."','$txtipo') ";
      $query = $db->prepare($sql);
      $query->execute();
      echo "Registrado";
    }
  }
  
} catch (Exception $e) {
  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>
