<?
/************************************************/
/*DESARROLLADO POR	:	ING. JOSE LEDO REBOLLO  */
/*FECHA				:	02/05/2020 	 */
/*CELULAR			:	70614112		 */
/*LUGAR				:	MINDEFENSA - LA PAZ*/
/************************************************/
include "seguridad.php";
include "../connections/connect.php";
include "../functions/global.php";

$criterio='';
$cripart='';

if($_POST){	
  $txtfini=$_POST['txtfini'];
  $txtffin=$_POST['txtffin'];
  
	$txtprev=$_POST['txtprev'];
	$cbotipo=$_POST['cbotipo'];
	
  $cboestado=$_POST['cboestado'];
  $txtrevisor=$_POST['txtrevisor'];

  $hdnscta=$_POST['hdnscta'];
  
  $txtpart=$_POST['txtpart'];
	$txtspart=$_POST['txtspart'];
  
  $estadoin = "";
  if(count($cboestado)>0){
    foreach($cboestado as $v){
      $estadoin .= "'$v',";
    }
    $estadoin = substr($estadoin, 0, -1);
  }
  /*Orden de Reporte*/
  $cborden=$_POST['cborden'];
  
  /*Criterios en General*/
  if($txtfini!="" && $txtffin!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a fecha between '".$txtfini."' and '".$txtffin."' ";
	}
  if($txtprev!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a nro = '".$txtprev."' ";
	}
  if($cbotipo!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a tipo = '".$cbotipo."' ";
	}
  if($estadoin!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a estado in (".$estadoin.") ";
	}
  if($txtrevisor!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a revisor matches '".$txtrevisor."*' ";
	}
	if($hdnscta!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a scta = '".$hdnscta."' ";
	}
  /*Criterios en Partidas*/
  if($txtpart!=""){
		$a = ($cripart=='')?'':" AND ";
		$cripart .= " $a part = '".$txtpart."' ";
	}
  if($txtspart!=""){
		$a = ($cripart=='')?'':" AND ";
		$cripart .= " $a spart = '".$txtspart."' ";
	}

	header('Location:pdfrep4.php?criterio='.base64_encode($criterio).'&cripart='.base64_encode($cripart).'&orden='.$cborden);	
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
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- jQuery  -->

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
    minDate: moment("01/01/2015"),
    maxDate: moment(),
    useCurrent: false,
    defaultDate: moment("01/01/2015")
  });
  
  $('#txtff').datetimepicker({
    locale: 'es',
    format: 'L',
    useCurrent: false,
    defaultDate: moment()
  });
  
  $("#txtfi").on("dp.change", function (e) {
    $('#txtff').data("DateTimePicker").minDate(e.date);
  });
  $("#txtff").on("dp.change", function (e) {
    $('#txtfi').data("DateTimePicker").maxDate(e.date);
  });

  $(".enlacescta").attr("onclick","popup('zoomsctas.php','700','350')")
  $("#txtprev").numeric();
  
  $('#cboestado').multiselect({
    selectAllText: ' Seleccionar Todo',
    nonSelectedText: 'Sin Seleccionar',
    nSelectedText: 'Seleccionado',
    allSelectedText: 'Todo Seleccionado',
    buttonWidth: '200px',
    /*includeSelectAllOption: true*/
  });
  
  $(document).on('focusin','#hdnscta',function(){
    $.ajax({
      type : 'POST',
      url : "ajaxscta.php",
      data : "valor="+$(this).val(),
      success : function(data){
        var json = eval("(" + data + ")");
        $("#txtper").attr('value',json.value);
      }
    });
  });
  
  $("#txtrevisor").alpha({nchars:"abcdefghijklmnñopqrstuvwxyz1234567890"});
  $("#txtpart").number(true,0);
  $("#txtspart").numeric();
  
});
</script>
</head>

<body>
<div id="wrapper"> 
  
  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-brand" href="views/inicio.php">Cargos de Cuenta Sigep</a>
    </div>
    <!-- /.navbar-header -->
    <? include("views/inc/menuh.php") ?>
    <!-- /.navbar-top-links -->
    <? include("views/inc/menuv.php") ?>
    <!-- /.navbar-static-side --> 
  </nav>
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h3 class="page-header">Cargo y Descargo SIGEP - Incuye Notificación</h3>
      </div>
      <!-- /.col-lg-12 --> 
    </div>
    <!-- /.row -->
    <div class="row">
      <form role="form" class="form-horizontal" action="formcrirep4.php" method="post" target="_blank">
        <div class="col-lg-8">
          <div class="panel panel-primary">
            <div class="panel-heading">Criterio de Reporte</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Fecha</label>
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
                        <div class="col-lg-6">
                          <div class='input-group date' id='txtff'>
                            <input type='text' class="form-control" name="txtffin"/>
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
                    <label class="col-lg-1 control-label">Preventivo</label>
                    <div class="col-lg-5">
                      <input name="txtprev" class="form-control" id="txtprev">
                    </div>
                    <label class="col-lg-1 control-label">Tipo</label>
                    <div class="col-lg-5">
                      <select id="cbotipo" class="form-control"  name="cbotipo">
                        <option value="N" selected>Normal</option>
                        <option value="F">Fondo Rotativo</option>
                      </select>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Estado</label>
                    <div class="col-lg-5">
                      <select id="cboestado" multiple="multiple" name="cboestado[]">
                        <option value="A">Aprobado</option>
                        <option value="O">Observado</option>
                        <option value="R">Revisión</option>
                        <option value="D">Descuento</option>
                        <option value="J">Regularización</option>
                        <option value="T">Traspaso</option>
                        <option value="S">Sin Descargo</option>
                      </select>
                    </div>
                    <label class="col-lg-1 control-label">Revisor</label>
                    <div class="col-lg-5">
                      <input name="txtrevisor" class="form-control" id="txtrevisor" maxlength="2">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Scta.</label>
                    <div class="col-lg-11">
                      <div class="input-group">
                        <input name="txtper" class="form-control" id="txtper" disabled>
                        <span class="input-group-btn">
                          <button class="btn btn-default enlacescta" type="button"><i class="fa fa-search"></i>
                          </button>
                        </span>
                      </div>
                      <input type="hidden" name="hdnscta" id="hdnscta">
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Part.</label>
                    <div class="col-lg-5">
                      <input name="txtpart" class="form-control" id="txtpart" maxlength="3">
                    </div>
                    <label class="col-lg-1 control-label">SubPart.</label>
                    <div class="col-lg-5">
                      <input name="txtspart" class="form-control" id="txtspart" maxlength="2">
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Orden</label>
                    <div class="col-lg-5">
                      <select id="cborden" class="form-control"  name="cborden">
                        <option value="A" selected>Alfabetico</option>
                        <option value="P">Preventivo</option>
                      </select>
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
