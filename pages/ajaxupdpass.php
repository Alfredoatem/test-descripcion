<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";

if($_POST['newpass2']!=''){
  $qr ="SELECT usr_pass FROM usuarios WHERE usr_user = '".$_SESSION['sialmausr']."'";
  $rs = $db->query($qr)->fetch(PDO::FETCH_ASSOC);
	
	$filapass = trim($rs['usr_pass']);
	$oldpass = md5($_POST['oldpass']);
  $newpass1 = md5($_POST['newpass1']);
	$newpass2 = md5($_POST['newpass2']);
	
	if($filapass==$oldpass && $newpass1==$newpass2 && $newpass2!=md5('mindef19')){
    try{
      $upd = $db->prepare("UPDATE usuarios SET usr_pass='$newpass2' WHERE usr_user='".$_SESSION['sialmausr']."'");
      $upd->execute();
      echo "Ok";  
    }catch (Exception $e){
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }	
	}elseif($newpass2!=$newpass1){
    echo "ErrorNuevo";
  }elseif($newpass2==md5('mindef19')){
    echo "Incorrecto";
	}else{
    echo "Error";
	}
}
?>
