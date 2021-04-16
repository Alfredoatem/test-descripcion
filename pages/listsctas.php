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

if ($_GET["txtbcod"]!='' || $_GET["txtbdes"]!='' || $_GET["txtbcodp"]!=''){
	$txtbcod=mb_strtoupper($_GET['txtbcod']);
	$txtbdes=mb_strtoupper($_GET['txtbdes']);
	$txtbcodp=mb_strtoupper($_GET['txtbcodp']);
  
  if($txtbcod!=""){
		$criterio .= " AND cod matches '".$txtbcod."*' ";
	}
  if($txtbdes!=""){
		$criterio .= " AND des matches '*".$txtbdes."*' ";
	}
  if($txtbcodp!=""){
		$criterio .= " AND codp matches '".$txtbcodp."*' ";
	}
}

$registros = 10;
$pagina = $_GET["pagina"];

if (!$pagina) { 
	$inicio = 0; 
	$pagina = 1; 
} 
else { 
	$inicio = ($pagina - 1) * $registros; 
}
	
$sql="SELECT count(*) as num FROM conpre20:sctas WHERE estado='A' ".$criterio;
$cont = $db->prepare($sql);
$cont->execute();
$r = $cont->fetch(PDO::FETCH_ASSOC);	
$total=$r['num'];

$sql="SELECT skip $inicio first $registros * FROM conpre20:sctas WHERE estado='A' ".$criterio." ";
$sql.="ORDER BY 2,1";
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
  $("form.scta").submit(function(e){
    e.preventDefault();
    if($("#hdnscta").first().val()=="" && $("#cbotscta").first().val()=='6'){
      $('#alertscta').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Debe Seleccionar el Cuentadante!!</div>');
      return false; 
    }else if($("#cbotscta").first().val()!='6' && $("#txtdes").first().val()==''){
      $('#alertscta').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Introduzca la Descripción!!</div>');
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
          $(".modalscta").modal('toggle');
        }else{
          $('#alertscta').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>');
        }
      }
    });
  });
  
  $('#message').on('close.bs.alert', function(){
    location.reload();
  }); 
  
  $(".btn_cancelscta").click(function(){
    location.reload();
  })
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
        <h2 class="page-header">Lista de Subcuentas
        <div class='pull-right'>
          <div class='btn-group' role="group">
            <a href="#" class="btn btn-default" data-toggle="modal" data-target=".modalscta"><span class="fa fa-plus-circle"></span>&nbsp;Adicionar</a>
          </div>
        </div>
        </h2>
      </div>     
      <!-- /.col-lg-12 --> 
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div id="message"></div>
        <div class="panel panel-primary">
          <div class="panel-heading">Busqueda de Subcuentas</div>
          <div class="panel-body">
            <form role="form" class="form-horizontal maestro" method="get">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <div class="col-lg-2">
                      <input name="txtbcod" class="form-control" id="txtbcod" placeholder="Codigo">
                    </div>
                    <div class="col-lg-6">
                      <input name="txtbdes" class="form-control" id="txtbdes" placeholder="Descripción">
                    </div>
                    <div class="col-lg-2">
                      <input name="txtbcodp" class="form-control" id="txtbcodp" placeholder="Codigo Papeleta">
                    </div>
                    <div class="col-lg-2">
                      <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
              </div>
            </form>
          </div>
        </div>
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <th scope="col" width="10%">C&oacute;digo</th>
              <th scope="col" width="50%">Descripci&oacute;n</th>
              <th scope="col" width="15%">C.I.</th>
              <th scope="col" width="15%">Cod.Per.</th>
              <th scope="col" width="10%">Fecha</th>
            </tr>
          </thead>
          <tbody>
            <? while($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
              <td ><?=trim($row['cod'])?></td>
              <td ><?=trim($row['des'])?></td>
              <td ><?=trim($row['cid'])?></td>
              <td ><?=trim($row['codp'])?></td>
              <td ><?=trim($row['mail'])?></td>
            </tr>
            <? } ?>
          </tbody>
        </table>
      </div>
      <!-- /.col-lg-12 -->
    </div>
    <nav aria-label="Page navigation">
      <ul class="pagination">
      <? 
      if($tpaginas > 1) {
        $link = "&txtbcod=$txtbcod&txtbdes=$txtbdes&txtbcodp=$txtbcodp";
        $disableprev = (($pagina - 1)>0)?"":"disabled";
        $disablenext = (($pagina + 1)<=$tpaginas)?"":"disabled";
        ?>
          <li class="<?=$disableprev?>"><a href="listsctas.php?pagina=<?="0".$link;?>"><span aria-hidden="true">&larr;</span> Primero</a></li>
          <li class="<?=$disableprev?>"><a href="listsctas.php?pagina=<?=($pagina-1).$link;?>">Anterior</a></li>
          <li class="<?=$disablenext?>"><a href="listsctas.php?pagina=<?=($pagina+1).$link;?>">Siguiente</a></li>
          <li class="<?=$disablenext?>"><a href="listsctas.php?pagina=<?=$tpaginas.$link;?>">Ultimo <span aria-hidden="true">&rarr;</span></a></li>
        <?
      }
      ?>
      </ul>
    </nav>
    <!-- MODAL ELIMINAR -->
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
    <!-- MODAL ADICIONAR SUBCUENTA -->
    <div class="modal fade modalscta" tabindex="-1" role="dialog" aria-labelledby="ModalScta" aria-hidden="true">
      <form role="form" class="form-horizontal scta">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h3>Adicionar Subcuenta</h3>
            </div>
            <div id="alertscta"></div>
            <div class="modal-body">
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
                    <label class="col-lg-1 control-label">Ult.Cod.</label>
                    <div class="col-lg-5">
                      <input name="txtucod" class="form-control" id="txtucod" disabled>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Descrip.</label>
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
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-danger btn_cancelscta">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- /#page-wrapper --> 
</div>
<!-- /#wrapper --> 
</body>
</html>
