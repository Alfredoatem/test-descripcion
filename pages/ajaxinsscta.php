<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

$cbotscta=$_POST['cbotscta'];
$cbostscta=$_POST['cbostscta'];
$txtcod=$_POST['txtcod'];

$codigo = $cbotscta.$cbostscta.$txtcod;
$txtdes=utf8_decode($_POST['txtdes']);
$hdnscta=$_POST['hdnscta'];

$txtcodp=$_POST['txtcodp'];
$txtci=$_POST['txtci'];

try {
  if(vercodp($txtcodp)=="1"){
    echo "<strong>No se puede Adicionar.</strong> Cuentadante ya fue registrado!!!";  
  }elseif(verscta($codigo)=="1"){
    echo "<strong>Error!!.</strong> El Código ya fue Introducido";
  } else{
    $sql = "INSERT INTO conpre20:sctas VALUES('$codigo','$txtdes','$txtcod','A','$txtci','$txtcodp','".date('d/m/Y')."')";
    $query = $db->prepare($sql);
    $query->execute();
    echo "Ok";
  }
} catch (Exception $e) {
  //echo "Error";
  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>
