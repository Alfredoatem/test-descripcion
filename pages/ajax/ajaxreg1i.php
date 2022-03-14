<?
require_once "../seguridad.php";
require_once "../../connections/connect.php";
require_once "../../functions/global.php";

$txtgest=$_POST['txtgest'];
$txtdcto=$_POST['txtdcto'];
$txtnro=$_POST['txtnro'];
$txtfecha = $_POST['txtfecha'];
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
$txtpedi=$_POST['txtpedi'];
$txtcotpor=$_POST['txtcotpor'];
$cbotiper=$_POST['cbotiper'];
//DETALLE
$txtalm=$_POST['txtalm'];
$hdncodalm=$_POST['hdncodalm'];
$txtprod=$_POST['txtprod'];
$hdncodprod=$_POST['hdncodprod'];
$txtcant=$_POST['txtcant'];
$txtpu=$_POST['txtpu'];
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
//echo $txtalm[0]."<br>";
//echo $hdncodalm[0]."<br>";
//echo $txtprod[0]."<br>";
//echo $hdncodprod[0]."<br>";
//echo $txtcant[0]."<br>";
//echo $txtpu[0]."<br>";
//hdnseltiper
//hdnselffin
try {
    $idprev=0;
    $incrementa=0;
    foreach($hdncodalm as $k => $v){
        if(!empty($v)){
            $idprev= $idprev + 100000 ;
            $sqldet = "INSERT INTO detalma (dcto, nro, id, codalm, codprod, dcant, hcant, dcto_m, nro_m, pu, fvenc, gestion) VALUES ('$txtdcto','$txtnro',";
            $sqldet.= "'$idprev','$hdncodalm[$incrementa]','$hdncodprod[$incrementa]','$txtcant[$incrementa]','0','$txtdcto','$txtnro','$txtpu[$incrementa]','$txtfecha','$txtgest');";
            //echo $sqldet."<br>";
            $query = $db->prepare($sqldet);
            $query->execute();
        }
        $incrementa++;
    }
    $sql = "INSERT INTO maealma (dcto, nro, fecha, glosa, codrep, obs1, obs2, ref1, ref2, ref3, ref4, fte, orgfin, dcto_c, nro_c, usr_add, fec_add, usr_upd, fec_upd, voboalma, codtip, gestion) VALUES ('$txtdcto','$txtnro',";
    $sql.= "'$txtfecha','$txtglosa','$hdnrepar','$txtemp','$txtfact','$txtsolpor','$txtpedi','$txtcotpor','$txthtd','$cboffin','','','',";
    $sql.= "'".$_SESSION["sialmausr"]."','".date('m/d/Y')."','".$_SESSION["sialmausr"]."','".date('m/d/Y')."','N','$cbotiper','$txtgest');";
    //echo $sql."<br>";
    $query1 = $db->prepare($sql);
    $query1->execute();
    if($query){
        echo "Ok";
    }else{
        echo "algo salio mal";
//        var_dump($query->errorinfo(), TRUE);
    }

} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
//try {
//    $sql = "UPDATE maealma SET fecha='$txtfecha',ref4='$txthtd',glosa='$txtglosa',codrep='$hdnrepar',obs1='$txtemp',obs2='$txtfact',fte='$cboffin',ref1='$txtsolpor',ref2='$txtpedi',ref3='$txtcotpor',codtip='$cbotiper', usr_upd='".$_SESSION["sialmausr"]."', fec_upd='".date('d/m/Y')."' ";
//    $sql.= "WHERE gestion='$txtgest' AND nro='$txtnro' AND dcto='$txtdcto'";
//    $query = $db->prepare($sql);
//    $query->execute();
//    if($query){
//        echo "Ok";
//    }else{
//        echo "algo salio mal";
////        var_dump($query->errorinfo(), TRUE);
//    }
//
//} catch (Exception $e) {
//  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
//}
?>
