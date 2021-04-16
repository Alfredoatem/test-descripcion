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

if($_GET['criterio']){
	//$criterio .= str_replace("WHERE","",base64_decode($_GET['criterio'])); //cuando no tiene condicion WHERE
  $criterio .= base64_decode($_GET['criterio']); //Cuando tiene condicion WHERE
}

//$criterio=(trim($criterio)=='')?"":"WHERE".$criterio; //cuando no tiene condicion WHERE
$aux=(trim($criterio)=='')?"":"AND".$criterio; //Cuando tiene condicion WHERE

$registros = 1;
$pagina = $_GET["pagina"];

if (!$pagina) { 
	$inicio = 0; 
	$pagina = 1; 
} 
else { 
	$inicio = ($pagina - 1) * $registros; 
}
	
$sql="SELECT count(*) as num FROM maesigep WHERE estprev='C' ".$aux;
$cont = $db->prepare($sql);
$cont->execute();
$r = $cont->fetch(PDO::FETCH_ASSOC);	
$total=$r['num'];

if ($total==0){
  ?>
  <script type="text/javascript">
  alert('No Existen Datos.\nIntroduzca otro parametro de Busqueda')
  document.location='formsrcprev.php'
  </script>
  <? 
  exit;
}

$sql="SELECT skip $inicio first $registros * FROM maesigep WHERE estprev='C' ".$aux." ";
$sql.="ORDER BY 1,2,3 ";
$query = $db->prepare($sql);
$query->execute();
$tpaginas = ceil($total/$registros);
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
<script src="../vendor/moment-with-locales.js"></script>
<!-- Bootstrap Core JavaScript --> 
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../vendor/bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"></script>
<!-- Metis Menu Plugin JavaScript --> 
<script src="../vendor/metisMenu/metisMenu.min.js"></script> 
<!-- Custom Theme JavaScript --> 
<script src="../resources/scripts/sb-admin-2/js/sb-admin-2.js"></script>
<script language="JavaScript" src="../resources/scripts/form/jquery.number.js" type="text/javascript"></script>
<script language="JavaScript" src="../resources/scripts/form/jquery.alphanumeric.js" type="text/javascript"></script>
<script language="JavaScript" src="../resources/scripts/form/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script language="JavaScript" src="../resources/scripts/popup.js" type='text/javascript'></script>  

  
<style>
  .pagination{
	  margin:0px 0;
  }
</style>
<script type="text/javascript">

