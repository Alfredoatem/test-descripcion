<?
/************************************************/
/*DESARROLLADO POR	:	ING. JOSE LEDO REBOLLO  */
/*FECHA				:	02/05/2020 	 */
/*CELULAR			:	70614112		 */
/*LUGAR				:	MINDEFENSA - LA PAZ*/
/************************************************/
include "../seguridad.php";
include "../../connections/connect.php";
include "../../functions/global.php";

$criterio='';

if($_POST){	
	$txtgest=$_POST['txtgest'];
	$txtdcto=$_POST['txtdcto'];
	$txtnro=$_POST['txtnro'];
	$txtfini=$_POST['txtfini'];
  $txtffin=$_POST['txtffin'];
	$txtglosa=$_POST['txtglosa'];
	$hdnrepar=$_POST['hdnrepar'];
  $cboffin=$_POST['cboffin'];
	$txtsolpor=$_POST['txtsolpor'];
	$txtresp=$_POST['txtresp'];
  $txtci=$_POST['txtci'];
  $txtnota=$_POST['txtnota'];
  $cbotiper=$_POST['cbotiper'];
  
	if($txtgest!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a gestion = '".$txtgest."' ";
	}
	if($txtdcto!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a dcto = '".$txtdcto."' ";
	}
	if($txtnro!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a nro = '".$txtnro."' ";
	}
  if($txtfini!="" && $txtffin!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a fecha between '".$txtfini."' and '".$txtffin."' ";
	}
  if($txtdctoconta!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a dcto_c = '".$txtdctoconta."' ";
	}
	if($txtnroconta!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a nro_c = '".$txtnroconta."' ";
	}
	if($txtglosa!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a glosa matches '*".$txtglosa."*' ";
	}
	if($hdnrepar!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a codrep = '".$hdnrepar."' ";
	}
  if($cboffin!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a fte = '".$cboffin."' ";
	}
  if($txtsolpor!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a obs1 matches '".$txtsolpor."*' ";
	}
  if($txtresp!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a ref1 matches '".$txtresp."*' ";
	}
  if($txtci!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a ref2 matches '".$txtci."*' ";
	}
  if($txtnota!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a ref3 matches '".$txtnota."*' ";
	}
  if($cbotiper!=""){
		$a = ($criterio=='')?'':" AND ";
		$criterio .= " $a codtip = '".$cbotiper."' ";
	}
	
	header('Location:formres1i.php?criterio='.base64_encode($criterio));	
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Buscar Documento</title>
    <? include("inc/header.php") ?>
    <!-- Custom Codigo JavaScript -->
    <script src="../js/formsrc3s.js"></script> 
  </head>

  <body>
    <div id="wrapper"> 
      <!-- Navigation -->
      <? include("inc/navprincipal.php") ?>
      <div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Busqueda <?=bdctoalma($_SESSION['sialmagalm'].$_GET['transac'])?></h3>
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
                          <input name="txtdcto" class="form-control llaves" id="txtdcto" value="<?=$_SESSION['sialmagalm'].$_GET['transac']?>" readonly>
                        </div>
                        <label class="col-lg-1 control-label">Nro.Doc</label>
                        <div class="col-lg-3">
                          <input name="txtnro" class="form-control llaves" id="txtnro" maxlength="5">
                        </div>
                      </div>
                    </div>
                    <!-- /.col-lg-12 (nested) -->
                    <div class="col-lg-12">
                      <div class="form-group">
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
                        <label class="col-lg-1 control-label">Doc.Conta.</label>
                        <div class="col-lg-3">
                          <div class="input-group">
                            <input name="txtdctoconta" id="txtdctoconta" type='text' class='form-control' placeholder="Dcto" maxlength="2" />
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
                          <input name="txtglosa" class="form-control" maxlength="100" id="txtglosa">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-1 control-label">Reparticion</label>
                        <div class="col-lg-11">
                          <div class="input-group">
                            <input name="txtrepar" class="form-control" id="txtrepar" disabled>
                            <span class="input-group-btn">
                              <button class="btn btn-default enlacerepar" type="button"><i class="fa fa-search"></i>
                              </button>
                            </span>
                          </div>
                          <input type="hidden" name="hdnrepar" id="hdnrepar">
                        </div>
                      </div>
                    </div>
                    <!-- /.col-lg-12 (nested) -->
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="col-lg-1 control-label">Solicitado.Por</label>
                        <div class="col-lg-5">
                          <input name="txtsolpor" class="form-control" id="txtsolpor" maxlength="50" >
                        </div>
                        <label class="col-lg-1 control-label">Responsable</label>
                        <div class="col-lg-5">
                          <input name="txtresp" class="form-control" id="txtresp" maxlength="50" >
                        </div>
                      </div>
                    </div>
                    <!-- /.col-lg-12 (nested) -->
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="col-lg-1 control-label">Nro.CI.</label>
                        <div class="col-lg-5">
                          <input name="txtci" class="form-control" id="txtci" maxlength="10">
                        </div>

                        <label class="col-lg-1 control-label">Nota</label>
                        <div class="col-lg-5">
                          <input name="txtnota" class="form-control" id="txtnota" maxlength="50" >
                        </div>
                      </div>
                    </div>
                    <!-- /.col-lg-12 (nested) -->
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="col-lg-1 control-label">Fuente</label>
                        <div class="col-lg-5">
                          <select name="cboffin" id="cboffin" class="form-control" required>
                          </select>
                        </div>
                        <label class="col-lg-1 control-label">Tip.Per.</label>
                        <div class="col-lg-5">
                          <select name="cbotiper" id="cbotiper" class="form-control" >
                          </select>
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
              <!-- /.panel -->   
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
