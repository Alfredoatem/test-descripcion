<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";
$txtfecha=$_POST['txtfecha'];


$txtgest=$_POST['txtgest'];
$txtnro=$_POST['txtnro'];
$txtdcto=$_POST['txtdcto'];
$hdncodalm=$_POST['hdncodalm'];
$hdncodprod=$_POST['hdncodprod'];
$txtcant=$_POST['txtcant'];
$txtpu=$_POST['txtpu'];


//$txtcorr=$_POST['txtcorr'];
//
//$txtpart=$_POST['txtpart'];
//$txtspart=$_POST['txtspart'];
//$txtmonto=$_POST['txtmonto'];


try {

    $sqldel = "DELETE FROM detalma WHERE gestion='$txtgest' AND dcto='$txtdcto' AND nro='$txtnro'";
//    echo $sqldel."<br>";
    $qrydel = $db->prepare($sqldel);
    $query = $qrydel->execute();

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

//    $idprev=200000;
//    $incrementa=1;
//    $sqldet = "INSERT INTO detalma (dcto, nro, id, codalm, codprod, dcant, hcant, dcto_m, nro_m, pu, fvenc, gestion) VALUES ('$txtdcto','$txtnro',";
//    $sqldet.= "'$idprev','$hdncodalm[$incrementa]','$hdncodprod[$incrementa]','$txtcant[$incrementa]','0','$txtdcto','$txtnro','$txtpu[$incrementa]','$txtfecha','$txtgest');";
//    $query = $db->prepare($sqldet);
//    $query = $query->execute();
//    var_dump($query);
    if($query){
        echo "Ok";
    }else{
        echo "algo salio mal";
//        var_dump($query->errorinfo(), TRUE);
    }

} catch (Exception $e) {
  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>
