<?php
session_start();
require_once "connections/connect.php";

$list = $_REQUEST["list"];

switch($list){
  case 'almauser':
    if($_SESSION["sialmarol"]=='admin'){
      $sql = "SELECT t.des tipo, g.cod codgranalma, g.des alma ";
      $sql.= "FROM paramgranalma g INNER JOIN paramtipoalma t on t.cod = g.codtipoalma ";
      $sql.= "Order by 1,3";
    }else{
      $sql = "SELECT t.des tipo, codgranalma, g.des alma FROM permalma a ";
      $sql.= "INNER JOIN paramgranalma g on g.cod = a.codgranalma ";
      $sql.= "INNER JOIN paramtipoalma t on t.cod = g.codtipoalma ";
      $sql.= "Where a.usuario = '".$_SESSION["sialmausr"]."' ORDER by 1,3";  
    }
    
    $qr = $db->query($sql)->fetchAll(PDO::FETCH_GROUP);
    $combo = "";
    foreach($qr as $tipo => $v){
      $combo.= '<optgroup label="'.trim($tipo).'">';
      foreach($v as $fila => $alma){
        $combo .= '<option value="'.trim($alma["codgranalma"]).'">'.trim($alma["codgranalma"]).' - '.trim($alma["alma"]).'</option>';
      }
      $combo.= '</optgroup>';
    }
		echo iconv("ISO-8859-1","UTF-8",$combo);
	break;
}
?>