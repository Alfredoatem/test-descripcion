<?
require_once "../seguridad.php";
require_once "../../connections/connect.php";
require_once "../../functions/global.php";



$txtgest=$_POST['txtgest'];
$txtdcto=$_POST['txtdcto'];
$txtnro=$_POST['txtnro'];
$txtfecha=$_POST['txtfecha'];
$txthtd=$_POST['txthtd'];
$txtdctoconta=$_POST['txtdctoconta'];
$txtnroconta=$_POST['txtnroconta'];
$txtglosa=$_POST['txtglosa'];
$txtrepar=$_POST['txtrepar'];
$hdnrepar=$_POST['hdnrepar'];
$txtemp=$_POST['txtemp'];
$txtfact=$_POST['txtfact'];
$cboffin=$_POST['cboffin'];
$txtsolpor=$_POST['txtsolpor'];
$txtcite=$_POST['txtcite'];
$txtresp=$_POST['txtresp'];
$cbotiper=$_POST['cbotiper'];
$txtpedi=$_POST['txtpedi'];
//echo $txtgest."<br>";
//echo $txtdcto."<br>";
//echo $txtnro."<br>";
//echo $txtfecha."<br>";
//echo $txthtd."<br>";
//echo $txtdctoconta."<br>";
//echo $txtnroconta."<br>";
//echo $txtglosa."<br>";
//echo $txtrepar."<br>";
//echo $hdnrepar."<br>";
//echo $txtemp."<br>";
//echo $txtfact."<br>";
//echo $cboffin."<br>";
//echo $txtsolpor."<br>";
//echo $txtpedi."<br>";
//echo $txtcotpor."<br>";
//echo $cbotiper."<br>";


//hdnseltiper
//hdnselffin

try {    
    $fecha_upd = date('m/d/Y');
    $date = str_replace('/', '-', $txtfecha);
    $fecha_temp = strtotime($txtfecha);
    $txtfecha = date('m/d/Y', $fecha_temp);
    // $txtfecha = date('Y-m-d');   

    $sql = "UPDATE maealma SET fecha='".$txtfecha."',ref4='$txthtd',glosa='$txtglosa',codrep='$hdnrepar',obs1='$txtemp',obs2='$txtfact',fte='$cboffin',ref1='$txtsolpor',ref2='$txtpedi',ref3='$txtresp',codtip='$cbotiper', usr_upd='".$_SESSION["sialmausr"]."', fec_upd='".$fecha_upd."' ";
    $sql.= "WHERE gestion='$txtgest' AND nro='$txtnro' AND dcto='$txtdcto' ;";

    $query = $db->prepare($sql);
    $query->execute();
    if($query){
        echo "Ok";
    }else{
        echo "algo salio mal";
        // var_dump($query->errorinfo(), TRUE);
    }

} catch (Exception $e) {
  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>
