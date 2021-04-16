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

$txtpart=$_POST['txtpart'];
$txtspart=$_POST['txtspart'];
$txtmonto=$_POST['txtmonto'];

try {
  $sql = "INSERT INTO maesigep VALUES('$txtgest','$txtprev','$txtcorr','$txtfecha','$txthtd','$txtglosa','$hdnscta',";
  $sql.= "'$txtfte','$txtorg','$txtprog','$txtproy','$txtact','".$_SESSION["sialmausr"]."','".date('d/m/Y')."' ";
  $sql.= ",'".$_SESSION["sialmausr"]."','".date('d/m/Y')."','$txtipo','C')";
  $query = $db->prepare($sql);
  $query->execute();
  
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
} catch (Exception $e) {
  //echo "Error";
  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>
