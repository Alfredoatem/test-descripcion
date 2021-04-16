<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

$txtgest=$_POST['txtgest'];
$txtprev=$_POST['txtprev'];
$txtipo=$_POST['txtipo'];
$txtcorr=$_POST['txtcorr'];

$txtfecha=$_POST['txtfecha'];
$txthtd=$_POST['txthtd'];
$txtglosa=utf8_decode($_POST['txtglosa']);
$hdnscta=$_POST['hdnscta'];
$txtfte=$_POST['txtfte'];
$txtorg=$_POST['txtorg'];
$txtprog=$_POST['txtprog'];
$txtproy=$_POST['txtproy'];
$txtact=$_POST['txtact'];

try {
  if(verdescargo($txtgest,$txtprev,$txtcorr,$txtipo)=="1"){
    if(verhtd($txtgest,$txtprev,$txtcorr,$txtipo)!='X'){
      echo "<strong>No se puede Modificar.</strong> Tiene Descargo de Cuenta!!!";  
    }else{
      $sql = "UPDATE maesigep SET htd='$txthtd', usr_upd='".$_SESSION["sialmausr"]."', fec_upd='".date('d/m/Y')."' ";
      $sql.= "WHERE gestion='$txtgest' AND nro='$txtprev' AND idprev='$txtcorr' AND tipo='$txtipo'";
      $query = $db->prepare($sql);
      $query->execute();
      
      if($txtgest<date('Y')){
        echo "Ok";
      }else{
        echo "Sin HTD";
      }   
    }
  }else{
    $sql = "UPDATE maesigep SET fecha='$txtfecha', htd='$txthtd', glosa='$txtglosa', scta='$hdnscta', ";
    $sql.= "fte='$txtfte', orgfin='$txtorg', prog='$txtprog', proy='$txtproy', act='$txtact', ";
    $sql.= "usr_upd='".$_SESSION["sialmausr"]."', fec_upd='".date('d/m/Y')."' ";
    $sql.= "WHERE gestion='$txtgest' AND nro='$txtprev' AND idprev='$txtcorr' AND tipo='$txtipo'";
    $query = $db->prepare($sql);
    $query->execute();
    echo "Ok";
  }
} catch (Exception $e) {
  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>
