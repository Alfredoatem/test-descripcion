<?php

    include "../../connections/connect.php";
    include "../../functions/global.php";
    //if (isset($_POST['update'])){
        //echo 'modificando';
        echo "<br>";
        $pagina = $_GET['pagina'];
        $dcto = $_POST['txtdcto'];//dcto
        $nro = $_POST['txtnro'];//nro
        $inter = $_POST['txtinter'];//interesado
        $obs = $_POST['txtobs'];//observaciones
        //$fechav=$_POST['txtfechav'];//fecha verificacion
        //$fechadep=$_POST['txtfechadep'];//fecha deposito
        $preventivo=$_POST['txtpreventivo'];//preventivo
        $obsa=$_POST['txtobsa'];//obsEst
        $ffin=$_POST['txtffin'];//fuente fin
        $estado=$_POST['txtestado'];//estado
        $rubro=$_POST['txtrubro'];//rubro
        $cta=$_POST['txtcta'];//cuenta contable
        $clase=$_POST['txtclase'];//actividad
        $programa=$_POST['txtprograma'];//programa
        $dctoc = $_POST['txtdctoc'];//dcto contable
        $monto = $_POST['txtmonto'];//monto en bs
        $opbanco=$_POST['txtopbanco'];//Op banco
        $codcta = $_POST['txtcodcta'];//cod cta bancaria
        $repar = $_POST['txtrepar'];//cod reparticion
        $codcon=$_POST['txtcodcon'];//cod concepto ingreso
        $fechav=$_POST['txtfechav'];//fecha verificacion
        $fechadep=$_POST['txtfechadep'];//fecha deposito
        $fecest=$_POST['txtfecest'];//fechaA
        //echo $dcto;
        //echo "<br>";
        try {
          $upd = "UPDATE ingteso SET fec_est='$fecest', fecha_dep='$fechadep', fecha_v='$fechav', inter='$inter', obs='$obs', codcon='$codcon', preventivo='$preventivo', obsa='$obsa', ffin='$ffin', estado='$estado', rubro='$rubro', cta='$cta', clase='$clase', programa='$programa', dcto_c='$dctoc', monto='$monto', opbanco='$opbanco', codcta='$codcta', repar='$repar', codcon='$codcon'";
          $upd.= "WHERE nro='$nro' AND dcto='$dcto'";
          
          $query = $db->prepare($upd);
          $query->execute();
          if($query){
            //echo "<div class='alert alert-success' role='alert'> Modificado Corectamente </div>";
            echo "<div class='alert alert-success d-flex align-items-center' role='alert'>
            <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
              <symbol id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
              <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
              </symbol>
            </svg>
                <div class='alert alert-success d-flex align-items-center' role='alert'>
                  <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'>
                    <use xlink:href='#check-circle-fill'/>
                  </svg>
                    <div>
                      Modificado Correctamente.
                    </div>
                </div>
          </div>";
          }else{
            echo "Algo salio mal";
          }
        } catch(Exception $e){
          echo 'Excepción capturada: ', $e->getMessage(), "\n";
          
        }
            
    
    
        //echo $nro;
        //echo $pagina;
    
    //}	
    
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Modificar Preventivo</title>

<!-- Bootstrap Core CSS -->
<link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- MetisMenu CSS -->
<link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="../../resources/scripts/sb-admin-2/css/sb-admin-2.css" rel="stylesheet">
<!-- Custom Fonts -->
<link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- Bootstrap Datepicker CSS-->
<link href="../../vendor/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css">

<script src="../../vendor/jquery/jquery.min.js"></script> 
<script language="JavaScript" src="../../resources/scripts/form/jquery.number.js" type="text/javascript"></script>
<script language="JavaScript" src="../../resources/scripts/form/jquery.alphanumeric.js" type="text/javascript"></script>
<script language="JavaScript" src="../../resources/scripts/form/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script language="JavaScript" src="../../resources/scripts/popup.js" type='text/javascript'></script>

<script src="../../vendor/moment-with-locales.js"></script>
<!-- Bootstrap Core JavaScript --> 
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../../vendor/bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"></script>
<!-- Metis Menu Plugin JavaScript --> 
<script src="../../vendor/metisMenu/metisMenu.min.js"></script> 
<!-- Custom Theme JavaScript --> 
<script src="../../resources/scripts/sb-admin-2/js/sb-admin-2.js"></script>

<script type="text/javascript">

$(function(){
  /*Funciones de Maestro*/

  $('#txtfechav').datetimepicker({
      useCurrent: false,
      viewMode: 'days',
      //format: 'MM/DD/YYYY'
      format: 'DD/MM/YYYY'
  });
  $('#txtfechadep').datetimepicker({
      useCurrent: false,
      viewMode: 'days',
      format: 'DD/MM/YYYY'
  });
  $('#txtfecest').datetimepicker({
      useCurrent: false,
      viewMode: 'days',
      format: 'DD/MM/YYYY'
  }); 
});
</script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="row" style="text-alig:center">
        <?php if($query){ ?>
            <h3>
                REGISTRO MODIFICADO
            </h3>
        <?} else { ?>
            <h3>
                ERROR AL MODIFICAR
            </h3>
        <? } ?>

        <!--<a href="index.php" onClick="history.go(-1);" class="btn btn-primary">Regresar</a>-->
        <button type="button" onClick="history.go(-1);" class="btn btn-lg btn-primary btn-volver">Regresar</button>
        </div>
    </div>
</div>

</body>
</html>