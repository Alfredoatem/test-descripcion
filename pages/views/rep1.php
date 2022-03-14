<?
/************************************************/
/*DESARROLLADO POR	:	ING. JOSE LEDO REBOLLO  */
/*FECHA				:	02/05/2020 	 */
/*CELULAR			:	70614112		 */
/*LUGAR				:	MINDEFENSA - LA PAZ*/
/************************************************/
//include "../pages/seguridad.php";
include "../../connections/connect.php";
include "../../functions/global.php";

$criterio='';
if($_POST){	
    $txtfini=$_POST['txtfini'];
    $txtfini2=$_POST['txtfini2'];
    $dcto=$_POST['dcto'];//nocon
    $fechadep=$_POST['fechadep']; 
    $codcon=$_POST['codcon'];
    $codcta=$_POST['codcta'];
    $repar=$_POST['repar'];
    /*Orden de Reporte*/
    //$cborden=$_POST['cborden']; //1,2  

    if($txtfini!="" ){
      //$a = ($criterio=='')?'':" AND ";
      $criterio .= " and i.fecha_v<= '".$txtfini."' ";
    }

    if($txtfini2!="" ){
      //$a = ($criterio=='')?'':" AND ";
      $criterio .= " and i.fecha_dep<= '".$txtfini2."' ";
    }

    if($dcto!=""){
      $a = ($criterio=='')?'':" AND ";
      $criterio .= " $a i.dcto = '".$dcto."' ";
    }
  
    if($codcon!=""){
      $a = ($criterio=='')?'':" AND ";
      $criterio .= " $a i.codcon = '".$codcon."' ";
    }  

    if($codcta!=""){
      $a = ($criterio=='')?'':" AND ";
      $criterio .= " $a i.codcta = '".$codcta."' ";
    } 
    if($repar!=""){
      $a = ($criterio=='')?'':" AND ";
      $criterio .= " $a i.repar = '".$repar."' ";
    } 

  	header('Location:rep1a.php?criterio='.base64_encode($criterio).'&codcon='.$codcon.'&frep='.$txtfini);	
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Registrar Preventivo</title>

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
<link href="../../vendor/bootstrap-multiselect/bootstrap-multiselect.css" rel="stylesheet" type="text/css">  

<script src="../../vendor/jquery/jquery.min.js"></script> 
<script language="JavaScript" src="../../resources/scripts/form/jquery.number.js" type="text/javascript"></script>
<script language="JavaScript" src="../../resources/scripts/form/jquery.alphanumeric.js" type="text/javascript"></script>
<script language="JavaScript" src="../../resources/scripts/form/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script language="JavaScript" src="../../resources/scripts/popup.js" type='text/javascript'></script>

<script src="../../vendor/moment-with-locales.js"></script>
<!-- Bootstrap Core JavaScript --> 
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../../vendor/bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"></script>
<script src="../../vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<!-- Metis Menu Plugin JavaScript --> 
<script src="../../vendor/metisMenu/metisMenu.min.js"></script> 
<!-- Custom Theme JavaScript --> 
<script src="../../resources/scripts/sb-admin-2/js/sb-admin-2.js"></script>
  
<script type="text/javascript">

$(function(){
  /*Funciones de Maestro*/

  $('#txtfi').datetimepicker({
    locale: 'es',
    format: 'L',
    minDate: moment("01/01/2021"),
    maxDate: moment(),
    useCurrent: false,
    defaultDate: moment("01/01/2021")
  });
  $('#txtfi2').datetimepicker({
    locale: 'es',
    format: 'L',
    minDate: moment("01/01/2021"),
    maxDate: moment(),
    useCurrent: false,
    defaultDate: moment("01/01/2021")
  });
  
 
});
</script>
</head>

<body>
<div id="wrapper"> 
  
  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Reporte por mes a fecha de Verificacion</a>
    </div>
    <? include("inc/menuh.php") ?>
        
    <? include("inc/menuv.php") ?>
  </nav>
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h3 class="page-header">Ingresos por Meses a Fecha de Verificaci&oacute;n</h3>
      </div>
      <!-- /.col-lg-12 --> 
    </div>
    <!-- /.row -->
    <div class="row">
      <form role="form" class="form-horizontal" action="rep1.php" method="post" target="_blank">
        <div class="col-lg-12">
          <div class="panel panel-primary">
            <div class="panel-heading">Criterios de Reporte</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Fecha de Verificaci&oacute;n: </label>
                    <div class="col-lg-5">
                      <div class="row">
                        <div class="col-lg-6">
                            <div class='input-group date' id='txtfi'>
                                <input type='text' class="form-control" name="txtfini"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar">
                                        </span>
                                    </span>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                    <div class="form-group">

                        <label class="col-lg-2 control-label">DCTO.: </label>
                        <div class="col-lg-2">
                            <input name="dcto" class="form-control llaves" id="dcto" maxlength="1" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="">
                        </div>

                        <label class="col-lg-2 control-label">Fecha de Deposito: </label>
                        <div class="col-lg-5">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class='input-group date' id='txtfi2'>
                                    <input type='text' class="form-control" name="txtfini"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                                        </span>
                                </div>
                            </div>
                        </div>
                        </div>                   
                    </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Codigo de Concepto:</label>
                    <div class="col-lg-2">
                        <input name="codcon" class="form-control" id="codcon" value="" maxlength="5" style="text-transform:uppercase;">
                    </div>
                    <label class="col-lg-2 control-label">Codigo de Cuenta:</label>
                    <div class="col-lg-2">
                        <input name="codcta" class="form-control" id="codcta" value="" maxlength="6" style="text-transform:uppercase;">
                    </div>
                  </div>
                 
                </div>
                <!-- /.col-lg-12 (nested) -->

                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Codigo de Repatici&oacute;n:</label>
                    <div class="col-lg-2">
                        <input name="repar" class="form-control" id="repar" value="" maxlength="6" style="text-transform:uppercase;">
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-5">
                      <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) --> 
              </div>
              <!-- /.row (nested) --> 
            </div>
            <!-- /.panel-body --> 
          </div>
        </div>
        <!-- /.col-lg-12 -->
      </form>
    </div>
    <!-- /.row --> 
  </div>
  <!-- /#page-wrapper --> 
  
</div>
<!-- /#wrapper --> 
</body>
</html>
