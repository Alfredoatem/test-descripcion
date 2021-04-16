<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

$txtgest=$_POST['txtgest'];
$txtprev=$_POST['txtprev'];
$txtipo=$_POST['txtipo'];
$txtcorr=$_POST['txtcorr'];
$txtfdesc=$_POST['txtfdesc'];
$txtrevisor=$_POST['txtrevisor'];
$txthtddesc=$_POST['txthtddesc'];
$txtestado=$_POST['txtestado'];
$txtfsal=$_POST['txtfsal'];
$txtanexo=utf8_decode($_POST['txtanexo']);

try {
  if(verdescargo($txtgest,$txtprev,$txtcorr,$txtipo)=="1"){
    if(verestado($txtgest,$txtprev,$txtcorr,$txtipo,$txtestado)=="1"){
      echo "El estado <strong>'$txtestado'</strong> ya se encuentra Registrado!!!. Registre otro estado";
    }else{
      $sql = "UPDATE descsigep SET fecha='$txtfdesc', revisor='$txtrevisor', htddesc='$txthtddesc', estado='$txtestado', ";
      $sql.= "fecha_s='$txtfsal', anexo='$txtanexo', usr_ins='".$_SESSION["sialmausr"]."', fec_ins='".date('d/m/Y')."' ";
      $sql.= "WHERE gestion='$txtgest' AND nro='$txtprev' AND idprev='$txtcorr' AND tipo='$txtipo'";
      $query = $db->prepare($sql);
      $query->execute();
      
      $idkar = genidkar($txtgest,$txtprev,$txtcorr,$txtipo);
      $sqlkar = "INSERT INTO kardesigep VALUES('$txtgest','$txtprev','$txtcorr','$idkar','$txtrevisor',";
      $sqlkar.= "'$txtestado','".date('Y-m-d h:i:s')."','".$_SESSION["sialmausr"]."','$txtipo')";
      $db->query($sqlkar);
      echo "Actualizado";
    }
  }else{
    $sql = "INSERT INTO descsigep VALUES ('$txtgest','$txtprev','$txtcorr','$txtfdesc','$txtrevisor','$txtestado',";
    $sql.= "'$txtanexo','$txthtddesc','$txtfsal','".$_SESSION["sialmausr"]."','".date('d/m/Y')."','$txtipo') ";
    $query = $db->prepare($sql);
    $query->execute();
    
    $idkar = genidkar($txtgest,$txtprev,$txtcorr,$txtipo);
    $sqlkar = "INSERT INTO kardesigep VALUES('$txtgest','$txtprev','$txtcorr','$idkar','$txtrevisor',";
    $sqlkar.= "'$txtestado','".date('Y-m-d h:i:s')."','".$_SESSION["sialmausr"]."','$txtipo')";
    $db->query($sqlkar);
    echo "Registrado";
  } 
} catch (Exception $e) {
  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>
