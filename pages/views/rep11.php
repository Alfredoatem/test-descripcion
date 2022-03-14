<?
/************************************************/
/*DESARROLLADO POR	:	ING. JOSE LEDO REBOLLO  */
/*FECHA				:	02/05/2020 	 */
/*CELULAR			:	70614112		 */
/*LUGAR				:	MINDEFENSA - LA PAZ*/
/************************************************/
//include "../pages/seguridad.php";
include "../../connections/connect.php";
include "../../functions/global.php";

$criterio='';
if($_POST){	
    $txtfini=$_POST['txtfini'];
    $txtfini2=$_POST['txtfini2'];
    $dcto=$_POST['dcto'];//nocon
    $fechadep=$_POST['fechadep']; 
    $codcon=$_POST['codcon'];
    $codcta=$_POST['codcta'];
    $repar=$_POST['repar'];
    /*Orden de Reporte*/
    //$cborden=$_POST['cborden']; //1,2  

    if($txtfini!="" ){
      //$a = ($criterio=='')?'':" AND ";
      $criterio .= " and i.fecha_v<= '".$txtfini."' ";
    }

    if($txtfini2!="" ){
      //$a = ($criterio=='')?'':" AND ";
      $criterio .= " and i.fecha_dep<= '".$txtfini2."' ";
    }

    if($dcto!=""){
      $a = ($criterio=='')?'':" AND ";
      $criterio .= " $a i.dcto = '".$dcto."' ";
    }
  
    if($codcon!=""){
      $a = ($criterio=='')?'':" AND ";
      $criterio .= " $a i.codcon = '".$codcon."' ";
    }  

    if($codcta!=""){
      $a = ($criterio=='')?'':" AND ";
      $criterio .= " $a i.codcta = '".$codcta."' ";
    } 
    if($repar!=""){
      $a = ($criterio=='')?'':" AND ";
      $criterio .= " $a i.repar = '".$repar."' ";
    } 

  	header('Location:rep1a.php?criterio='.base64_encode($criterio).'&codcon='.$codcon.'&frep='.$txtfini);	
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
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
<link href="../../vendor/bootstrap-multiselect/bootstrap-multiselect.css" rel="stylesheet" type="text/css">  

<script src="../../vendor/jquery/jquery.min.js"></script> 
<script language="JavaScript" src="../../resources/scripts/form/jquery.number.js" type="text/javascript"></script>
<script language="JavaScript" src="../../resources/scripts/form/jquery.alphanumeric.js" type="text/javascript"></script>
<script language="JavaScript" src="../../resources/scripts/form/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script language="JavaScript" src="../../resources/scripts/popup.js" type='text/javascript'></script>

<script src="../../vendor/moment-with-locales.js"></script>
<!-- Bootstrap Core JavaScript --> 
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../../vendor/bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"></script>
<script src="../../vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<!-- Metis Menu Plugin JavaScript --> 
<script src="../../vendor/metisMenu/metisMenu.min.js"></script> 
<!-- Custom Theme JavaScript --> 
<script src="../../resources/scripts/sb-admin-2/js/sb-admin-2.js"></script>
  
<script type="text/javascript">

$(function(){
  /*Funciones de Maestro*/

  $('#txtfi').datetimepicker({
    locale: 'es',
    format: 'L',
    minDate: moment("01/01/2021"),
    maxDate: moment(),
    useCurrent: false,
    defaultDate: moment("01/01/2021")
  });
  $('#txtfi2').datetimepicker({
    locale: 'es',
    format: 'L',
    minDate: moment(""),
    maxDate: moment(),
    useCurrent: false,
    defaultDate: moment("01/01/2021")
  });
  
 
});
</script>
</head>

<body>
<div id="wrapper"> 
  
  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-brand" href="#">Reporte por mes a fecha de Verificacion</a>
    </div>
    <? include("inc/menuh.php") ?>
        
    <? include("inc/menuv.php") ?>
  </nav>
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h3 class="page-header">Ingresos por Meses a Fecha de Verificaci&oacute;n</h3>
      </div>
      <!-- /.col-lg-12 --> 
    </div>
    <!-- /.row -->
    <div class="row">
      <form role="form" class="form-horizontal" action="rep1.php" method="POST" target="_blank">
        <div class="col-lg-12">
          <div class="panel panel-primary">
            <div class="panel-heading">Criterios de Reporte</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-lg-1 control-label">Fecha de Verificaci&oacute;n: </label>
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class='input-group date' id='txtfi'>
                                                <input type='text' class="form-control" name="txtfini"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-lg-1 control-label">Fecha de Dep&oacute;sito: </label>
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class='input-group date' id='txtfi2'>
                                                <input type='text' class="form-control" name="txtfini2"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-lg-1 control-label">Dcto.:</label>
                                <div class="col-lg-3">
                                    <input name="txtdcto" class="form-control llaves" id="txtdcto" type="text" maxlength="1" value="">
                                </div>
                            </div>
                        </div>
                <!-- /.col-lg-12 (nested) -->
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-lg-1 control-label">Codigo de concepto:</label>
                        <div class="col-lg-3">
                                <input name="txtdcto" class="form-control llaves" id="txtdcto" maxlength="5" value="">
                        </div>
                        <label class="col-lg-1 control-label">Codigo de cuenta:</label>
                        <div class="col-lg-3">
                            <input name="txtcodcta" class="form-control llaves" id="txtcodcta" maxlength="6" value="">
                        </div>
                        <label class="col-lg-1 control-label">Codigo de repartición:</label>
                        <div class="col-lg-3">
                            <input name="txtrepar" class="form-control llaves" id="txtrepar" maxlength="6" value="">
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
    <table class="table table-striped">
        <?
        $fil1=$POST['txtfini'];
        $fil2=$POST['txtfini2'];
        $fil3=$POST['txtdcto'];
        $fil4=$POST['txtcodcon'];
        $fil5=$POST['txtcodcta'];
        $fil6=$POST['txtrepar'];

        //if ($fil1 != '' AND $fil2 == '' AND $fil3 == '' AND $fil4 == '' AND $fil5 == '' AND $fil6 == ''){
          //  $where = "WHERE fecha_v <= '2021-01-08' and i.codcon=c.cod and month(i.fecha_v)=2";
        //}

//        $sql = "SELECT i.codcon, c.des ,sum(i.monto) enero FROM ingteso i, conpre21:conceing c WHERE c.cod=i.codcon  and month(i.fecha_v)=1 group by codcon, des order by 1,2";
        $sql = "SELECT i.codcon as codigo, c.des as descripcion, sum(i.monto) enero FROM ingteso i, conpre21:conceing c WHERE i.codcon = c.cod and month(i.fecha_v)=1 GROUP BY codcon, descripcion ORDER BY 1,2";
        $query = $db->prepare($sql);
        $query->execute();
        $sql2 = "SELECT i.codcon as codigo, c.des as descripcion, sum(i.monto) febrero FROM ingteso i, conpre21:conceing c WHERE i.codcon = c.cod and month(i.fecha_v)=2 GROUP BY codcon, descripcion ORDER BY 1,2";
        $query2 = $db->prepare($sql2);
        $query2->execute();
        //$sql2 = "SELECT i.codcon, c.des ,sum(i.monto) febrero FROM ingteso i, conpre21:conceing c WHERE c.cod=i.codcon and month(i.fecha_v)=2 group by codcon, des order by 1,2";
        //$query2 = $db->prepare($sql2);
        //$query2->execute();
        ?>
    <thead>
      <tr>
        <th>CODIGO</th>
        <th>DESCRIPCI&Oacute;N</th>
        <th>ENERO</th>
        <th>FEBRERO</th>
        <th>MARZO</th>
        <th>ABRIL</th>
        <th>MAYO</th>
        <th>JUNIO</th>
        <th>JULIO</th>
        <th>AGOSTO</th>
        <th>SEPTIEMBRE</th>
        <th>OCTUBRE</th>
        <th>NOVIEMBRE</th>
        <th>DICIEMBRE</th>
        <th>TOTAL</th>
      </tr>
    </thead>
    <tbody>
    <?
        $cont=0;
        $cont2=0;
        //$cont2=0;
        $dir=array();
        $dir2=array();
        $dir3=array();
        $dir4=array();
        $dir5=array();
        while($row2 = $query2->fetch(PDO::FETCH_ASSOC)) {
          $cont2=$cont2+1;
        }
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
          $dir[$cont]=$row['codigo'];
          $dir2[$cont]=$row['descripcion'];
          $dir3[$cont]=$row['enero'];          
          $cont=$cont+1;
          //$cont2=$cont2+1;
        }
      
        //hola como estas informatica
        /*$dir4=array();
        while($row2 = $query2->fetch(PDO::FETCH_ASSOC)){
          $dir4[$cont]=$row2['febrero'];
          $cont=$cont+1;
        }*/
        
    ?>
    
      <tr>
        <td><?foreach($dir as $valor){
          echo $valor;
          echo "<br>";
          }?></td>
        <td><?foreach($dir2 as $valor2){
          echo $valor2;
          echo "<br>";
        }?></td>
        <td>
          <?foreach($dir3 as $valor3){
            echo $valor3;
            echo "<br>";
            }?>
        </td>
        <td>
          <?foreach($dir4 as $valor4){
            echo $valor4;
            echo "<br>";
            }?>
        </td>
      </tr> 
      
      <?//}
      echo $cont2-($cont2-1);?> 
    </tbody>
  </table>
    <!-- /.row --> 
  </div>
  <!-- /#page-wrapper 5--> 
  
</div>
<!-- /#wrapper --> 
</body>
</html>
