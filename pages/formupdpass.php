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
  $("#oldpass").focus();

  /*Validar Fomulario*/
  $("#form").submit(function(e){
    e.preventDefault();
    var form_data = $('form').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxupdpass.php",
      data : form_data,
      success : function(html){
        if(html=="Ok"){
          $('#message').html('<div class="alert alert-success fade in">Password Cambiado Correctamente!!</div>');
          $(".alert").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
            document.location='../logout.php';
          });
        }else if(html=="ErrorNuevo"){
          $('#message').html('<div class="alert alert-danger fade in">Password Nuevo no Coincide</div>');
          $(".alert").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
          });
        }else if(html=="Incorrecto"){
          $('#message').html('<div class="alert alert-danger fade in">Password INCORRECTO!! Intente con otro</div>');
          $(".alert").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
          });
        }else if(html=="Error"){
          $('#message').html('<div class="alert alert-danger fade in">Su Password no coincide con el Antiguo</div>');
          $(".alert").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
          });
        }else{
          $('#message').html('<div class="alert alert-danger fade in">'+html+'</div>');
          $(".alert").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
          });
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
        <h2 class="page-header">Cambiar Contrase&ntilde;a</h2>
      </div>
      <!-- /.col-lg-12 --> 
    </div>
    <!-- /.row -->
    <div class="row">
      <form role="form" id="form">
        <div class="col-lg-6">
          <div id="message"></div>
          <div class="panel panel-primary">
            <div class="panel-heading">Datos</div>
            <div class="panel-body">
              <div class="form-group">
                <label for="passantiguo">Password Antiguo</label>
                <input type="password" class="form-control" name="oldpass" id="passantiguo" aria-describedby="emailHelp" required>
              </div>
              <div class="form-group">
                <label for="passnuevo">Nuevo Password</label>
                <input type="password" class="form-control" name="newpass1" id="passnuevo" required>
              </div>
              <div class="form-group">
                <label for="passconfirm">Confirmar Password</label>
                <input type="password" class="form-control" name="newpass2" id="passconfirm" required>
              </div>
              <button type="submit" class="btn btn-primary">Guardar</button>
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
