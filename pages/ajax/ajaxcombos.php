<?
require_once "../seguridad.php";
require_once "../../connections/connect.php";
require_once "../../functions/global.php";


$list = $_REQUEST["list"];
$sel = $_REQUEST["sel"];
$idval = $_REQUEST["valor"];

//echo "aca  ".$sel."  termina";
switch($list){
  case 'tiper':
    $qr = $db->query("SELECT * FROM paramtipper ORDER BY 1")->fetchAll(PDO::FETCH_ASSOC);
		$combo = "<option value=''>-Seleccione-</option>";
    foreach($qr as $rs){
			$sd =(trim($rs["cod"])==trim($_REQUEST["sel"]))?'Selected':'';
//        $sd ='';
      $lista = (trim($rs["cod"])=='.')?$rs["cod"]:$rs["cod"]." - ".$rs["des"];
			$combo .= "<option value='".$rs["cod"]."' $sd>".$lista."</option>";
		}
		echo iconv("ISO-8859-1","UTF-8",$combo);
	break;
  case 'ffin':
    $qr = $db->query("SELECT * FROM paramffin ORDER BY 1")->fetchAll(PDO::FETCH_ASSOC);
		$combo = "<option value=''>-Seleccione-</option>";
    foreach($qr as $rs){
			$sd =(trim($rs["cod"])==trim($_REQUEST["sel"]))?'Selected':'';
//            $sd ='';
			$combo .= "<option value='".$rs["cod"]."' $sd>".$rs["cod"]." - ".$rs["des"]."</option>";
		}
		echo iconv("ISO-8859-1","UTF-8",$combo);
	break;
  case 'ofin':
//    $qr = $db->query("SELECT * FROM paramofin WHERE codffin = '".$idval."' ORDER BY 1")->fetchAll(PDO::FETCH_ASSOC);
      $qr = $db->query("SELECT * FROM paramofin ORDER BY 1")->fetchAll(PDO::FETCH_ASSOC);
		$combo = "<option value=''>-Seleccione-</option>";
    foreach($qr as $rs){
			$sd =(trim($rs["cod"])==trim($_REQUEST["sel"]))?'Selected':'';
			$combo .= "<option value='".$rs["cod"]."' $sd>".$rs["cod"]." - ".$rs["sigla"]."</option>";
		}
		echo iconv("ISO-8859-1","UTF-8",$combo);
	break;

}

?>