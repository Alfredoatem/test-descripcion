<?php
session_start();
include "connections/connect.php";
include "functions/global.php";

$uuser =$_POST['usuario'];
$upass = md5($_POST['contrasena']);

$qr  = "SELECT count(*) as nr,usr_id,usr_nombre,usr_user,usr_rol ";
$qr .= "FROM usuarios WHERE usr_user = ? ";
$qr .= " AND usr_pass = ? AND usr_estado='A' AND usr_modulo='sialma' ";
$qr .= "GROUP BY 2,3,4,5";

$p = $db->prepare($qr);
$p->bindParam(1, $uuser , PDO::PARAM_STR);
$p->bindParam(2, $upass , PDO::PARAM_STR);
$p->execute();
$row = $p->fetch(PDO::FETCH_ASSOC);	

if($row['nr']==1){

  $_SESSION["sialmamodulo"] = "sialma";
  $_SESSION["sialmanombre"] = trim($row['usr_nombre']);
  $_SESSION["sialmausr"] = trim($row['usr_user']);
	$_SESSION["sialmarol"] = trim($row['usr_rol']);
	
  if (verpermalma($row['usr_user'])==1 || $_SESSION["sialmarol"]=='admin'){
    $_SESSION["authsialma"] = "pendiente";
    header ("Location: autalma.php");
  }else{
    $_SESSION["authsialma"] = "si";
    header ("Location: pages/index.php");  
  }
}

else if($row['nr'] <= 0) {
	header("Location: index.php?errorusuario=si");
} 
?>