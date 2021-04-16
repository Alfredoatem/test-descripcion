<?php 
/************************************************/
/*DESARROLLADO POR	:	ING. JOSE LEDO REBOLLO  */
/*FECHA				:	02/05/2020 	 */
/*CELULAR			:	70614112		 */
/*LUGAR				:	MINDEFENSA - LA PAZ*/
/************************************************/
include "seguridad.php";
include "../connections/connect.php";
include "../functions/global.php";
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
<!-- Bootstrap Select CSS-->
<link href="../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">

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
<script src="../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<!-- Metis Menu Plugin JavaScript --> 
<script src="../vendor/metisMenu/metisMenu.min.js"></script> 
<!-- Custom Theme JavaScript --> 
<script src="../resources/scripts/sb-admin-2/js/sb-admin-2.js"></script>

<script type="text/javascript">

$(function(){
  /*Funciones de Maestro*/
  $("#txtprev").focus();
  $('#txtfec').datetimepicker({
    locale: 'es',
    format: 'L',
    minDate: moment("01/01/2015"),
    maxDate: moment(),
    defaultDate: moment()
  });
  
  $(".enlacescta").attr("onclick","popup('zoomsctas.php','700','360')")
  $("#txtprev").numeric();
  
  $("#txtprev").focusout(function(){
    if($(this).val()=="") {
      $(this).focus();
    }else{
      $("#txtipo").focus(); 
    }
  });
  
  $("#txtipo").focusin(function(){
    $(this).val("N")
  });
  
  $("#txtprev, #txtipo").focusout(function(){
    var llaves = $("form").find('.llaves').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxcorr.php",
      data : llaves,
      success : function(html){
        if($.isNumeric(html)){
          $("#txtcorr").val(html);
        }else{
          $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>');
        }
      }
    });
  });
  
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
  
  /*Funciones de Detalle*/
  $("#alertpart,#alertspart").hide();
  $(".txtcant,#monto").css('text-align','right').number(true,2,'.','');
  $(".txtalm").number(true,0);
  $(".txtprod").numeric();
    
	$(document).on('click','.add',function(){
		$("tr.copy:last").clone().insertAfter('tr.copy:last');
		$("tr.copy:last input").val("");
		$(this).find("span").remove();
		$(this).append('<span class="fa fa-minus fa-2x"></span>');
		$(this).attr('class','del');

		$(".txtcant").css('text-align','right').number(true,2,'.','');
    $(".txtcant").trigger("keyup");
	});
  
  $(document).on('click','.del',function(){
		$(this).parent().parent().remove();
    $(".txtcant").trigger("keyup");
	});
	
	$(document).on('change','.txtalm',function(){
    var index = $('.txtalm').index(this)
		$.ajax({
      type : 'POST',
      url : "ajaxpart.php",
      data : "valor="+$(this).val(),
      success : function(data){
        var json = eval("(" + data + ")");
        if(json.value==''){
          $("#alertpart").html('<div id="alertpart" class="alert alert-danger" role="alert"><strong>Error!</strong> Debe introducir una Partida Existente</div>').fadeIn("slow");
          $(".txtalm:eq("+index+")").val("").focus(); 
          $(".txtdpart:eq("+index+")").val(""); 
        }else{
          $(".txtdpart:eq("+index+")").val(json.value); 
          $('#alertpart').delay(500).fadeOut("slow");
        }
      }
    });
	});
  
  $(document).on('change','.txtprod',function(){
    var index = $('.txtprod').index(this)
		$.ajax({
      type : 'POST',
      url : "ajaxspart.php",
      data : "valor="+$(this).val()+"&part="+$(".txtalm:eq("+index+")").val(),
      success : function(data){
        var json = eval("(" + data + ")");
        if(json.value==''){
          $("#alertpart").html('<div id="alertpart" class="alert alert-danger" role="alert"><strong>Error!</strong> Debe introducir una Sub Partida Existente</div>').fadeIn("slow");
          $(".txtprod:eq("+index+")").val("").focus(); 
          $(".txtdspart:eq("+index+")").val(""); 
        }else{
          $(".txtdspart:eq("+index+")").val(json.value);
          $("#alertpart").delay(500).fadeOut("slow");
        }
      }
    });
	});
  
  $(document).on('keyup','.txtcant',function(){
		var importe = 0;
    $('.txtcant').each(function(index, element){
      var c = eval($(this).val());
      if(c==null || c=='') c=0;
      importe = importe + c;
    });
    $('#monto').val(importe.toFixed(2));
	});
  
  /*Validar Fomulario*/
  $("#form").submit(function(e){
    e.preventDefault();
    if($("#hdnscta").first().val()==""){
      $('#txtper').tooltip('show');
      return false; 
    }
    var form_data = $('form').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxinsprev.php",
      data : form_data,
      success : function(html){
        if(html=="Ok"){
          $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Almaceno Correctamente!!</div>');
        }else{
          $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>');
        }
      }
    });
  });
  
  $('#message').on('close.bs.alert', function(){
    location.reload();
  });

});
</script>
<style>
  .input-group-field {
    display: table-cell;
    border-collapse: collapse;
    vertical-align: middle;
    border-radius:4px;
  }
  .input-group-field .form-control, .input-group-field .form-control {
    border-radius: inherit !important;
  }
  .input-group-field:not(:first-child):not(:last-child) {
    border-radius:0;
  }
  .input-group-field:not(:first-child):not(:last-child) .form-control {
    border-left-width: 0;
    border-right-width: 0;
  }
  .input-group-field:last-child {
    border-top-left-radius:0;
    border-bottom-left-radius:0;
  }
