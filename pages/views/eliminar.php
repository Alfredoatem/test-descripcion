<?php 
include "../../connections/connect.php";
include "../../functions/global.php";

$nro=$_GET['nro'];
$dcto=$_GET['dcto'];

//$sql="SELECT * FROM ingteso where nro='$nro' ";
$sql="SELECT * FROM ingteso where nro='$nro' and dcto='$dcto' ORDER BY 1,2";
$query = $db->prepare($sql);
$query->execute();

$row = $query->fetch(PDO::FETCH_ASSOC);

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
<link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- MetisMenu CSS -->
<link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="../../resources/scripts/sb-admin-2/css/sb-admin-2.css" rel="stylesheet">
<!-- Custom Fonts -->
<link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- Bootstrap Datepicker CSS-->
<link href="../../vendor/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- jQuery  -->
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

  $('#txtfechav').datetimepicker({
      useCurrent: false,
      viewMode: 'years',
      format: 'DD/MM/YYYY'
  });
  $('#txtfechadep').datetimepicker({
      useCurrent: false,
      viewMode: 'years',
      format: 'DD/MM/YYYY'
  });
  $('#txtfecest').datetimepicker({
      useCurrent: false,
      viewMode: 'years',
      format: 'DD/MM/YYYY'
  });

 
});
</script>
</head>

<body>
<div id="wrapper"> 
  
  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-brand" href="views/inicio.php">Transacci&oacute;n de Ingresos</a>
    </div>
    <!-- /.navbar-header -->
    <? include("inc/menuh.php") ?>
    <!-- /.navbar-top-links -->
    <? include("inc/menuv.php") ?>
    <!-- /.navbar-static-side --> 
  </nav>
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h2 class="page-header">Transacci&oacute;n de Ingresos</h2>        
      </div>
      <!-- /.col-lg-12 --> 
      
    </div>
    <br>
    <!--//////////////////////////////////////////////////////////////////////////////////////////////-->
    <?php if(isset($_SESSION['message'])){?>
      <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?= $_SESSION['message'] ?>
      </div>
    <? session_unset(); }?>
    <!--//////////////////////////////////////////////////////////////////////////////////////////////-->
    <!-- /.row -->
    <div class="row">
      <form role="form" action="delete.php" class="form-horizontal" method="POST">
        <div class="col-lg-12">
          <div id="message"></div>
          <div class="panel panel-primary">
            <div class="panel-heading">REGISTRO DE DATOS</div>

            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Gesti&oacute;n:</label>
                    <div class="col-lg-3">
                      <input name="txtgestion" class="form-control llaves" id="txtgestion" type="text" value="<?=$row['gestion']?>" required>
                    </div>
                    <label class="col-lg-1 control-label">Dcto.:</label>
                    <div class="col-lg-3">
                      <input name="txtdcto" class="form-control llaves" id="txtdcto" value="<?=$row['dcto']?>" required>
                    </div>
                    <label class="col-lg-1 control-label">Nro.:</label>
                    <div class="col-lg-3">
                      <input name="txtnro" class="form-control llaves" id="txtnro" value="<?=$row['nro']?>" required>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                  <label class="col-lg-1 control-label">Fecha Verificaci&oacute;n</label>
                    <div class="col-lg-3">
                      <div class='input-group date' id='txtfechav'>
                        <input type='text' class="form-control" name="txtfechav" value="<?=newdate($row['fecha_v'])?>" required/>
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <label class="col-lg-1 control-label">Fecha Deposito:</label>
                    <div class="col-lg-3">
                      <div class='input-group date' id='txtfechadep'>
                        <input type='text' class="form-control" name="txtfechadep" value="<?=newdate($row['fecha_dep'])?>" required/>
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <label class="col-lg-1 control-label">Op. Banco:</label>
                    <div class="col-lg-3">
                      <input name="txtopbanco" class="form-control" id="txtopbanco" maxlength="8" value="<?=$row['opbanco']?>" required>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Interesado:</label>
                    <div class="col-lg-11">
                      <input name="txtinter" class="form-control" maxlength="100" id="txtinter" value="<?=$row['inter']?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                        <label class="col-lg-1 control-label">Observaciones:</label>
                        <div class="col-lg-11">
                          <input name="txtobs" class="form-control" id="txtobs" value="<?=$row['obs']?>">
                        </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Cod.Concepto Ingreso:</label>
                    <div class="col-lg-3">
                      <input name="txtcodcon" class="form-control" id="txtcodcon" value="<?=$row['codcon']?>">
                    </div>
                    <label class="col-lg-1 control-label">Cod.Cuenta Bancaria:</label>
                    <div class="col-lg-3">
                      <input name="txtcodcta" class="form-control" id="txtcodcta" value="<?=$row['codcta']?>">
                    </div>
                    <label class="col-lg-1 control-label">Cod. Reparici&oacute;n:</label>
                    <div class="col-lg-3">
                      <input name="txtrepar" class="form-control" id="txtrepar" value="<?=$row['repar']?>">
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Dcto.Contable:</label>
                    <div class="col-lg-3">
                      <input name="txtdctoc" class="form-control" id="txtdctoc"value="<?=$row['dcto_c']?>" >
                    </div>
                    <label class="col-lg-1 control-label">Programa</label>
                    <div class="col-lg-3">
                      <input name="txtprograma" class="form-control" id="txtprograma"value="<?=$row['programa']?>" >
                    </div>
                    <label class="col-lg-1 control-label">monto</label>
                    <div class="col-lg-3">
                      <input name="txtmonto" class="form-control" id="txtmonto" value="<?=$row['monto']?>" required>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Cta.Contable:</label>
                    <div class="col-lg-3">
                      <input name="txtcta" class="form-control" id="txtcta" value="<?=$row['cta']?>">
                    </div>
                    <label class="col-lg-1 control-label">Actividad:</label>
                    <div class="col-lg-3">
                      <input name="txtclase" class="form-control" id="txtclase"  value="<?=$row['clase']?>">
                    </div>
                    <label class="col-lg-1 control-label">Rubro:</label>
                    <div class="col-lg-3">
                      <input name="txtrubro" class="form-control" id="txtrubro"  value="<?=$row['rubro']?>">
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Estado:</label>
                    <div class="col-lg-3">
                      <input name="txtestado" class="form-control" id="txtestado" value="<?=$row['estado']?>">
                    </div>
                    <label class="col-lg-1 control-label">Fuente Fin:</label>
                    <div class="col-lg-3">
                      <input name="txtffin" class="form-control" id="txtffin"  value="<?=$row['ffin']?>"required>
                    </div>
                    <label class="col-lg-1 control-label">Preventivo:</label>
                    <div class="col-lg-3">
                      <input name="txtpreventivo" class="form-control" id="txtpreventivo" value="<?=$row['preventivo']?>">
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                  <label class="col-lg-1 control-label">Fecha A.:</label>
                    <div class="col-lg-5">
                      <div class='input-group date' id='txtfecest'>
                        <input type='text' class="form-control" name="txtfecest"  value="<?=newdate($row['fecest'])?>"/>
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <label class="col-lg-1 control-label">ObsEst.:</label>
                    <div class="col-lg-5">
                      <input name="txtobsa" class="form-control" id="txtobsa" value="<?=$row['obsa']?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-1">
              <button  class="btn btn-danger" name="btnguardar" id="btneliminar">Eliminar</button>
            </div>
            <div class="pull-right">
              <button type="button" onClick="history.go(-1);" class="btn btn-lg btn-primary btn-volver">Volver</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>  
</div>
</body>
</html>