<?php 
include "../../connections/connect.php";
include "../../functions/global.php";
///////////////////////////////////////////////////////////////////////////////////////////////////////
$criterio='';

if($_GET['criterio']){
  $criterio .= base64_decode($_GET['criterio']); 
}

$aux=(trim($criterio)=='')?"":"AND".$criterio;

$registros = 1;

if(isset($_GET["pagina"])==null){
    $pagina = 0;
}
    else{
        $pagina = $_GET["pagina"];
    }

if (!$pagina) { 
	$inicio = 0; 
	$pagina = 1; 
} 
else { 
	$inicio = ($pagina - 1) * $registros; 
}
///////////////////////////////////////////////////////////////////////////////////////////////////////
//$where="";
/*if(!empty($_POST)){
    $valor=$_POST['campo'];
    if(!empty($valor)){
        $where = "dcto='O'";
    }
}*/

$where="WHERE dcto ='T'";

    $busqueda=$_REQUEST['busqueda'];
    $busqueda2=$_REQUEST['busqueda2'];
    if($busqueda == '' AND $busqueda2 != ''){
        $where = "WHERE dcto = 'T' and (nro = '$busqueda2' or opbanco = '$busqueda2')";
    }else{
        if($busqueda != '' AND $busqueda2 == ''){
            $where = "WHERE dcto='T' and (inter like '%$busqueda%' or codcta like '%$busqueda%' or codcon like '%$busqueda%' or cta like '%$busqueda%' or obs like '%$busqueda%' or repar like '%$busqueda%' or dcto_c like '%$busqueda%' or estado like '%$busqueda%' or obsa like '%$busqueda%' or programa like '%$busqueda%' or clase like '%$busqueda%' or rubro like '$$busqueda$' or ffin like '%$busqueda%' or gestprev like '%$busqueda%' or preventivo like '%$busqueda%') ";
        }
    }if($busqueda == '' AND $busqueda2 == ''){
        $where = "WHERE dcto = 'T' ";
    }


//$sql="SELECT count(*) as num FROM ingteso WHERE dcto='T' ";
//$sql="SELECT count(*) as num FROM ingteso WHERE dcto='T' and (inter like '%$busqueda%' or codcta like '%$busqueda%' or codcon like '%$busqueda%' or cta like '%$busqueda%' or obs like '%$busqueda%' or repar like '%$busqueda%' or dcto_c like '%$busqueda%' or estado like '%$busqueda%' or obsa like '%$busqueda%' or programa like '%$busqueda%' or clase like '%$busqueda%' or rubro like '$$busqueda$' or ffin like '%$busqueda%' or gestprev like '%$busqueda%' or preventivo like '%$busqueda%' or opbanco='$busqueda')";
$sql="SELECT count(*) as num FROM ingteso $where ";
$query = $db->prepare($sql);
$query->execute();
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
$r = $query->fetch(PDO::FETCH_ASSOC);	
$total=$r['num'];

if ($total==0){
  echo "<script type='text/javascript'>alert('No Existen Datos.\nIntroduzca otro parametro de Busqueda');";
  echo "document.location='formsrcprev.php'</script>";
  ?>
  <script type="text/javascript">alert('No existen Datos');window.history.back();</script>
  <?
  exit;
}

