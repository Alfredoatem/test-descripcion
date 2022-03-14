<?php

    include "../../connections/connect.php";
    include "../../functions/global.php";
if(isset($_POST['btnguardar']))    {
    
    $gestion=$_POST['txtgestion'];
    $dcto=$_POST['txtdcto'];
    $nro=$_POST['txtnro'];
    $fechav=$_POST['txtfechav'];
    $fechadep=$_POST['txtfechadep'];
    $opbanco=$_POST['txtopbanco'];
    $inter=$_POST['txtinter'];
    $obs=$_POST['txtobs'];
    $codcon=$_POST['txtcodcon'];
    $codcta=$_POST['txtcodcta'];
    $repar=$_POST['txtrepar'];
    $dctoc=$_POST['txtdctoc'];
    $programa=$_POST['txtprograma'];
    $monto=$_POST['txtmonto'];
    $cta=$_POST['txtcta'];
    $clase=$_POST['txtclase'];
    $rubro=$_POST['txtrubro'];
    $estado=$_POST['txtestado'];
    $ffin=$_POST['txtffin'];
    $preventivo=$_POST['txtpreventivo'];
    $fecest=$_POST['txtfecest'];
    $obsa=$_POST['txtobsa'];
    $nroc=$_POST['txtnroc'];
    $gestprev=$_POST['txtgestprev'];
    $usrins=$_POST['txtusrins'];
   // $fecins=$_POST['txtfecins'];

    $sql = "INSERT INTO ingteso(dcto, nro, fecha_v, fecha_dep, inter, obs, codcon, codcta, repar, monto, dcto_c, nro_c, estado, fec_est, obsa, programa, clase, cta, rubro, ffin, opbanco, gestprev, preventivo, usrins, fecins, gestion) VALUES('$dcto','$nro','$fechav','$fechadep' ,'$inter', '$obs', '$codcon', '$codcta', '$repar','$monto' , '$dctoc','', '$estado','$fecest' , '$obsa', '$programa', '$clase', '$cta', '$rubro', '$ffin','$opbanco' , '', '$preventivo', '', '".date( 'Y-m-d H:i:s')."','$gestion')";
    $query = $db->prepare($sql);
    $query->execute();
    if(!$query){
        die("Query Failed");
    }
    $_SESSION['message']='Registrado Correctamente';
    $_SESSION['message_type']='success';

    header("Location: listaingreso2.php");
}
    
?>