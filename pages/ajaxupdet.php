<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

$txtgest=$_POST['txtgest'];
$txtprev=$_POST['txtprev'];
$txtipo=$_POST['txtipo'];
$txtcorr=$_POST['txtcorr'];

$txtpart=$_POST['txtpart'];
$txtspart=$_POST['txtspart'];
$txtmonto=$_POST['txtmonto'];

try {
  if(verdescargo($txtgest,$txtprev,$txtcorr,$txtipo)=="1"){
    echo "<strong>No se puede Modificar.</strong> Tiene Descargo de Cuenta!!!";
  }else{
    $sqldel = "DELETE FROM detsigep WHERE gestion='$txtgest' AND nro='$txtprev' AND idprev='$txtcorr' AND tipo='$txtipo'";
    $qrydel = $db->prepare($sqldel);
    $qrydel->execute();

    foreach($txtpart as $k => $part){
      if($part!='' && $txtspart[$k]!='' && $txtmonto[$k]!=''){
        $c = $c + 100000;
        $sqldet = "INSERT INTO detsigep VALUES('$txtgest','$txtprev','$txtcorr','$c',";
        $sqldet.= "'$part','".$txtspart[$k]."','".$txtmonto[$k]."','$txtipo')";
        $query = $db->prepare($sqldet);
        $query->execute();
      }
    }
    echo "Ok";
  }
  
} catch (Exception $e) {
  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>