//$sql="SELECT skip $inicio first $registros * FROM ingteso WHERE dcto='T'";
//$sql="SELECT skip $inicio first $registros * FROM ingteso WHERE dcto='T' and (inter like '%$busqueda%' or codcta like '%$busqueda%' or codcon like '%$busqueda%' or cta like '%$busqueda%' or obs like '%$busqueda%' or repar like '%$busqueda%' or dcto_c like '%$busqueda%' or estado like '%$busqueda%' or obsa like '%$busqueda%' or programa like '%$busqueda%' or clase like '%$busqueda%' or rubro like '$$busqueda$' or ffin like '%$busqueda%' or gestprev like '%$busqueda%' or preventivo like '%$busqueda%' or opbanco='$busqueda')";
$sql="SELECT skip $inicio first $registros * FROM ingteso $where";
$sql.="ORDER BY 1,2 ";
$query = $db->prepare($sql);
$query->execute();
$tpaginas = ceil($total/$registros);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
      //useCurrent: false,
      viewMode: 'years',
      format: 'DD/MM/YYYY'
  });
  $('#txtfechadep').datetimepicker({
      //useCurrent: false,
      viewMode: 'years',
      format: 'DD/MM/YYYY'
  });
  $('#txtfecest').datetimepicker({
     // useCurrent: false,
      viewMode: 'years',
      format: 'DD/MM/YYYY'
  });
});
</script>
<!------------------------------------------------------------------------------------------------------->
    <style>
      .pagination{
        margin:0px 0;
      }
      button.btn-volver{
        float: right;
      }
    </style>
<!------------------------------------------------------------------------------------------------------->
</head>

<body>

