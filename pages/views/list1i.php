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
//var_dump($_GET["pagina"]);

if(isset($_GET["pagina"])==null){
    $pagina = 0;
}
    else{
        $pagina = $_GET["pagina"];
    }

//$pagina = $_GET["pagina"];

//echo $pagina;

if (!$pagina) { 
	$inicio = 0; 
	$pagina = 1; 
} 
else { 
	$inicio = ($pagina - 1) * $registros; 
}
	
$sql="SELECT count(*) as num FROM maealma WHERE voboalma in ('S','N') ".$aux;
// $sql = "SELECT count(*) as num FROM maealma WHERE gestion=2021";
$cont = $db->prepare($sql);
$cont->execute();
$r = $cont->fetch(PDO::FETCH_ASSOC);	
$total=$r['num'];

if ($total==0){
  echo "<script type='text/javascript'>alert('No Existen Datos.\nIntroduzca otro parametro de Busqueda');";
  echo "document.location='formsrcprev.php'</script>";
  ?>
  <script type="text/javascript">alert('No existen Datos');window.history.back();</script>
  <?
  exit;
}

$sql="SELECT skip $inicio first $registros * FROM maealma WHERE voboalma in ('S','N') ".$aux." ";
// $sql = "SELECT skip $inicio first $registros * FROM maealma WHERE gestion=2021";
$sql.="ORDER BY 1,2 ";
$query = $db->prepare($sql);
$query->execute();
//echo $sql;
$tpaginas = ceil($total/$registros);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Listado de Documentos</title>
    <? include("inc/header.php") ?>
    <!-- Custom Codigo JavaScript -->
    <script src="../js/list1i.js" charset="UTF-8"></script>
    <style>
      .pagination{
        margin:0px 0;
      }
      button.btn-volver{
        float: right;
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
        $glosa22=$row['glosa'];
        ?>
        <div class="row">
          <div class="col-lg-12">
              <h2 class="page-header">Ingreso Almacen <?
                  //echo $_SESSION['sialmausr'];
                  //$_SESSION["sialmagalm"]
                  //echo  $_SESSION["sialmarol"];
                  $dcto_c=$row['dcto_c'];
                  $nro_c=$row['nro_c'];
                  $voboalma=$row['voboalma'];
                  if(is_null($dcto_c) && is_null($nro_c)){
                      //echo "valor voboalma: ".$row['voboalma']."<br>";
                      //echo "valor dctoc: ".$row['dcto_c']." es nulo <br>";
                      //echo "valor nro_c: ".$row['nro_c']." es nulo <br>";
                  }else {
                      //echo "valor voboalma: ".$row['voboalma']."<br>";
                      //echo "valor dctoc: ".$row['dcto_c']." no es nulo <br>";
                      //echo "valor nro_c: ".$row['nro_c']." no es nulo <br>";
                  }
                  $sqldet2="SELECT * FROM detalma WHERE gestion='".$row['gestion']."' AND dcto='".$row['dcto']."' AND nro='".$row['nro']."' ";
                  $sqldet2.="ORDER BY id";
                  $qrydet2 = $db->prepare($sqldet2);
                  $qrydet2->execute();
                  $rowdet2 = $qrydet2->fetch(PDO::FETCH_ASSOC);
                  if(!empty($rowdet2)){
                      $dcto_m=$rowdet2['dcto_m'];
                      $nro_m=$rowdet2['nro_m'];
                  }else{
                      $dcto_m=null;
                      $nro_m=null;
                  }
                  if(is_null($dcto_m) && is_null($nro_m)){
                      //echo "valor dctom: ".$dcto_m." no existe registro <br>";
                      //echo "valor nro_m: ".$nro_m." no existe registro <br>";
                  }else {
                      //echo "valor dctom: ".$rowdet2['dcto_m']." existe registro <br>";
                      //echo "valor nro_m: ".$rowdet2['nro_m']." existe registro <br>";
                  }

                  $sqldet3="SELECT count(*) as num FROM  detalma WHERE gestion='2020' AND dcto_m='".$row['dcto']."' AND nro_m='".$row['nro']."' and dcto in(";
                  $sqldet3.="select cod from paramdctoalma where cod[1]='".$row['dcto'][0]."' and aceo[2]='S')";
                  $qrydet3 = $db->prepare($sqldet3);
                  $qrydet3->execute();
                  $r3 = $qrydet3->fetch(PDO::FETCH_ASSOC);
                  $total=$r3['num'];
                  //echo $sqldet3;
                  //echo $total;
//                    select cod from paramdctoalma where cod[1]='D' and aceo[2]='S'
            ?>
            <div class='pull-right'>
              <div class='btn-group' role="group">
                <a href="#" class="btn btn-default btn_edit <?=verpermiso($r3['num'],$row['voboalma'],$row['dcto_c'],$row['nro_c'],$_SESSION['sialmausr'],'Editar',$g,$d,$n,$row['dcto_c'])?>"><span class="fa fa-edit"></span>&nbsp;Editar</a>
                <a href="#" class="btn btn-default <?=verpermiso($r3['num'],$row['voboalma'],$row['dcto_c'],$row['nro_c'],$_SESSION['sialmausr'],'Detalle',$g,$d,$n)?>" data-toggle="modal" data-target=".modaldetalle"><span class="fa fa-list"></span>&nbsp;Detalle</a>
                <a href="#" class="btn btn-default <?=verpermiso($r3['num'],$row['voboalma'],$row['dcto_c'],$row['nro_c'],$_SESSION['sialmausr'],'Eliminar',$g,$d,$n)?>" data-toggle="modal" data-target=".modaldelete"><span class="fa fa-eraser"></span>&nbsp;Eliminar</a>
                <a href="#" class="btn btn-default <?=verpermiso($r3['num'],$row['voboalma'],$row['dcto_c'],$row['nro_c'],$_SESSION['sialmausr'],'Vobo',$g,$d,$n)?>" data-toggle="modal" data-target=".modalvobo"><span class="fa fa-check-circle"></span>&nbsp;Vo.bo.</a>
                <a href="#" class="btn btn-default <?=verpermiso($r3['num'],$row['voboalma'],$row['dcto_c'],$row['nro_c'],$_SESSION['sialmausr'],'Gloaux',$g,$d,$n)?>" data-toggle="modal" data-target=".modalauxglosa"><span class="fa fa-comment-o"></span>&nbsp;Glosa Aux.</a>
                <a href="#" class="btn btn-default <?=verpermiso($r3['num'],$row['voboalma'],$row['dcto_c'],$row['nro_c'],$_SESSION['sialmausr'],'Gencontab',$g,$d,$n)?>" data-toggle="modal" data-target=".modalgenconta"><span class="fa fa-exchange"></span>&nbsp;Gen. Contab.</a>
                  <a href="../reportes/reporte1i.php?documento=<?=base64_encode($row['dcto'].','.$row['nro'].','.$row['gestion'])?>" class="btn btn-default" target="_blank"><span class="fa fa-print"></span>&nbsp;Imprimir</a>
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
                        <label class="col-lg-1 control-label">Fecha:</label>
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
                          <input name="txthtd" type="text" class="form-control" id="txthtd" maxlength="8" value="<?=($row['ref4'])?>" required>
                        </div>
                        <label class="col-lg-1 control-label">Doc.Conta.</label>
                        <div class="col-lg-3">
                          <div class="input-group">
                            <input name="txtdctoconta" id="txtdctoconta" type='text' class='form-control llaves' placeholder="Dcto" maxlength="2" value="<?=trim($row['dcto_c'])?>"/>
                          <div class='input-group-field'>
                            <input name="txtnroconta" id="txtnroconta" type='text' class='form-control llaves' placeholder="Nro" value="<?=$row['nro_c']?>"/>
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
<!--            prueba-->
            <?
            $sqldet="SELECT * FROM glosalma WHERE gestion='".$row['gestion']."' AND dcto='".$row['dcto']."' AND nro='".$row['nro']."' ";
//            $sqldet="SELECT * FROM glosalma";
//            $sqldet.="ORDER BY id";
            $qrydet = $db->prepare($sqldet);
            $qrydet->execute();
            $rowglosa = $qrydet->fetch(PDO::FETCH_ASSOC);
//            $qrydet = $db->prepare($sqldet);
//            $qrydet = $qrydet->execute();
//            while($rowglosa = $qrydet->fetch(PDO::FETCH_ASSOC)) {
//                $g = $rowglosa['gestion'];
//                $d = $rowglosa['dcto'];
//                $n = $rowglosa['nro'];
//                $gloaux=$rowglosa['gloaux'];
//            }
            ?>
            <!-- MODAL GLOSAUX -->
            <div id="modalauxglosa1" class="modal fade modalauxglosa" tabindex="-1" role="dialog" aria-labelledby="ModalAuxglosa" aria-hidden="true">
                <form role="form" class="form-horizontal auxglosa">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3>Glosa Auxiliar</h3>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">

                                    </div>
                                    <!-- /.col-lg-12 (nested) -->

                                    <!-- /.col-lg-12 (nested) -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Detalle</label>

                                            <div class="col-lg-11">
                                                <input name="gloaux" type="text" class="form-control" maxlength="100" id="gloaux" value="<?=$rowglosa==null?'':trim($rowglosa['gloaux'])?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-lg-12 (nested) -->
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success btn_saveauxglosa">Guardar</button>
                                    <button type="button" class="btn btn-danger btn_canceldesc" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
<!--            fin prueba-->
        <?                                                
        $sqldet="SELECT * FROM detalma WHERE gestion='".$row['gestion']."' AND dcto='".$row['dcto']."' AND nro='".$row['nro']."' ";
        $sqldet.="ORDER BY id";
        $qrydet = $db->prepare($sqldet);
        $qrydet->execute();
        //echo $sqldet;
        ?>
        <!-- MODAL DETALLE -->
        <div class="modal fade modaldetalle" tabindex="-1" role="dialog" aria-labelledby="ModalDetalle" aria-hidden="true">
          <form role="form" class="form-horizontal detalle">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h3>Detalle <?
//                      echo $row['dcto'];
//                      echo "<br>";
//                      echo $row['dcto'];
//                      echo "<br>";
                      ?></h3>
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
                      <?
                      $c=0;
                      while($rowdet = $qrydet->fetch(PDO::FETCH_ASSOC)) {
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
                      <? }
//                      $sqldet2="SELECT * FROM detalma WHERE gestion='".$row['gestion']."' AND dcto='".$row['dcto']."' AND nro='".$row['nro']."' ";
//                      $sqldet2.="ORDER BY id";
//                      $qrydet2 = $db->prepare($sqldet2);
//                      $qrydet2->execute();
//                      $rowdet2 = $qrydet2->fetch(PDO::FETCH_ASSOC);
                      //echo $rowdet2;
                      if(empty($rowdet2)){

                      ?>
                      <tr class="copy">
                          <td width="25%">
                              <div class="input-group">
                                  <input type="hidden" name="hdncodalm[]" id="hdncodalm_<?=$c?>" class="hdncodalm" />
                                  <input class="form-control input-sm txtalm" id="txtalm_<?=$c?>"  data-toggle="tooltip" data-placement="left" title="<?=$rowdet['codalm']?>" readonly/>
                                  <span class="input-group-btn">
                              <button class="btn btn-sm btn-default enlacealm" type="button"><i class="fa fa-search"></i>
                              </button>
                            </span>
                              </div>
                          </td>
                          <td width="28%">
                              <div class="input-group">
                                  <input type="hidden" name="hdncodprod[]" id="hdncodprod_<?=$c?>" class="hdncodprod" />
                                  <input class="form-control input-sm txtprod" id="txtprod_<?=$c?>"  data-toggle="tooltip" data-placement="left" title="<?=$rowdet['codprod']?>" readonly/>
                                  <span class="input-group-btn">
                              <button class="btn btn-sm btn-default enlaceprod" type="button"><i class="fa fa-search"></i>
                              </button>
                            </span>
                              </div>
                          </td>
                          <td width="15%"><input name="txtcant[]" class="form-control input-sm txtcant" maxlength="12"  /></td>
                          <td width="15%"><input name="txtpu[]" class="form-control input-sm txtpu" maxlength="18"  /></td>
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
//        $sqldesc="SELECT * FROM descsigep WHERE gestion='".$row['gestion']."' AND nro='".$row['nro']."' AND idprev='".$row['idprev']."' AND tipo='".$row['tipo']."'";
        //$sqldesc="SELECT * FROM descsigep WHERE gestion='".$row['gestion']."' AND nro='".$row['nro']."'";
        $sqldesc="SELECT * FROM maealma WHERE gestion='".$row['gestion']."' AND nro='".$row['nro']."'  AND dcto='".$row['dcto']."'";
        $qrydesc = $db->prepare($sqldesc);
        $qrydesc->execute();
        $rd = $qrydesc->fetch(PDO::FETCH_ASSOC);	
        ?>
        <!-- MODAL DESCARGO -->
        <div id="modalvobo" class="modal fade modalvobo" tabindex="-1" role="dialog" aria-labelledby="modalvobo" aria-hidden="true">
            <form role="form" class="form-horizontal estado">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Aprobacion del Documento</h3>
                        </div>
                        <div class="modal-body">
                            <label class="col-lg-1 control-label">Estado:</label>
                            <!--  <input type="hidden" name="hdnselest" id="hdnselest" value="<?=$row['codest']?>"> -->
                            <select name="cboest" id="cboest" class="form-control" required>
                                <option value='S' <? if($rd['voboalma']=='S') echo 'Selected'; ?> >SI</option>
                                <option value='N' <? if($rd['voboalma']=='N') echo 'Selected'; ?>>NO</option>
                            </select>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn_guardaest">Guardar</button>
                                <button type="button" class="btn btn-danger btn_cancelest" data-dismiss="modal">Cancelar</button>
                            </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <?                                                
//        $sqlpyv="SELECT * FROM pyvsigep WHERE gestion='".$row['gestion']."' AND nro='".$row['nro']."' AND idprev='".$row['idprev']."' AND tipo='".$row['tipo']."'";
//        $sqlpyv="SELECT * FROM pyvsigep WHERE gestion='".$row['gestion']."' AND nro='".$row['nro']."'";
            $sqlpyv="SELECT * FROM maealma WHERE gestion='".$row['gestion']."' AND nro='".$row['nro']."'  AND dcto='".$row['dcto']."'";
        $qrypyv = $db->prepare($sqlpyv);
        $qrypyv->execute();
        $rpv = $qrypyv->fetch(PDO::FETCH_ASSOC);	
        ?>
            <!-- MODAL PASAJES Y VIATICOS BOTON GEN CONTAB-->
        <div id="modalgenconta" class="modal fade modalgenconta" tabindex="-1" role="dialog" aria-labelledby="modalgenconta" aria-hidden="true">
            <form role="form" class="form-horizontal genconta">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Generar Documento Contable</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-lg-5 mb-1">
                                    <div class="form-group">
                                        <label id="dcto_c">Documento Contable:</label>
                                        <input type="txt" class="form-control" name="dcto_c" id="dcto_c" value="<?=trim($row['dcto_c'])?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-5 mb-1">
                                        <label id="nro_c">Nro Documento Contable:</label>
                                        <input type="txt" class="form-control" name="nro_c" id="nro_c" value="<?=$row['nro_c']?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success btn_guardagenconta">Guardar</button>
                            <button type="button" class="btn btn-danger btn_cancelpyv" data-dismiss="modal">Cancelar</button>
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
          <button type="button" onclick="location.href='formsrc1i.php?transac=C'" class="btn btn-lg btn-primary btn-volver">Volver</button>

        </nav>

      </div>
      <!-- /#page-wrapper --> 
    </div>
    <!-- /#wrapper --> 
  </body>
</html>
