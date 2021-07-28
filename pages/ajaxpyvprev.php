<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

$txtdcto=$_POST['txtdcto'];
$txtnro=$_POST['txtnro'];
$txtgest=$_POST['txtgest'];
$txtfini=$_POST['txtfini'];
$txtffin=$_POST['txtffin'];
$txtobs=utf8_decode($_POST['txtobs']);

//echo $txtfini;
//echo "<br>";
//echo $txtffin;
//echo "<br>";
//echo $txtdcto;
//echo "<br>";
try {
  if(verpartpas($txtgest,$txtnro)=="0"){
    echo "<strong>Error. No Puede Registrar!!</strong> La Partida No corresponde a Pasajes y/o Viaticos";
  }else{
//    echo "<strong> Puede Registrar!!</strong> La Partida corresponde a Pasajes y/o Viaticos";
    if(verpasajes($txtgest,$txtnro)=="1"){
//      $sql = "UPDATE pyvsigep SET inicom='$txtfini', fincom='$txtffin', obs='$txtobs',";
//      $sql.= "usr_ins='".$_SESSION["sialmausr"]."', fec_ins='".date('d/m/Y')."' ";
//      $sql.= "WHERE gestion='$txtgest' AND nro='$txtprev' AND idprev='$txtcorr' AND tipo='$txtipo'";
//      $query = $db->prepare($sql);
//      $query->execute();
      echo "Actualizado";
    }else{
//      $sql = "INSERT INTO pyvsigep VALUES ('$txtgest','$txtprev','$txtcorr','$txtfini','$txtffin','$txtobs',";
//      $sql.= "'".$_SESSION["sialmausr"]."','".date('d/m/Y')."','$txtipo') ";
//      $query = $db->prepare($sql);
//      $query->execute();
      echo "Registrado";
    }
  }

} catch (Exception $e) {
  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>
