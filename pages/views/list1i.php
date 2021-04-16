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
	
$sql="SELECT count(*) as num FROM maealma WHERE voboalma in ('S','N') ".$aux;
$cont = $db->prepare($sql);
$cont->execute();
$r = $cont->fetch(PDO::FETCH_ASSOC);	
$total=$r['num'];

if ($total==0){
  echo "<script type='text/javascript'>alert('No Existen Datos.\nIntroduzca otro parametro de Busqueda')";
  echo "document.location='formsrcprev.php'</script>";
  exit;
}

$sql="SELECT skip $inicio first $registros * FROM maealma WHERE voboalma in ('S','N') ".$aux." ";
$sql.="ORDER BY 1,2 ";
$query = $db->prepare($sql);
$query->execute();
$tpaginas = ceil($total/$registros);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Listado de Documentos</title>
    <? include("inc/header.php") ?>
    <!-- Custom Codigo JavaScript -->
    <script src="../js/list1i.js"></script> 
    <style>
      .pagination{
        margin:0px 0;
      }
    </style>
  </head>

  <body>
    <div id="wrapper"> 
      <!-- Navigation -->
      <? include("inc/navprincipal.php") ?>
      <div id="page-wrapper">
        <? while($row = $query->fetch(PDO::FETCH_ASSOC)) { 
        $g = $row['gestion'];
        $d = $row['dcto'];
        $n = $row['nro'];
        ?>
        <div class="row">
          <div class="col-lg-12">
            <h2 class="page-header">Preventivos
            <div class='pull-right'>
              <div class='btn-group' role="group">
                <a href="#" class="btn btn-default btn_edit <?=verpermiso($_SESSION['sialmausr'],'Editar',$g,$d,$n)?>"><span class="fa fa-edit"></span>&nbsp;Editar</a>
                <a href="#" class="btn btn-default <?=verpermiso($_SESSION['sialmausr'],'Detalle',$g,$d,$n)?>" data-toggle="modal" data-target=".modaldetalle"><span class="fa fa-list"></span>&nbsp;Detalle</a>
                <a href="#" class="btn btn-default <?=verpermiso($_SESSION['sialmausr'],'Eliminar',$g,$d,$n)?>" data-toggle="modal" data-target=".modaldelete"><span class="fa fa-eraser"></span>&nbsp;Eliminar</a>
                <a href="#" class="btn btn-default <?=verpermiso($_SESSION['sialmausr'],'Vobo',$g,$d,$n)?>" data-toggle="modal" data-target=".modalvobo"><span class="fa fa-check-circle"></span>&nbsp;Vo.bo.</a>
                <a href="#" class="btn btn-default <?=verpermiso($_SESSION['sialmausr'],'Gloaux',$g,$d,$n)?>" data-toggle="modal" data-target=".modalgloaux"><span class="fa fa-comment-o"></span>&nbsp;Glosa Aux.</a>
                <a href="#" class="btn btn-default <?=verpermiso($_SESSION['sialmausr'],'Comision',$g,$d,$n)?>" data-toggle="modal" data-target=".modalgenconta"><span class="fa fa-exchange"></span>&nbsp;Gen. Contab.</a>
                <a href="../pdfsialma.php?g=<?=$row['gestion']?>&n=<?=$row['nro']?>&i=<?=$row['idprev']?>&t=<?=$row['tipo']?>" class="btn btn-default" target="_blank"><span class="fa fa-print"></span>&nbsp;Imprimir</a>
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
                          <input name="txtgest" type="text" class="form-control llaves" id="txtgest" value="<?=$row['gestion']?>">
                        </div>
                        <label class="col-lg-1 control-label">Tipo.Doc</label>
                        <div class="col-lg-3">
                          <input name="txtdcto" type="text" class="form-control llaves" id="txtdcto" value="<?=$row['dcto']?>">
                        </div>
                        <label class="col-lg-1 control-label">Nro.Doc</label>
                        <div class="col-lg-3">
                          <input name="txtnro" type="text" class="form-control llaves" id="txtnro" value="<?=$row['nro']?>">
                        </div>
                      </div>
                    </div>
                    <!-- /.col-lg-12 (nested) -->
                    <div class="col-lg-12">
                      <div class="form-group">
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
                          <input name="txthtd" type="text" class="form-control" id="txthtd" maxlength="8" required>
                        </div>
                        <label class="col-lg-1 control-label">Doc.Conta.</label>
                        <div class="col-lg-3">
                          <div class="input-group">
                            <input name="txtdctoconta" id="txtdctoconta" type='text' class='form-control' placeholder="Dcto" maxlength="2" value="<?=trim($row['dcto_c'])?>"/>
                          <div class='input-group-field'>
                            <input name="txtnroconta" id="txtnroconta" type='text' class='form-control' placeholder="Nro" value="<?=$row['nro_c']?>"/>
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
                          <input name="txtglosa" type="text" class="form-control" maxlength="100" id="txtglosa" value="<?=htmlspecialchars(trim($row['glosa']))?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-1 control-label">Reparticion</label>
                        <div class="col-lg-11">
                          <div class="input-group">
                            <input name="txtrepar" type="text" class="form-control" id="txtrepar" value="<?=brepar($row['codrep'])?>">
                            <span class="input-group-btn">
                              <button class="btn btn-default enlacerepar" type="button"><i class="fa fa-search"></i>
                              </button>
                            </span>
                          </div>
                          <input type="hidden" name="hdnrepar" id="hdnrepar" value="<?=trim($row['codrep'])?>">
                        </div>
                      </div>
                    </div>
                    <!-- /.col-lg-12 (nested) -->
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="col-lg-1 control-label">Empresa</label>
                        <div class="col-lg-4">
                          <input name="txtemp" type="text" class="form-control" id="txtemp" maxlength="50" value="<?=htmlspecialchars(trim($row["obs1"]))?>">
                        </div>
                        <label class="col-lg-1 control-label">Factura</label>
                        <div class="col-lg-2">
                          <input name="txtfact" type="text" class="form-control" id="txtfact" maxlength="25" value="<?=trim($row['obs2'])?>">
                        </div>
                        <label class="col-lg-1 control-label">Fuente</label>
                        <div class="col-lg-3">
                          <select name="cboffin" id="cboffin" class="form-control" required>
                          </select>
                          <input type="hidden" name="hdnselffin" id="hdnselffin" value="<?=$row['fte']?>">
                        </div>
                      </div>
                    </div>
                    <!-- /.col-lg-12 (nested) -->
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="col-lg-1 control-label">Solicitado.Por</label>
                        <div class="col-lg-7">
                          <input name="txtsolpor" type="text" class="form-control" id="txtsolpor" maxlength="50" value="<?=htmlspecialchars(trim($row['ref1']))?>" required>
                        </div>
                        <label class="col-lg-1 control-label">Pedido</label>
                        <div class="col-lg-3">
                          <input name="txtpedi" type="text" class="form-control" id="txtpedi" maxlength="10" value="<?=trim($row['ref2'])?>">
                        </div>
                      </div>
                    </div>
                    <!-- /.col-lg-12 (nested) -->
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="col-lg-1 control-label">Cotizado.por</label>
                        <div class="col-lg-7">
                          <input name="txtcotpor" type="text" class="form-control" id="txtcotpor" maxlength="50" value="<?=trim($row['ref3'])?>">
                        </div>
                        <label class="col-lg-1 control-label">Tip.Per.</label>
                        <div class="col-lg-3">
                          <select name="cbotiper" id="cbotiper" class="form-control" required>
                          </select>
                          <input type="hidden" name="hdnseltiper" id="hdnseltiper" value="<?=$row['codtip']?>">
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
        $sqldet="SELECT * FROM detalma WHERE gestion='".$row['gestion']."' AND dcto='".$row['dcto']."' AND nro='".$row['nro']."' ";
        $sqldet.="ORDER BY id";
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
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Almacen</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">P.U.</th>
                        <th scope="col">Monto</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <? while($rowdet = $qrydet->fetch(PDO::FETCH_ASSOC)) { 
                      $c++;
                      ?>
                      <tr class="copy">
                        <td width="25%">
                          <div class="input-group">
                            <input type="hidden" name="hdncodalm[]" id="hdncodalm_<?=$c?>" class="hdncodalm" value="<?=$rowdet['codalm']?>"/>
                            <input class="form-control input-sm txtalm" id="txtalm_<?=$c?>" value="<?=balm($rowdet['codalm'])?>" data-toggle="tooltip" data-placement="left" title="<?=$rowdet['codalm']?>" readonly/>
                            <span class="input-group-btn">
                              <button class="btn btn-sm btn-default enlacealm" type="button"><i class="fa fa-search"></i>
                              </button>
                            </span>
                          </div>
                        </td>
                        <td width="28%">
                          <div class="input-group">
                            <input type="hidden" name="hdncodprod[]" id="hdncodprod_<?=$c?>" class="hdncodprod" value="<?=$rowdet['codprod']?>"/>
                            <input class="form-control input-sm txtprod" id="txtprod_<?=$c?>" value="<?=bprod($rowdet['codprod'])?>" data-toggle="tooltip" data-placement="left" title="<?=$rowdet['codprod']?>" readonly/>
                            <span class="input-group-btn">
                              <button class="btn btn-sm btn-default enlaceprod" type="button"><i class="fa fa-search"></i>
                              </button>
                            </span>
                          </div>
                        </td>
                        <td width="15%"><input name="txtcant[]" class="form-control input-sm txtcant" maxlength="12" value="<?=$rowdet['dcant']?>" /></td>
                        <td width="15%"><input name="txtpu[]" class="form-control input-sm txtpu" maxlength="18" value="<?=$rowdet['pu']?>" /></td>
                        <td width="15%"><input name="txtmonto[]" class="form-control input-sm txtmonto" readonly /></td>
                        <td width="2%" align="center">
                        <?  
                        if($c<cuentadet($row['gestion'],$row['dcto'],$row['nro'])){ 
                          echo '<a class="del"><span class="fa fa-minus fa-2x"></span></a>';
                        }else{
                          echo '<a class="add"><span class="fa fa-plus fa-2x"></span></a>';
                        } 
                        ?>
                        </td>
                      </tr>
                      <? } ?> 
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
        <!-- MODAL ELIMINAR DOCUMENTO -->
        <div class="modal fade modaldelete" tabindex="-1" role="dialog" aria-labelledby="ModalConfirmacion" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h3>Confirmaci&oacute;n</h3>
              </div>
              <div class="modal-body">
                Esta seguro de Eliminar el Documento?
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
        <div class="modal fade modalvobo" tabindex="-1" role="dialog" aria-labelledby="modalvobo" aria-hidden="true">
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
        <div class="modal fade modalgenconta" tabindex="-1" role="dialog" aria-labelledby="modalgenconta" aria-hidden="true">
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
              <li class="<?=$disableprev?>"><a href="list1i.php?pagina=<?="0".$link;?>"><span aria-hidden="true">&larr;</span> Primero</a></li>
              <li class="<?=$disableprev?>"><a href="list1i.php?pagina=<?=($pagina-1).$link;?>">Anterior</a></li>
              <li class="<?=$disablenext?>"><a href="list1i.php?pagina=<?=($pagina+1).$link;?>">Siguiente</a></li>
              <li class="<?=$disablenext?>"><a href="list1i.php?pagina=<?=$tpaginas.$link;?>">Ultimo <span aria-hidden="true">&rarr;</span></a></li>
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
