<?
require_once "../seguridad.php";
require_once "../../connections/connect.php";
require_once "../../functions/global.php";

//$valor = $_POST["valor"];
//$valor='001';
//echo $valor;
$sqldet = "SELECT d.codalm, d.codprod, p.des, u.des, pu, dcto_m, nro_m, codtip, sum(dcant) as suma1, sum(hcant) as suma2, sum(dcant-hcant) as suma3, sum(dcant)*pu-sum(hcant)*pu as suma4";
$sqldet.= " from maealma m";
$sqldet.= " inner join detalma d on m.dcto=d.dcto and m.nro=d.nro";
$sqldet.= " inner join paramdctoalma z on m.dcto=z.cod";
$sqldet.= " left outer join conpre21:producto p on p.cod = d.codprod";
$sqldet.= " left outer join conpre21:unimedid u on u.cod = p.codumed";
$sqldet.= " where m.voboalma<>'A'";
$sqldet.= " and m.dcto[1]='V' and codalm='001'";
$sqldet.= " and d.codprod = '11090114' and codtip='06'";
$sqldet.= " group by 1,2,3,4,5,6,7,8";
$sqldet.= " having sum(dcant-hcant)>0";
$sqldet.= " order by dcto_m,nro_m";
echo $sqldet."<br>";
$sql = $db->prepare($sqldet);
$sql->execute();
$rs = $sql->fetch(PDO::FETCH_ASSOC);
echo $rs['suma4'];
//$data['value']= trim($rs['des']);
//$json =json_encode($data);
//echo $json;
?>
