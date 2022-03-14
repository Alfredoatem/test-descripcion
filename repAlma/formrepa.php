<?
/************************************************/
/*DESARROLLADO POR	:	ING. JOSE LEDO REBOLLO  */
/*FECHA				:	02/05/2020 	 */
/*CELULAR			:	70614112		 */
/*LUGAR				:	MINDEFENSA - LA PAZ*/
/************************************************/
include "../pages/seguridad.php";
include "../connections/connect.php";
include "../functions/global.php";

$criterio='';
$cripart='';

if($_POST){	
  $txtfini=$_POST['txtfini'];
  $cbotipo=$_POST['cbotipo'];//nocon
	$cbofvenc=$_POST['cbofvenc']; 
  $cboalm=$_POST['cboalm'];
  $txtcodprod=$_POST['txtcodprod'];
  $cbotipper=$_POST['cbotipper'];
  /*Orden de Reporte*/
  $cborden=$_POST['cborden']; //1,2

  if($txtfini!="" ){
		//$a = ($criterio=='')?'':" AND ";
		$criterio .= " and m.fecha<= '".$txtfini."' ";
	}
  /*if($cbotipo!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a tipo = '".$cbotipo."' ";
	}*/
  $a = ($criterio=='')?'':" AND ";
  $criterio .=  " $a m.dcto[1]='".$_SESSION["sialmagalm"]."'";

  if($cboalm!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a d.codalm = '".$cboalm."' ";
	}
  if($txtcodprod!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a d.codprod = '".$txtcodprod."' ";
	}  
  if($cbotipper!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a m.codtip = '".$cbotipper."' ";
	}  
  
  	header('Location:pdfrepa.php?criterio='.base64_encode($criterio).'&orden='.$cborden.'&crifvenc='.$cbofvenc.'&frep='.$txtfini);	
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
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- MetisMenu CSS -->
<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="../resources/scripts/sb-admin-2/css/sb-admin-2.css" rel="stylesheet">
<!-- Custom Fonts -->
<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- Bootstrap Datepicker CSS-->
<link href="../vendor/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css">
<link href="../vendor/bootstrap-multiselect/bootstrap-multiselect.css" rel="stylesheet" type="text/css">  

<script src="../vendor/jquery/jquery.min.js"></script> 
<script language="JavaScript" src="../resources/scripts/form/jquery.number.js" type="text/javascript"></script>
<script language="JavaScript" src="../resources/scripts/form/jquery.alphanumeric.js" type="text/javascript"></script>
<script language="JavaScript" src="../resources/scripts/form/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script language="JavaScript" src="../resources/scripts/popup.js" type='text/javascript'></script>

<script src="../vendor/moment-with-locales.js"></script>
<!-- Bootstrap Core JavaScript --> 
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../vendor/bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"></script>
<script src="../vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<!-- Metis Menu Plugin JavaScript --> 
<script src="../vendor/metisMenu/metisMenu.min.js"></script> 
<!-- Custom Theme JavaScript --> 
<script src="../resources/scripts/sb-admin-2/js/sb-admin-2.js"></script>
  
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
  
 
});
</script>
</head>

<body>
<div id="wrapper"> 
  
  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-brand" href="views/inicio.php">Reporte de Existencias de Productos</a>
    </div>
    <!-- /.navbar-header -->
    <? include("../pages/views/inc/menuh.php") ?>
    <!-- /.navbar-top-links -->
    <? include("menuv___.php") ?>
    <!-- /.navbar-static-side --> 
  </nav>
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h3 class="page-header">Reporte de Existencias de Productos</h3>
      </div>
      <!-- /.col-lg-12 --> 
    </div>
    <!-- /.row -->
    <div class="row">
      <form role="form" class="form-horizontal" action="formrepa.php" method="post" target="_blank">
        <div class="col-lg-12">
          <div class="panel panel-primary">
            <div class="panel-heading">Criterios de Reporte</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Fecha Al:</label>
                    <div class="col-lg-5">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class='input-group date' id='txtfi'>
                            <input type='text' class="form-control" name="txtfini"/>
                            <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
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
                    <label class="col-lg-2 control-label">Ordenado Por:</label>
                    <div class="col-lg-2">
                    <select id="cborden" class="form-control"  name="cborden">
                        <option value="1" selected>Código</option>
                        <option value="2"  >Descripción</option>                        
                      </select>
                    </div>
                    <label class="col-lg-2 control-label">Tipo Inventario:</label>
                    <div class="col-lg-2">
                      <select id="cbotipo" class="form-control"  name="cbotipo">
                        <option value="1" >Compras May.</option>
                        <option value="2" selected>Almacen</option>
                        <option value="3">Todos</option>
                      </select>
                    </div>
                    <label class="col-lg-2 control-label">Fecha venc:</label>
                    <div class="col-lg-2">
                      <select id="cbofvenc" class="form-control"  name="cbofvenc">
                        <option value="1" selected>No</option>
                        <option value="2"  >Si</option>                        
                      </select>
                    </div>                    
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Codigo Almacen:</label>
                    <div class="col-lg-2">
                    <input name="cboalm" class="form-control" id="cboalm" maxlength="3">
                    </div>
                    <label class="col-lg-2 control-label">Cod Producto:</label>
                    <div class="col-lg-2">
                      <input name="txtcodprod" class="form-control" id="txtcodprod" maxlength="12">
                    </div>
                  </div>
                 
                </div>
                <!-- /.col-lg-12 (nested) -->

                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Tipo Persona:</label>
                    <div class="col-lg-2">
                    <input name="cbotipper" class="form-control" id="cbotipper" maxlength="2">
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
