<?
require_once "../seguridad.php";
require_once "../../connections/connect.php";
require_once "../../functions/global.php";

//$valor = $_POST["valor"];
//$valor2 = $_POST["valor2"];
//$valor3 = $_POST["valor3"];
//$valor4 = $_POST["valor4"];
//$valor5 = $_POST["valor5"];
//$valor6 = $_POST["valor6"];
//$valor7 = $_POST["valor7"];
//$codgranalm=$_SESSION['sialmagalm'];

$codprod    = $_POST["codprod"];
$dcto_m     = $_POST["dcto_m"];
$nro_m      = $_POST["nro_m"];
$pu         = $_POST["pu"];
$codtip     = $_POST["codtip"];
$txtcant    = $_POST["txtcant"];

$sqldet = "SELECT sum(dcant - hcant)-$txtcant saldo ";
$sqldet.= "from maealma m inner join detalma d on d.dcto = m.dcto and d.nro = m.nro ";
$sqldet.= "where dcto_m='$dcto_m' and nro_m='$nro_m' and codprod='$codprod' and codtip='$codtip' and pu='$pu'";
//$sqldet.= " where dcto_m='cC' and nro_m='6' and codprod='11090114' and codtip='06' and pu='193'";
//cho $sqldet;
$sql = $db->prepare($sqldet);
$sql->execute();
$rs = $sql->fetch(PDO::FETCH_ASSOC);
//echo $rs['saldo'];
$data['value']= $rs['saldo'];
//$data['value']= $valor;
//$data['result2']= $valor2;
//$data['result3']= $valor3;
//$data['result4']= $valor4;
//$data['result5']= $valor5;
//$data['result6']= $valor6;
//$data['result7']= $valor7;
$json =json_encode($data);
echo $json;
?>
