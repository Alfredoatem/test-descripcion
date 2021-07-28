<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";
global $db;
$txtgest=$_POST['txtgest'];
$txtnro=$_POST['txtnro'];
$txtdcto=$_POST['txtdcto'];
$cboest=$_POST['cboest'];

//echo $txtgest;
//echo $txtnro;
//echo $txtdcto;
//echo $cboest;


try {
    $sql = "UPDATE maealma SET voboalma='$cboest', usr_upd='".$_SESSION["sialmausr"]."', fec_upd='".date('m/d/Y')."' ";
    $sql.= "WHERE gestion='$txtgest' AND nro='$txtnro' AND dcto='$txtdcto'";
    $query = $db->prepare($sql);
    $query->execute();
    if($query){
        echo "Ok";
    }else{
        echo "algo salio mal";
//        var_dump($query->errorinfo(), TRUE);
    }

} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}