</style>
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
        <h2 class="page-header">Registro</h2>
      </div>
      <!-- /.col-lg-12 --> 
    </div>
    <!-- /.row -->
    <div class="row">
      <form role="form" class="form-horizontal" id="form">
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
                      <input name="txtgest" class="form-control llaves" id="txtgest" value="<?=$gestion?>" readonly>
                    </div>
                    <label class="col-lg-1 control-label">Tipo.Doc</label>
                    <div class="col-lg-3">
                      <input name="txtprev" class="form-control llaves" id="txtprev" required>
                    </div>
                    <label class="col-lg-1 control-label">Nro.Doc</label>
                    <div class="col-lg-3">
                      <input name="txtipo" class="form-control llaves" id="txtipo" maxlength="1" required>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Fecha</label>
                    <div class="col-lg-3">
                      <div class='input-group date' id='txtfec'>
                        <input type='text' class="form-control" name="txtfecha" required/>
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <label class="col-lg-1 control-label">HTD</label>
                    <div class="col-lg-3">
                      <input name="txthtd" class="form-control" id="txthtd" maxlength="8" required>
                    </div>
                    <label class="col-lg-1 control-label">Doc.Conta.</label>
                    <div class="col-lg-3">
                      <div class="input-group">
                        <input name="txtdctoconta" id="txtdctoconta" type='text' class='form-control' placeholder="Dcto" />
                      <div class='input-group-field'>
                        <input name="txtnroconta" id="txtnroconta" type='text' class='form-control' placeholder="Nro" />
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Glosa</label>
                    <div class="col-lg-11">
                      <input name="txtglosa" class="form-control" maxlength="100" id="txtglosa" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Reparticion</label>
                    <div class="col-lg-11">
                      <div class="input-group">
                        <input name="txtper" class="form-control" id="txtper" data-toggle="tooltip" data-placement="bottom" title="Seleccione un Cuentadante" readonly>
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
                    <label class="col-lg-1 control-label">Empresa</label>
                    <div class="col-lg-7">
                      <input name="txtfte" class="form-control" id="txtfte" maxlength="2" required>
                    </div>
                    <label class="col-lg-1 control-label">Factura</label>
                    <div class="col-lg-3">
                      <input name="txtorg" class="form-control" id="txtorg" maxlength="3" required>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Solicitado.Por</label>
                    <div class="col-lg-7">
                      <input name="txtprog" class="form-control" id="txtprog" maxlength="2" required>
                    </div>
                    <label class="col-lg-1 control-label">Pedido</label>
                    <div class="col-lg-3">
                      <input name="txtproy" class="form-control" id="txtproy" maxlength="4" required>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Responsable</label>
                    <div class="col-lg-7">
                      <input name="txtprog" class="form-control" id="txtprog" maxlength="2" required>
                    </div>
                    <label class="col-lg-1 control-label">Tip.Per.</label>
                    <div class="col-lg-3">
                      <select name="cbotiper" id="cbotiper" class="form-control">
                      </select>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) --> 
              </div>
              <!-- /.row (nested) --> 
            </div>
            <!-- /.panel-body --> 
          </div>
          <!-- /.panel -->
          <div id="alertpart"></div>
          <!-- /.DETALLE -->
          <div class="panel panel-default">
            <div class="panel-heading">Detalle</div>
            <div class="panel-body">
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col" colspan="2">Almacen</th>
                    <th scope="col" colspan="2">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">P.U.</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="copy">
                    <td width="8%"><input name="txtalm[]" maxlength="3" class="form-control input-sm txtalm" required/></td>
                    <td width="22%"><input class="form-control input-sm txtdpart" disabled/></td>
                    <td width="12%"><input name="txtprod[]" maxlength="8" class="form-control input-sm txtprod" required/></td>
                    <td width="26%"><input class="form-control input-sm txtdspart" disabled/></td>
                    <td width="15%"><input name="txtcant[]" class="form-control input-sm txtcant" maxlength="12" required/></td>
                    <td width="15%"><input name="txtpu[]" class="form-control input-sm txtpu" maxlength="18" required/></td>
                    <td width="2%" align="center"><a class="add"><span class="fa fa-plus fa-2x"></span></a></td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th scope="row" colspan="5" align="right">Total</th>
                    <td><input name="monto" class="form-control input-sm" id="monto" readonly></td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.panel-body --> 
          </div>
          <!-- /.panel -->
          <div class="form-group">
            <div class="col-lg-1">
              <button type="submit" class="btn btn-success">Guardar</button>
            </div>
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