<div class="wrapper">
 <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
        <a class="navbar-brand" href="views/inicio.php">Transacci&oacute;n de Ingresos</a>
        </div>
        
        <? include("inc/menuh.php") ?>
        
        <? include("inc/menuv.php") ?>
        
    </nav>

  <div id="page-wrapper">
        <? while($row = $query->fetch(PDO::FETCH_ASSOC)) {?>
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Transacci&oacute;n de Ingresos
                    <!--//////////////////////////////////////////////////////////////////////////////////////////////-->
                    <div class='pull-right'>
                        <div class='btn-group' role="group">
                            <a href="reging.php?dcto=<?=$row['dcto'];?>&nro=<?=$row['nro'];?>" class="btn btn-info"><span class="fa fa-file"></span>&nbsp;Registrar</a>
                            <!--<a href="modificar.php?nro=<?//=$row['nro']?>" class="btn btn-success"><span class="fa fa-edit"></span>&nbsp;Editar</a>-->
                            <a href="modificar.php?dcto=<?=$row['dcto'];?>&nro=<?=$row['nro'];?>" class="btn btn-success"><span class="fa fa-edit"></span>&nbsp;Editar</a>
                            <a href="eliminar.php?dcto=<?=$row['dcto'];?>&nro=<?=$row['nro'];?>" class="btn btn-danger"><span class="fa fa-eraser"></span>&nbsp;Eliminar</a>
                            <a href="../reportes/reporteingteso.php?documento=<?=base64_encode($row['dcto'].','.$row['nro'].','.$row['gestion'])?>" class="btn btn-default" target="_blank"><span class="fa fa-print"></span>&nbsp;Imprimir</a>
                        </div>
                    </div>
                    <!--//////////////////////////////////////////////////////////////////////////////////////////////-->
                </h2>    
                <!--////////////////////////////////////////////===BUSCADOR===///////////////////////////////////////////-->
                
                <div>
                    <div class="pull-left" style="float:right; padding:30px 0 0 0;"><b><?echo $tpaginas;?></b> Resultado(s) encontrados.</div>
                    <div class="row right" style="float:right; padding:20px 0 0 0;">
                        <div class="col-lg-12">
                            <form action="" method="GET" class="form-search">
                                    <input type="text" id="busqueda" name="busqueda" value="<? echo $busqueda?>" placeholder="Buscar" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    <input type="text" id="busqueda2" name="busqueda2" value="<? echo $busqueda2?>" placeholder="Buscar" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">                            
                                    <input type="submit" id="enviar" name="enviar" Value="Buscar" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>      
            </div>
            <!-- /.col-lg-12 --> 
        
        </div>
        <!--////////////////////////////////////////////BUSCADOR//////////////////////////////////////////////////-->

        <!--//////////////////////////////////////////////////////////////////////////////////////////////-->
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
            <form role="form" action="ajaxlising2.php" class="form-horizontal" id="formajax" method="POST">
            <div class="col-lg-12">
                <div id="message"></div>
                    <div class="panel panel-primary">
                    
                        <div class="panel-heading">REGISTRO DE DATOS
                            
                        </div>

                            <div class="panel-body">
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Gesti&oacute;n:</label>
                                            <div class="col-lg-3">
                                                <input name="txtgestion" class="form-control llaves" id="txtgestion" type="text" value="<?=$row['gestion']?>" required readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Dcto.:</label>
                                            <div class="col-lg-3">
                                                 <input name="txtdcto" class="form-control llaves" id="txtdcto" value="<?=$row['dcto']?>" required readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Nro.:</label>
                                            <div class="col-lg-3">
                                                <input name="txtnro" class="form-control llaves" id="txtnro" value="<?=$row['nro']?>"  required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-lg-12 (nested) -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Fecha Verificaci&oacute;n</label>
                                            <div class="col-lg-3">
                                                <div class='input-group date' id='txtfechav'>
                                                    <input type='text' class="form-control" name="txtfechav" value="<?=newdate($row['fecha_v'])?>" required readonly/>
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <label class="col-lg-1 control-label">Fecha Deposito:</label>
                                            <div class="col-lg-3">
                                                <div class='input-group date' id='txtfechadep'>
                                                    <input type='text' class="form-control" name="txtfechadep" value="<?=newdate($row['fecha_dep'])?>" required readonly/>
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <label class="col-lg-1 control-label">Op. Banco:</label>
                                            <div class="col-lg-3">
                                                <input name="txtopbanco" class="form-control" id="txtopbanco" maxlength="8" value="<?=$row['opbanco']?>" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-lg-12 (nested) -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Interesado:</label>
                                            <div class="col-lg-11">
                                                <input name="txtinter" class="form-control" maxlength="100" id="txtinter" value="<?=$row['inter']?>" required readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Observaciones:</label>
                                            <div class="col-lg-11">
                                                <input name="txtobs" class="form-control" id="txtobs" data-toggle="tooltip" data-placement="bottom" value="<?=$row['obs']?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-lg-12 (nested) -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Cod.Concepto Ingreso:</label>
                                            <div class="col-lg-3">
                                                <input name="txtcodcon" class="form-control" id="txtcodcon" value="<?=$row['codcon']?>" readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Cod.Cuenta Bancaria:</label>
                                            <div class="col-lg-3">
                                                <input name="txtcodcta" class="form-control" id="txtcodcta" value="<?=$row['codcta']?>" readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Cod. Reparici&oacute;n:</label>
                                            <div class="col-lg-3">
                                                <input name="txtrepar" class="form-control" id="txtrepar" value="<?=$row['repar']?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-lg-12 (nested) -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Dcto.Contable:</label>
                                            <div class="col-lg-3">
                                                <input name="txtdctoc" class="form-control" id="txtdctoc"value="<?=$row['dcto_c']?>"  readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Programa</label>
                                            <div class="col-lg-3">
                                                <input name="txtprograma" class="form-control" id="txtprograma"value="<?=$row['programa']?>"  readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">monto</label>
                                            <div class="col-lg-3">
                                                <input name="txtmonto" class="form-control" id="txtmonto" value="<?=$row['monto']?>" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-lg-12 (nested) -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Cta.Contable:</label>
                                            <div class="col-lg-3">
                                                <input name="txtcta" class="form-control" id="txtcta" value="<?=$row['cta']?>" readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Actividad:</label>
                                            <div class="col-lg-3">
                                                <input name="txtclase" class="form-control" id="txtclase" value="<?=$row['clase']?>"  readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Rubro:</label>
                                            <div class="col-lg-3">
                                                <input name="txtrubro" class="form-control" id="txtrubro" value="<?=$row['rubro']?>"  readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-lg-12 (nested) -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Estado:</label>
                                            <div class="col-lg-3">
                                                <input name="txtestado" class="form-control" id="txtestado" value="<?=$row['estado']?>" readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Fuente Fin:</label>
                                            <div class="col-lg-3">
                                                <input name="txtffin" class="form-control" id="txtffin"  value="<?=$row['ffin']?>" required readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Preventivo:</label>
                                            <div class="col-lg-3">
                                                <input name="txtpreventivo" class="form-control" id="txtpreventivo" value="<?=$row['preventivo']?>"  readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-lg-12 (nested) -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Fecha A.:</label>
                                            <div class="col-lg-5">
                                                <div class='input-group date' id='txtfecest'>
                                                    <input type='text' class="form-control" name="txtfecest"  value="<?=newdate($row['fecest'])?>"  readonly/>
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <label class="col-lg-1 control-label">ObsEst.:</label>
                                            <div class="col-lg-5">
                                                <input name="txtobsa" class="form-control" id="txtobsa" value="<?=$row['obsa']?>"  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                    <!--<a href="modificar.php?nro=<?=$row['nro']?>" class="btn btn-button"><span class="fa fa-edit"></span>&nbsp;Editar</a>-->
                                    <!--<a href="eliminar.php?nro=<?=$row['nro']?>" class="btn btn-button"><span class="fa fa-eraser"></span>&nbsp;Eliminar</a>-->
                                    <!--<a href="#" data-href="eliminar.php?nro=<?=$row['nro']?>" class="btn btn-button" data-toggle="modal" data-target="#confirm-delete"><span class="fa fa-eraser"></span>&nbsp;Eliminar</a>-->
                            </div>
                            
                    </div>
            </div>
            <!-- /.col-lg-12 -->
            </form>
        </div>
        <?}?>
        <!--===================================NAVEGACIÓN==========================================================-->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?
                if($tpaginas > 1) {
                    $link="&criterio=".base64_encode($criterio);
                    $disableprev = (($pagina - 1)>0)?"":"disabled";
                    $disablenext = (($pagina + 1)<=$tpaginas)?"":"disabled";
                    ?>
                                        <li class="<?=$disableprev?>"><a href="?pagina=<?="0".$link;?>"><span aria-hidden="true">&larr;</span> Primero</a></li>
                    <li class="<?=$disableprev?>"><a href="?pagina=<?echo $pagina-1;?>&busqueda=<?echo $busqueda;?>&busqueda2=<?echo $busqueda2;?>">Anterior</a></li>
                    <li class="<?=$disablenext?>"><a href="?pagina=<?echo $pagina+1;?>&busqueda=<?echo $busqueda;?>&busqueda2=<?echo $busqueda2;?>">Siguiente</a></li>
                    <li class="<?=$disablenext?>"><a href="?pagina=<?echo $tpaginas;?>&busqueda=<?echo $busqueda;?>&busqueda2=<?echo $busqueda2;?>">Ultimo <span aria-hidden="true">&rarr;</span></a></li>
                    <?
                }
                ?>          
            </ul>          
            <button type="button" onclick="location.href='indextgn.php'" class="btn btn-lg btn-primary btn-volver">Volver</button>

        </nav> 
        <!--==============================================================================================-->
    </div>
</div>
<!--================================MODAL ELIMINAR==============================================-->
<div class="modal fade" id="confirm-delete" role="dialog">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
            <h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
        </div>
        <div class="modal-body">
            ¿Desea eliminar este Registro?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <a href="" class="btn btn-danger btn-ok">Eliminar</a>
        </div>
    </div>
    </div>
</div>
<script>
    $('#confirm-delete') .on('show.bs.modal', function(e) {
        $(this) .find('.btn-ok') .attr('href', $(e.relatedTarget) .data('href'));
        $('.debug-url') .html('Delete URL: <strong>' + $(this) .find('.btn-ok') .attr('href')+'</strong>');
    });
</script>
</body>
</html>