$(function(){
  /*Funciones Iniciales*/
  $('form.maestro').find('input[type=text]').each(function(){
    $(this).attr('readonly','readonly')
  });
  
  $('div.guardar').hide();
    
  $('.pagination .disabled a, .pagination .active a').on('click', function(e) {
    e.preventDefault();
  });
  
  /*Funciones de Edicion*/
  $(".btn_edit").click(function(){
    var anio = (new Date).getFullYear();
    if($("#txtgest").val()<anio){
      $("#txthtd").removeAttr('readonly')
    }else{
      $('form.maestro').find('input[type=text]').each(function(){
        $(this).removeAttr('readonly')
      });
    }

    $(".llaves,#txtper").attr('readonly','readonly');     
    $('div.guardar').show();
    
    $('#txtfec').datetimepicker({
      locale: 'es',
      format: 'L',
      minDate: moment("01/01/2015"),
      maxDate: moment(),
      useCurrent: false
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
  
  $("form.maestro").submit(function(e){
    e.preventDefault();
    var form_data = $('form.maestro').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxupdprev.php",
      data : form_data,
      success : function(html){
        if(html=="Ok"){
          $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Actualizo Correctamente!!</div>');
        }else{
          if(html=="Sin HTD"){
            $('#message').html('<div class="alert alert-warning fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button><strong>Solo se modificó el HTD.</strong> Tiene Descargo de Cuenta!!!</div>');
          }else{
            $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>'); 
          }
        }
      }
    });
  });
  
  $(".btn_cancelar").click(function(){
    location.reload();
  })
  
  /*Funciones de Detalle*/
  $("#alertpart,#alertspart").hide();
  $(".txtmonto,#monto").css('text-align','right').number(true,2,'.','');
  $(".txtpart").number(true,0);
  $(".txtspart").numeric();
    
	$(document).on('click','.add',function(){
		$("tr.copy:last").clone().insertAfter('tr.copy:last');
		$("tr.copy:last input").val("");
		$(this).find("span").remove();
		$(this).append('<span class="fa fa-minus fa-2x"></span>');
		$(this).attr('class','del');

		$(".txtmonto").css('text-align','right').number(true,2,'.','');
    $(".txtmonto").trigger("keyup");
	});
  
  $(document).on('click','.del',function(){
		$(this).parent().parent().remove();
    $(".txtmonto").trigger("keyup");
	});
	
	$(document).on('change','.txtpart',function(){
    var index = $('.txtpart').index(this)
		$.ajax({
      type : 'POST',
      url : "ajaxpart.php",
      data : "valor="+$(this).val(),
      success : function(data){
        var json = eval("(" + data + ")");
        if(json.value==''){
          $("#alertpart").fadeIn("slow");
          $(".txtpart:eq("+index+")").val("").focus(); 
          $(".txtdpart:eq("+index+")").val(""); 
        }else{
          $(".txtdpart:eq("+index+")").val(json.value); 
          $("#alertpart").delay(500).fadeOut("slow");
        }
      }
    });
	});
  
  $(document).on('change','.txtspart',function(){
    var index = $('.txtspart').index(this)
		$.ajax({
      type : 'POST',
      url : "ajaxspart.php",
      data : "valor="+$(this).val()+"&part="+$(".txtpart:eq("+index+")").val(),
      success : function(data){
        var json = eval("(" + data + ")");
        if(json.value==''){
          $("#alertspart").fadeIn("slow");
          $(".txtspart:eq("+index+")").val("").focus(); 
          $(".txtdspart:eq("+index+")").val(""); 
        }else{
          $(".txtdspart:eq("+index+")").val(json.value);
          $("#alertspart").delay(500).fadeOut("slow");
        }
      }
    });
	});
  
  $(document).on('keyup','.txtmonto',function(){
		var importe = 0;
    $('.txtmonto').each(function(index, element){
      var c = eval($(this).val());
      if(c==null || c=='') c=0;
      importe = importe + c;
    });
    $('#monto').val(importe.toFixed(2));
	});
  
  $(".txtmonto").trigger("keyup");
  
  $(".btn_guardadet").click(function(e){
    e.preventDefault();
    var form_data = $('form.detalle').serialize();
    var llaves = $("form.maestro").find('.llaves').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxupdet.php",
      data : form_data+"&"+llaves,
      success : function(html){
        if(html=="Ok"){
          $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Actualizo Correctamente!!</div>');
        }else{
          $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>');
        }
      }
    });
  });
  
  /*Funciones de Eliminacion*/
  $('.btn_delete').on('click', function(e) {
    e.preventDefault();
    var llaves = $("form.maestro").find('.llaves').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxdelprev.php",
      data : llaves,
      success : function(html){
        if(html=="Ok"){
          $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Eliminó Correctamente!!</div>');
        }else{
          $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>');
        }
      }
    });
  });
  
  /*Funcion Descargo*/
  var llavedesc = $("form.maestro").find('.llaves').serialize();
  $.ajax({
    type : 'POST',
    url : "ajaxestdesc.php",
    data : llavedesc,
    success : function(data){
      var json = eval("(" + data + ")");
      $('#txtrevisor').attr('value',json.revisor);
      $('#txtrevisor').attr('readonly','readonly');
      if(json.value==""){
        $('#txtestado').attr('value','R');
        $('#txtfdesc,#txtestado,#txtfsal').attr('readonly','readonly');
        $('#txtanexo').removeAttr('readonly');
      }else{
        if(json.value=="D" || json.value=="J" || json.value=="O" || json.value=="R"){
          $('#txtfdesc').attr('readonly','readonly');
          $('#txtanexo,#txtfsal').removeAttr('readonly');
        }else{
          $('input[type=text]').attr('readonly','readonly');
          $('.btn_guardadesc').attr('class','btn btn-success btn_guardadesc disabled')
          $('.btn_guardadesc').on('click', function(e) {
            e.preventDefault();
          });
        }
      }
    }
  });
  
  $('#txtfecde').datetimepicker({
    locale: 'es',
    format: 'L',
    minDate: moment("01/01/2015"),
    maxDate: moment(),
    defaultDate: moment()
  });
  
  $('#txtfecds').datetimepicker({
    locale: 'es',
    format: 'DD/MM/YYYY',
    minDate: moment("01/01/2015"),
    maxDate: moment(),
    defaultDate: moment()
  });
  
  $("#txthtddesc").inputmask("aaa99999");
  $("#txtestado").alpha({nchars:"BCEFGHIJKLMNÑPQSTUVWYZabcdefghijklmnñopqrstuvwxyz1234567890"});
  $(document).on('keyup','#txthtddesc, #txtanexo',function(){
    this.value = this.value.toUpperCase();
  });
  
  $("form.descargo").submit(function(e){
    e.preventDefault();
    var form_data = $(this).serialize();
    var llaves = $("form.maestro").find('.llaves').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxdescprev.php",
      data : form_data+"&"+llaves,
      success : function(html){
        if(html=="Actualizado"){
          $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Actualizó el Descargo Correctamente!!</div>');
        }else{
          if(html=="Registrado"){
            $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Registró el Descargo Correctamente!!</div>');
          }else{
            $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>'); 
          }
        }
        $(".modaldescargo").modal('toggle');
      }
    });
  });
  
  /*Funcion Pasajes*/
  $('#txtfecini').datetimepicker({
    locale: 'es',
    format: 'L',
    minDate: moment("01/01/2015"),
    maxDate: moment(),
    useCurrent: false
  });
  
  $('#txtfecfin').datetimepicker({
    locale: 'es',
    format: 'L',
    useCurrent: false
  });
  
  $("#txtfecini").on("dp.change", function (e) {
    $('#txtfecfin').data("DateTimePicker").minDate(e.date);
  });
  $("#txtfecfin").on("dp.change", function (e) {
    $('#txtfecini').data("DateTimePicker").maxDate(e.date);
  });
  
  $(document).on('keyup','#txtobs',function(){
    this.value = this.value.toUpperCase();
  });
  
  $("form.pasajes").submit(function(e){
    e.preventDefault();
    var form_data = $(this).serialize();
    var llaves = $("form.maestro").find('.llaves').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxpyvprev.php",
      data : form_data+"&"+llaves,
      success : function(html){
        if(html=="Actualizado"){
          $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Actualizó las fechas de pasajes Correctamente!!</div>');
        }else{
          if(html=="Registrado"){
            $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Registró las fechas de pasajes Correctamente!!</div>');
          }else{
            $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>');
          }
        }
        $(".modalpasajes").modal('toggle');
      }
    });
  });
  
  /*Funciones de Generacion de Comprobante*/
  $('.btn_gencpbte').on('click', function(e) {
    e.preventDefault();
    var llaves = $("form.maestro").find('.llaves').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxgencpbte.php",
      data : llaves,
      success : function(html){
        if($.isNumeric(html)){
          $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Generó el Comprobante Contable <strong>CC - '+html+'</strong></div>');
        }else{
          $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>');
        }
      }
    });
  });
  
  $('#message').on('close.bs.alert', function(){
    location.reload();
  });
  
  $(".btn_canceldet, .btn_canceldesc, .btn_cancelpyv").click(function(){
    location.reload();
  })
  
});
</script>
</head>

