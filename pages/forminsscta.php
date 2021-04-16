<?
/************************************************/
/*DESARROLLADO POR	:	ING. JOSE LEDO REBOLLO  */
/*FECHA				:	02/03/2020 	 */
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

  $.ajax({
    type : 'POST',
    url : "ajaxcombos.php",
    data : "list=tscta",
    success : function(html){
      $("#cbotscta").html(html);
    }
  });
  
	$("#cbotscta").change(function(){
		$("#cbotscta option:selected").each(function () {
			$.ajax({
				url:"ajaxcombos.php",
				data:"list=stscta&valor="+$(this).val(),
				success: function(html){
					$("#cbostscta").html(html);
          $("#tipocod").html('');
          $("#txtucod,#hdnscta").attr('value','');     
          $("#txtcod,#txtdes,#txtcodp,#txtci").val('');
          $("#txtdes").attr('readonly','readonly');
          $(".enlacescta").removeAttr("onclick")
				}
			});
		});
	});
	
	$("#cbostscta").change(function(){
		$("#cbostscta option:selected").each(function () {
			$.ajax({
        type : 'POST',
				url:"ajaxcodscta.php",
				data:"codt="+$("#cbotscta").val()+"&codst="+$(this).val(),
				success: function(data){
				  var json = eval("(" + data + ")");
          $("#tipocod").html(json.tipocod);
          $("#txtucod").attr('value',json.value);
          $("#txtcod").attr('maxlength',json.longitud)
          $("#hdnscta").attr('value','');
          $("#txtcod,#txtdes,#txtcodp,#txtci").val('');
          if($("#cbotscta").val()=='6'){
            $("#txtdes").attr('readonly','readonly');
            $(".enlacescta").attr("onclick","popup('zoomper.php','700','360')")
          }else{
            $("#txtdes").removeAttr('readonly')
            $(".enlacescta").removeAttr("onclick");
          }
				}
			});
		});
	});
  
  $(document).on('focusin','#hdnscta',function(){
    $.ajax({
      type : 'POST',
      url : "ajaxper.php",
      data : "valor="+$(this).val(),
      success : function(data){
        var json = eval("(" + data + ")");
        $("#txtdes").val(json.value);
        $("#txtcodp").val(json.codigo);
        $("#txtci").val(json.cid);
      }
    });
  });
  
  $('#txtdes,#txtcod').keyup(function(){
    this.value = this.value.toUpperCase();
  });
  
  /*Validar Fomulario*/
  $("#form").submit(function(e){
    e.preventDefault();
    if($("#hdnscta").first().val()=="" && $("#cbotscta").first().val()=='6'){
      $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Debe Seleccionar el Cuentadante!!</div>');
      return false; 
    }else if($("#cbotscta").first().val()!='6' && $("#txtdes").first().val()==''){
      $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Introduzca la Descripción!!</div>');
      return false;
    }
    var form_data = $('form').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxinsscta.php",
      data : form_data,
      success : function(html){
        if(html=="Ok"){
          $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Almacenó Correctamente!!</div>');
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
        <h3 class="page-header">Registro de Subcuentas</h3>
      </div>
      <!-- /.col-lg-12 --> 
    </div>
    <!-- /.row -->
    <div class="row">
      <form role="form" class="form-horizontal" id="form">
        <div class="col-lg-8">
          <div id="message"></div>
          <div class="panel panel-primary">
            <div class="panel-heading">Datos de la Subcuenta</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Tipo.Scta</label>
                    <div class="col-lg-5">
                      <select id="cbotscta" class="form-control" name="cbotscta" required></select>
                    </div>
                    <label class="col-lg-1 control-label">Sub.Tipo</label>
                    <div class="col-lg-5">
                      <select id="cbostscta" class="form-control" name="cbostscta" required>
                        <option value="">-Seleccione-</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Codigo</label>
                    <div class="col-lg-5">
                      <div class="input-group">
                        <span class="input-group-addon" id="tipocod"></span>
                        <input id="txtcod" type="text" class="form-control" name="txtcod" placeholder="Completar codigo" required>
                      </div>
                    </div>
                    <label class="col-lg-1 control-label">Ultimo.Cod.</label>
                    <div class="col-lg-5">
                      <input name="txtucod" class="form-control" id="txtucod" disabled>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Descripci&oacute;n</label>
                    <div class="col-lg-11">
                      <div class="input-group">
                        <input name="txtdes" class="form-control" id="txtdes" readonly>
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
                    <label class="col-lg-1 control-label">Cod.Per.</label>
                    <div class="col-lg-5">
                      <input name="txtcodp" class="form-control" id="txtcodp" readonly>
                    </div>
                    <label class="col-lg-1 control-label">C.I.</label>
                    <div class="col-lg-5">
                      <input name="txtci" class="form-control" id="txtci" readonly>
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
