<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";
global $db;
$txtgest=$_POST['txtgest'];
$txtnro=$_POST['txtnro'];
$txtdcto=$_POST['txtdcto'];
$txtnroc=$_POST['nro_c'];
$txtdctoc=$_POST['dcto_c'];

//echo $txtgest."<br>";
//echo $txtnro."<br>";
//echo $txtdcto."<br>";
//echo $txtnroc."<br>";
//echo $txtdctoc."<br>";


try {
    $sql = "UPDATE maealma SET dcto_c='$txtdctoc',nro_c='$txtnroc', usr_upd='".$_SESSION["sialmausr"]."', fec_upd='".date('d/m/Y')."' ";
    $sql.= "WHERE gestion='$txtgest' AND nro='$txtnro' AND dcto='$txtdcto'";
    echo $sql;
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

