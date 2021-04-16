<?php
include "seguridad_alm.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Sistema de Almacenes</title>

<!-- Bootstrap Core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="resources/scripts/sb-admin-2/css/sb-admin-2.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<!-- Bootstrap Select CSS-->
<link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- jQuery --> 
<script src="vendor/jquery/jquery.min.js"></script> 
<!-- Bootstrap Core JavaScript --> 
<script src="vendor/bootstrap/js/bootstrap.min.js"></script> 

<!-- Metis Menu Plugin JavaScript --> 
<script src="vendor/metisMenu/metisMenu.min.js"></script> 
<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<!-- Custom Theme JavaScript --> 
<script src="resources/scripts/sb-admin-2/js/sb-admin-2.js"></script>
<script type="text/javascript">
$(function(){
  $.ajax({
    type : 'POST',
    url : "ajaxcomboalma.php",
    data : "list=almauser",
    success : function(html){
      $("#cboalma").html(html);
    }
  });
  $("#cancel").click(function(e){
    parent.location.href='logout.php'
  });
  /*Validar Fomulario*/
  $("#form").submit(function(e){
    var form_data = $('form').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxsessalma.php",
      data : form_data,
      success : function(html){
        location.reload()
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
        <a class="navbar-brand" href="index.php">Sistema de Almacenes</a>
      </div>
    </nav>
    <div class="container">
      <div class="row" style="margin-top: 20px">
        <div class="col-md-8 col-md-offset-2">
          <div id="message"></div>
          <div class="panel panel-default panel">
            <div class="panel-heading">
              <h3 class="panel-title">Seleccione el Almacen</h3>
            </div>
            <div class="panel-body">
              <form role="form" id="form">
                <fieldset>
                  <div class="form-group">
                    <select class="form-control" id="cboalma" name="cboalma">
                    </select>
                  </div>
                  <input type="submit" class="btn btn-success" name="submit" id="submit" value="Ingresar">
                  <input type="button" class="btn btn-default" name="cancel" id="cancel" value="Salir">
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
