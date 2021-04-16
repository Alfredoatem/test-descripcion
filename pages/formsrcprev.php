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

if($_POST){	
	$txtgest=$_POST['txtgest'];
	$txtprev=$_POST['txtprev'];
	$txtipo=$_POST['txtipo'];
	$txtcorr=$_POST['txtcorr'];
	$txtfini=$_POST['txtfini'];
  $txtffin=$_POST['txtffin'];
	$txthtd=$_POST['txthtd'];
	$txtglosa=$_POST['txtglosa'];
	$hdnscta=$_POST['hdnscta'];
	$txtfte=$_POST['txtfte'];
	$txtorg=$_POST['txtorg'];
	$txtprog=$_POST['txtprog'];
	$txtproy=$_POST['txtproy'];
	$txtact=$_POST['txtact'];
  
	if($txtgest!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a gestion = '".$txtgest."' ";
	}
	if($txtprev!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a nro = '".$txtprev."' ";
	}
	if($txtipo!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a tipo matches '".$txtipo."' ";
	}
	if($txtcorr!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a idprev = '".$txtcorr."' ";
	}
  if($txtfini!="" && $txtffin!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a fecha between '".$txtfini."' and '".$txtffin."' ";
	}
	if($txthtd!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a htd = '".$txthtd."' ";
	}
	if($txtglosa!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a glosa matches '*".$txtglosa."*' ";
	}
	if($hdnscta!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a scta = '".$hdnscta."' ";
	}
	if($txtfte!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a fte matches '".$txtfte."*' ";
	}
  if($txtorg!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a orgfin matches '".$txtorg."*' ";
	}
  if($txtprog!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a prog matches '".$txtprog."*' ";
	}
  if($txtproy!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a proy matches '".$txtproy."*' ";
	}
  if($txtact!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a act matches '".$txtact."*' ";
	}
	
	header('Location:formresprev.php?criterio='.base64_encode($criterio));	
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="iso-8859-1">
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
    useCurrent: false
  });
  
  $('#txtff').datetimepicker({
    locale: 'es',
    format: 'L',
    useCurrent: false
  });
  
  $("#txtfi").on("dp.change", function (e) {
    $('#txtff').data("DateTimePicker").minDate(e.date);
  });
  $("#txtff").on("dp.change", function (e) {
    $('#txtfi').data("DateTimePicker").maxDate(e.date);
  });

  $(".enlacescta").attr("onclick","popup('zoomsctas.php','700','360')")
  $("#txtgest,#txtprev,#txtcorr").numeric();
  $("#txtipo").alpha({nchars:"ABCDEGHIJKLMÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz1234567890"});
  $("#txthtd").inputmask("aaa99999");
  
  $(document).on('keyup','#txthtd, #txtglosa',function(){
		this.value = this.value.toUpperCase();
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
  $("#txtfte,#txtorg").numeric();
  $("#txtprog,#txtproy,#txtact").numeric();
  
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
        <h2 class="page-header">Busqueda de Preventivo</h2>
      </div>
      <!-- /.col-lg-12 --> 
    </div>
    <!-- /.row -->
    <div class="row">
      <form role="form" class="form-horizontal" action="formsrcprev.php" method="post">
        <div class="col-lg-12">
          <div class="panel panel-primary">
            <div class="panel-heading">Parámetros</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Gesti&oacute;n</label>
                    <div class="col-lg-3">
                      <input name="txtgest" class="form-control" id="txtgest" maxlength="4">
                    </div>
                    <label class="col-lg-1 control-label">Preventivo</label>
                    <div class="col-lg-3">
                      <input name="txtprev" class="form-control" id="txtprev">
                    </div>
                    <label class="col-lg-1 control-label">Tipo</label>
                    <div class="col-lg-3">
                      <input name="txtipo" class="form-control" id="txtipo" maxlength="1">
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Correlativo</label>
                    <div class="col-lg-3">
                      <input name="txtcorr" class="form-control" id="txtcorr">
                    </div>
                    <label class="col-lg-1 control-label">Fecha</label>
                    <div class="col-lg-3">
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
                    <label class="col-lg-1 control-label">HTD</label>
                    <div class="col-lg-3">
                      <input name="txthtd" class="form-control" id="txthtd" maxlength="8">
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Glosa</label>
                    <div class="col-lg-11">
                      <input name="txtglosa" class="form-control" maxlength="100" id="txtglosa">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Cuentadante</label>
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
                    <label class="col-lg-1 control-label">Fuente</label>
                    <div class="col-lg-3">
                      <input name="txtfte" class="form-control" id="txtfte" maxlength="2">
                    </div>
                    <label class="col-lg-1 control-label">Organismo</label>
                    <div class="col-lg-3">
                      <input name="txtorg" class="form-control" id="txtorg" maxlength="3">
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Programa</label>
                    <div class="col-lg-3">
                      <input name="txtprog" class="form-control" id="txtprog" maxlength="2">
                    </div>
                    <label class="col-lg-1 control-label">Proyecto</label>
                    <div class="col-lg-3">
                      <input name="txtproy" class="form-control" id="txtproy" maxlength="4">
                    </div>
                    <label class="col-lg-1 control-label">Actividad</label>
                    <div class="col-lg-3">
                      <input name="txtact" class="form-control" id="txtact" maxlength="3">
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-3">
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
