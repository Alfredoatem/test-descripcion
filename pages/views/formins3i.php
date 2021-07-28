<?php 
/************************************************/
/*DESARROLLADO POR	:	ING. JOSE LEDO REBOLLO  */
/*FECHA				:	02/05/2020 	 */
/*CELULAR			:	70614112		 */
/*LUGAR				:	MINDEFENSA - LA PAZ*/
/************************************************/
include "../seguridad.php";
include "../../connections/connect.php";
include "../../functions/global.php";
?>
<!DOCTYPE html>
<html>
<head>

<title>Registrar</title>
<? include("inc/header.php") ?>
    <!-- Codigo JavaScript -->
    <script src="../js/globalform.js"></script>
    <!-- Custom Codigo JavaScript -->
    <script>
        $(function(){
            // $(".txtcant,.txtpu,.txtmonto,#monto").css('text-align','right').number(true,2,'.','');
            $(".txtcant,.txtpu,.txtmonto, #monto").css('text-align','right');
            $(".txtcant").number(true,2,'.','');
            $(".txtpu").number(true,7,'.','');
            enlace();
        });
    </script>
    <script src="../js/formins3i.js"></script>
<!--    <script src="../js/list1i.js" charset="UTF-8"></script>-->


</head>

<body>
<div id="wrapper"> 
 <!-- Navigation -->
 <? include("inc/navprincipal.php") ?>
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h2 class="page-header">Registro de Ingreso en Almacen</h2>
      </div>
      <!-- /.col-lg-12 --> 
    </div>
    <!-- /.row -->
    <div class="row">
      <form role="form" class="form-horizontal registro" id="form">
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
                      <input name="txtgest" class="form-control llaves" id="txtgest" value="<?=date('Y')?>" readonly>
                    </div>
                    <label class="col-lg-1 control-label">Tipo.Doc</label> 
                    <div class="col-lg-3">
                      <input maxlength="2" name="txtdcto" class="form-control llaves" id="txtdcto" value="" required>
                    </div>
                    <label class="col-lg-1 control-label">Nro.Doc</label>
                    <div class="col-lg-3">
                      <input name="txtnro" class="form-control llaves" id="txtnro" maxlength="1" required>
                    </div>
                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Fecha</label>
                    <div class="col-lg-3">
                            <div class='input-group' id='txtfecha'>
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
                        <input name="txtdctoconta" id="txtdctoconta" type='text' class='form-control' placeholder="Dcto" readonly/>
                      <div class='input-group-field'>
                        <input name="txtnroconta" id="txtnroconta" type='text' class='form-control' placeholder="Nro" readonly/>
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
                                <input name="txtrepar" type="text" class="form-control" id="txtrepar" value="" readonly>
                                <span class="input-group-btn">
                              <button class="btn btn-default enlacerepar" type="button" ><i class="fa fa-search"></i>
                              </button>
                            </span>
                            </div>
                            <input type="hidden" name="hdnrepar" id="hdnrepar" value="">
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-1 control-label">Empresa</label>
                    <div class="col-lg-4">
                      <input name="txtemp" class="form-control" id="txtemp" maxlength="50" required>
                    </div>
                    <label class="col-lg-1 control-label">Factura</label>
                    <div class="col-lg-2">
                      <input name="txtfact" class="form-control" id="txtfact" maxlength="25" required>
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
                      <input name="txtsolpor" class="form-control" id="txtsolpor" maxlength="50" required>
                    </div>

                  </div>
                </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                  <div class="form-group">
                      <label class="col-lg-1 control-label">Cotizado.Por.</label>
                      <div class="col-lg-7">
                          <input name="txtcotpor" class="form-control" id="txtcotpor" maxlength="50" required>
                      </div>
                    <label class="col-lg-1 control-label">Tipo.Per.</label>
                      <div class="col-lg-3">
                          <select name="cbotiper" id="cbotiper" class="form-control" required>
                          </select>
                          <input type="hidden" name="hdnseltiper" id="hdnseltiper" value="<?=$row['codtip']?>">
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
                        <th scope="col">Almacen</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">P.U.</th>
                        <th scope="col">Monto</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr class="copy">
                            <td width="25%">
                                <div class="input-group">
                                    <input type="hidden" name="hdncodalm[]" class="hdncodalm" />
                                    <input name="txtalm[]" class="form-control input-sm txtalm"   data-toggle="tooltip" data-placement="left" title="" readonly/>
                                    <span class="input-group-btn">
                              <button class="btn btn-sm btn-default enlacealm" type="button"><i class="fa fa-search"></i>
                              </button>
                            </span>
                                </div>
                            </td>
                            <td width="28%">
                                <div class="input-group">
                                    <input type="hidden" name="hdncodprod[]"  class="hdncodprod" />
                                    <input name="txtprod[]" class="form-control input-sm txtprod"  data-toggle="tooltip" data-placement="left" title="" readonly/>
                                    <span class="input-group-btn">
                              <button class="btn btn-sm btn-default enlaceprod" type="button"><i class="fa fa-search"></i>
                              </button>
                            </span>
                                </div>
                            </td>
                            <td width="15%"><input name="txtcant[]" class="form-control input-sm txtcant" maxlength="12" /></td>
                            <td width="15%"><input name="txtpu[]" class="form-control input-sm txtpu" maxlength="18"  /></td>
                            <td width="15%"><input name="txtmonto[]" class="form-control input-sm txtmonto" readonly /></td>
                            <td width="2%" align="center">
                                <a class="add"><span class="fa fa-plus fa-2x"></span></a>
                            </td>
                        </tr>
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
            <!-- /.panel-body --> 
          </div>
          <!-- /.panel -->

            <div class="col-lg-12">
                <div class="form-group">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-lg btn-success btn_guardaregistro">Guardar</button>
<!--                        <input type="button" onclick="location.href='../views/formsrc1i.php';" class="btn btn-lg btn-primary" value="Buscar">-->
                        <button type="reset" class="btn btn-lg btn-danger">Limpiar</button>
                    </div>
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
