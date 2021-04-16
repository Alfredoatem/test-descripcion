<?php
require_once "../seguridad.php";
require_once "../../connections/connect.php";
require_once "../../functions/global.php";

$sql = "SELECT * FROM paramdctoalma WHERE codgranalma='".$_SESSION["sialmagalm"]."' AND aceo[2] in ('I','S') ORDER BY 1 ";
$qr = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$lista = "";
/*$ruta = (basename($_SERVER['PHP_SELF'])=='index.php')?"views/":"";*/
foreach($qr as $rs){
  $form = strtolower(trim($rs["aceo"]));
  $icono = (substr(trim($rs["aceo"]),1,1)=='I')?"fa-upload":"fa-download";
  $lista .= '<li> <a href="formsrc'.$form.'.php?transac='.substr($rs["cod"],1,1).'"><i class="fa '.$icono.' fa-fw"></i> '.$rs["cod"].' - '.$rs["des"].'</a> </li>';
}
echo iconv("ISO-8859-1","UTF-8",$lista);
?>