<body>
<div id="wrapper"> 
  <!-- Navigation -->
  <? include("views/inc/navprincipal.php") ?>
  <div id="page-wrapper">
    <? while($row = $query->fetch(PDO::FETCH_ASSOC)) { 
    $g = $row['gestion'];
    $n = $row['nro'];
    $i = $row['idprev'];
    $t = $row['tipo'];
    ?>
    <div class="row">
      <div class="col-lg-12">
        <h2 class="page-header">Preventivos
        <div class='pull-right'>
          <div class='btn-group' role="group">
            <a href="#" class="btn btn-default btn_edit <?=verpermiso($_SESSION['sialmausr'],'Editar',$g,$n,$i,$t)?>"><span class="fa fa-edit"></span>&nbsp;Editar</a>
            <a href="#" class="btn btn-default <?=verpermiso($_SESSION['sialmausr'],'Detalle',$g,$n,$i,$t)?>" data-toggle="modal" data-target=".modaldetalle"><span class="fa fa-list"></span>&nbsp;Detalle</a>
            <a href="#" class="btn btn-default <?=verpermiso($_SESSION['sialmausr'],'Eliminar',$g,$n,$i,$t)?>" data-toggle="modal" data-target=".modaldelete"><span class="fa fa-eraser"></span>&nbsp;Eliminar</a>
            <a href="#" class="btn btn-default <?=verpermiso($_SESSION['sialmausr'],'Descargo',$g,$n,$i,$t)?>" data-toggle="modal" data-target=".modaldescargo"><span class="fa fa-folder"></span>&nbsp;Descargo</a>
            <a href="#" class="btn btn-default <?=verpermiso($_SESSION['sialmausr'],'Comision',$g,$n,$i,$t)?>" data-toggle="modal" data-target=".modalpasajes"><span class="fa fa-calendar"></span>&nbsp;Comision</a>
            <a href="pdfsialma.php?g=<?=$row['gestion']?>&n=<?=$row['nro']?>&i=<?=$row['idprev']?>&t=<?=$row['tipo']?>" class="btn btn-default" target="_blank"><span class="fa fa-print"></span>&nbsp;Imprimir</a>
          </div>
        </div>
        </h2>
      </div>     
      <!-- /.col-lg-12 --> 
    </div>
    <!-- /.row -->
    <!-- INLINE MAESTRO -->
    <div class="row">
      <form role="form" class="form-horizontal maestro">
        <div class="col-lg-12">
          <div id="message"></div>
          <div class="panel panel-primary">
            <div class="panel-heading">Maestro</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Gesti&oacute;n</label>
                    <div class="col-lg-3">
                      <input name="txtgest" type="text" class="form-control llaves" id="txtgest" maxlength="4" value="<?=$row['gestion']?>">
                    </div>
                    <label class="col-lg-1 control-label">Preventivo</label>
                    <div class="col-lg-3">
                      <input name="txtprev" type="text" class="form-control llaves" id="txtprev" value="<?=$row['nro']?>">
                    </div>
                    <label class="col-lg-1 control-label">Tipo</label>
                    <div class="col-lg-3">
                      <input name="txtipo" type="text" class="form-control llaves" id="txtipo" maxlength="1" value="<?=$row['tipo']?>">
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Correlativo</label>
                    <div class="col-lg-3">
                      <input name="txtcorr" type="text" class="form-control llaves" id="txtcorr" value="<?=$row['idprev']?>">
                    </div>
                    <label class="col-lg-1 control-label">Fecha</label>
                    <div class="col-lg-3">
                      <div class='input-group date' id='txtfec'>
                        <input type='text' class="form-control" name="txtfecha" value="<?=newdate($row['fecha'])?>" required/>
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <label class="col-lg-1 control-label">HTD</label>
                    <div class="col-lg-3">
                      <input name="txthtd" type="text" class="form-control" id="txthtd" maxlength="8" value="<?=$row['htd']?>" required>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Glosa</label>
                    <div class="col-lg-11">
                      <input name="txtglosa" type="text" class="form-control" maxlength="100" id="txtglosa" value="<?=trim($row['glosa'])?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Cuentadante</label>
                    <div class="col-lg-11">
                      <div class="input-group">
                        <input name="txtper" type="text" class="form-control" id="txtper" value="<?=bscta($row['scta'])?>">
                        <span class="input-group-btn">
                          <button class="btn btn-default enlacescta" type="button"><i class="fa fa-search"></i>
                          </button>
                        </span>
                      </div>
                      <input type="hidden" name="hdnscta" id="hdnscta" value="<?=$row['scta']?>">
                    </div>
                  </div>  
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Fuente</label>
                    <div class="col-lg-3">
                      <input name="txtfte" type="text" class="form-control" id="txtfte" maxlength="2" value="<?=trim($row['fte'])?>" required>
                    </div>
                    <label class="col-lg-1 control-label">Organismo</label>
                    <div class="col-lg-3">
                      <input name="txtorg" type="text" class="form-control" id="txtorg" maxlength="3" value="<?=trim($row['orgfin'])?>" required>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Programa</label>
                    <div class="col-lg-3">
                      <input name="txtprog" type="text" class="form-control" id="txtprog" maxlength="2" value="<?=trim($row['prog'])?>" required>
                    </div>
                    <label class="col-lg-1 control-label">Proyecto</label>
                    <div class="col-lg-3">
                      <input name="txtproy" type="text" class="form-control" id="txtproy" maxlength="4" value="<?=trim($row['proy'])?>" required>
                    </div>
                    <label class="col-lg-1 control-label">Actividad</label>
                    <div class="col-lg-3">
                      <input name="txtact" type="text" class="form-control" id="txtact" maxlength="3" value="<?=trim($row['act'])?>" required>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12 guardar">
                  <div class="form-group">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-3">
                      <button type="sumbit" class="btn btn-success btn_guardar">Guardar Cambios</button>
                      <button type="button" class="btn btn-danger btn_cancelar">Cancelar</button>
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
    <?                                                
    $sqldet="SELECT * FROM detsigep WHERE gestion='".$row['gestion']."' AND nro='".$row['nro']."' AND idprev='".$row['idprev']."' AND tipo='".$row['tipo']."' ";
    $sqldet.="ORDER BY apu";
    $qrydet = $db->prepare($sqldet);
    $qrydet->execute();
    ?>
    <!-- MODAL DETALLE -->
    <div class="modal fade modaldetalle" tabindex="-1" role="dialog" aria-labelledby="ModalDetalle" aria-hidden="true">
      <form role="form" class="form-horizontal detalle">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h3>Detalle</h3>
            </div>
            <div class="modal-body">
              <div id="alertpart" class="alert alert-danger" role="alert">
                <strong>Error!</strong>
                  Debe introducir una partida Existente
              </div>
              <div id="alertspart" class="alert alert-danger" role="alert">
                <strong>Error!</strong>
                  Debe introducir una subpartida Existente
              </div>
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col" colspan="2">Partida</th>
                    <th scope="col" colspan="2">Subpartida</th>
                    <th scope="col">Monto</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <? while($rowdet = $qrydet->fetch(PDO::FETCH_ASSOC)) { ?>
                  <tr class="copy">
                    <td class="col-lg-1"><input name="txtpart[]" maxlength="3" class="form-control input-sm txtpart" value="<?=$rowdet['part']?>"/></td>
                    <td class="col-lg-4"><input class="form-control input-sm txtdpart" disabled value="<?=bpart($rowdet['part'])?>"/></td>
                    <td class="col-lg-1"><input name="txtspart[]" maxlength="2" class="form-control input-sm txtspart" value="<?=$rowdet['spart']?>"/></td>
                    <td class="col-lg-4"><input class="form-control input-sm txtdspart" disabled value="<?=bspart($rowdet['part'],$rowdet['spart'])?>"/></td>
                    <td><input name="txtmonto[]" class="form-control input-sm txtmonto" value="<?=$rowdet['monto']?>"/></td>
                    <td align="center"><a class="del"><span class="fa fa-minus fa-2x"></span></a></td>
                  </tr>
                  <? } ?>
                  <tr class="copy">
                    <td class="col-lg-1"><input name="txtpart[]" maxlength="3" class="form-control input-sm txtpart" value="<?=$rowdet['part']?>"/></td>
                    <td class="col-lg-4"><input class="form-control input-sm txtdpart" disabled value="<?=bpart($rowdet['part'])?>"/></td>
                    <td class="col-lg-1"><input name="txtspart[]" maxlength="2" class="form-control input-sm txtspart" value="<?=$rowdet['spart']?>"/></td>
                    <td class="col-lg-4"><input class="form-control input-sm txtdspart" disabled value="<?=bspart($rowdet['part'],$rowdet['spart'])?>"/></td>
                    <td><input name="txtmonto[]" class="form-control input-sm txtmonto" value="<?=$rowdet['monto']?>"/></td>
                    <td align="center"><a class="add"><span class="fa fa-plus fa-2x"></span></a></td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th scope="row" colspan="4" align="right">Total</th>
                    <td><input name="monto" class="form-control input-sm" id="monto" readonly></td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="modal-footer">
              <button class="btn btn-success btn_guardadet" data-dismiss="modal">Guardar</button>
              <button class="btn btn-danger btn_canceldet" data-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- MODAL ELIMINAR SIGEP -->
    <div class="modal fade modaldelete" tabindex="-1" role="dialog" aria-labelledby="ModalConfirmacion" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Confirmaci&oacute;n</h3>
          </div>
          <div class="modal-body">
            Esta seguro de Eliminar el Preventivo?
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn_delete btn-danger">Eliminar</button>
            <button type="button" data-dismiss="modal" class="btn">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    <?                                                
    $sqldesc="SELECT * FROM descsigep WHERE gestion='".$row['gestion']."' AND nro='".$row['nro']."' AND idprev='".$row['idprev']."' AND tipo='".$row['tipo']."'";
    $qrydesc = $db->prepare($sqldesc);
    $qrydesc->execute();
    $rd = $qrydesc->fetch(PDO::FETCH_ASSOC);	
    ?>
    <!-- MODAL DESCARGO -->
    <div class="modal fade modaldescargo" tabindex="-1" role="dialog" aria-labelledby="ModalDescargo" aria-hidden="true">
      <form role="form" class="form-horizontal descargo">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h3>Descargo</h3>
            </div>
            <div class="modal-body">   
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="col-lg-1 control-label">Fecha</label>
                      <div class="col-lg-4">
                        <div class='input-group date' id='txtfecde'>
                          <input name="txtfdesc" type="text" class="form-control" id="txtfdesc" value="<?=newdate($rd['fecha'])?>" required/>
                          <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                      </div>
                      <label class="col-lg-1 control-label">Revisor</label>
                      <div class="col-lg-2">
                        <input name="txtrevisor" type="text" class="form-control" id="txtrevisor" value="<?=trim($rd['revisor'])?>" maxlength="2" required>
                      </div>
                      <label class="col-lg-1 control-label">HTD</label>
                      <div class="col-lg-3">
                        <input name="txthtddesc" type="text" class="form-control" id="txthtddesc" value="<?=trim($rd['htddesc'])?>" maxlength="8" required>
                      </div>
                    </div>
                  </div>
                  <!-- /.col-lg-12 (nested) -->
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="col-lg-1 control-label">Estado</label>
                      <div class="col-lg-2">
                        <input name="txtestado" type="text" class="form-control" id="txtestado" value="<?=trim($rd['estado'])?>" maxlength="1" required>
                      </div>
                      <label class="col-lg-4 control-label">Fecha Salida</label>
                      <div class="col-lg-5">
                        <div class='input-group date' id='txtfecds'>
                          <input name="txtfsal" type="text" class="form-control" id="txtfsal" value="<?=newdate($rd['fecha_s'])?>" required/>
                          <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.col-lg-12 (nested) -->
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="col-lg-1 control-label">Anexo</label>
                      <div class="col-lg-11">
                        <input name="txtanexo" type="text" class="form-control" maxlength="100" id="txtanexo" value="<?=trim($rd['anexo'])?>">
                      </div>
                    </div>
                  </div>
                  <!-- /.col-lg-12 (nested) -->
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success btn_guardadesc">Guardar</button>
                  <button type="button" class="btn btn-danger btn_canceldesc" data-dismiss="modal">Cancelar</button>
                </div>     
            </div>
          </div>
        </div>
      </form>
    </div>
    <?                                                
    $sqlpyv="SELECT * FROM pyvsigep WHERE gestion='".$row['gestion']."' AND nro='".$row['nro']."' AND idprev='".$row['idprev']."' AND tipo='".$row['tipo']."'";
    $qrypyv = $db->prepare($sqlpyv);
    $qrypyv->execute();
    $rpv = $qrypyv->fetch(PDO::FETCH_ASSOC);	
    ?>
    <!-- MODAL PASAJES Y VIATICOS -->
    <div class="modal fade modalpasajes" tabindex="-1" role="dialog" aria-labelledby="ModalPasajes" aria-hidden="true">
      <form role="form" class="form-horizontal pasajes">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h3>Pasajes y Viaticos</h3>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Inicio</label>
                    <div class="col-lg-5">
                      <div class='input-group date' id='txtfecini'>
                        <input name="txtfini" type="text" class="form-control" id="txtfini" value="<?=newdate($rpv['inicom'])?>" required/>
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <label class="col-lg-1 control-label">Fin</label>
                    <div class="col-lg-5">
                      <div class='input-group date' id='txtfecfin'>
                        <input name="txtffin" type="text" class="form-control" id="txtffin" value="<?=newdate($rpv['fincom'])?>" required/>
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Obs.</label>
                    <div class="col-lg-11">
                      <input name="txtobs" type="text" class="form-control" maxlength="100" id="txtobs" value="<?=trim($rpv['obs'])?>">
                    </div>
                  </div>
                </div>
                 <!-- /.col-lg-12 (nested) -->
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-danger btn_cancelpyv" data-dismiss="modal">Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- MODAL GENERAR CPBTE. CONTABLE -->
    <div class="modal fade modalgencpbte" tabindex="-1" role="dialog" aria-labelledby="ModalConfirmacion" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Confirmaci&oacute;n</h3>
          </div>
          <div class="modal-body">
            Esta seguro de Generar el Comprobante Contable de este preventivo?
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn_gencpbte btn-success">Generar</button>
            <button type="button" data-dismiss="modal" class="btn">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    <? } ?>
    <nav aria-label="Page navigation">
      <ul class="pagination">
      <? 
      if($tpaginas > 1) {
        $link="&criterio=".base64_encode($criterio);
        $disableprev = (($pagina - 1)>0)?"":"disabled";
        $disablenext = (($pagina + 1)<=$tpaginas)?"":"disabled";
        ?>
          <li class="<?=$disableprev?>"><a href="formresprev.php?pagina=<?="0".$link;?>"><span aria-hidden="true">&larr;</span> Primero</a></li>
          <li class="<?=$disableprev?>"><a href="formresprev.php?pagina=<?=($pagina-1).$link;?>">Anterior</a></li>
          <li class="<?=$disablenext?>"><a href="formresprev.php?pagina=<?=($pagina+1).$link;?>">Siguiente</a></li>
          <li class="<?=$disablenext?>"><a href="formresprev.php?pagina=<?=$tpaginas.$link;?>">Ultimo <span aria-hidden="true">&rarr;</span></a></li>
        <?
      }
      ?>
      </ul>
    </nav>
  </div>
  <!-- /#page-wrapper --> 
</div>
<!-- /#wrapper --> 
</body>
</html>
