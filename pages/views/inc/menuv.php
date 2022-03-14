<script>
$(function(){
  $.ajax({
    type : 'POST',
    url : "../ajax/ajaxtransac.php",
    success : function(html){
      $("#transac").html(html);
    }
  });
});
</script>
<div class="navbar-default sidebar" role="navigation">
  <div class="sidebar-nav navbar-collapse">
    <ul class="nav" id="side-menu">
      <!--<li role="presentation" class="disabled"><a href="#"><?=buseralma($_SESSION["usrins"],$_SESSION["usrins"])?></a></li>-->
      <li> <a href="#"><i class="fa fa-home fa-fw"></i> Inicio</a> </li>
      <li> <a href="#"><i class="fa fa-archive fa-fw"></i> Transacciones<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level" >
        <!--<li> <a href="/teso/pages/views/buscar4.php"> BUSCAR </a> </li>-->
        
        <li> <a href="/teso/pages/views/listaingreso2.php"> REGISTRAR </a> </li>
        <li> <a href="/teso/pages/views/index.php"> GENERAL </a> </li>
        <li> <a href="/teso/pages/views/indexing.php"> (I) INGRESOS </a> </li>
        <li> <a href="/teso/pages/views/indexreg.php"> (R) REVERSIONES </a> </li>
        <li> <a href="/teso/pages/views/indextgn.php"> (T) TGN </a> </li>
        <li> <a href="/teso/pages/views/indexret.php"> (E) RETENCIONES </a> </li>
        <li> <a href="/teso/pages/views/indexgp.php"> (H) GESTIONES PASADAS </a> </li>
        <li> <a href="/teso/pages/views/indexmul.php"> (M) MULTAS </a> </li>
        <li> <a href="/teso/pages/views/indexbni.php"> (P) BONOS NO IDENT. </a> </li>
        <li> <a href="/teso/pages/views/indexdgp.php"> (G) DEPOSITOS GEST. PAS. </a> </li>
        <li> <a href="/teso/pages/views/indexdgp18.php"> (D) DEPOSITOS GEST. PAS. 2018</a> </li>  
        </ul>
        <!-- /.nav-second-level --> 
      </li>
      <li> <a href="#"><i class="fa fa-tasks fa-fw"></i> Reportes<span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li> <a href="/teso/pages/views/rep11.php">Reporte por Fec. Verif.</a> </li>
            <li> <a href="/teso/pages/views/rep2.php">Reporte por ffin.</a> </li>
            <li> <a href="/teso/pages/views/rep3.php">Reporte por caja</a> </li>
          </ul>
        <!-- /.nav-second-level --> 
      </li>
      <li> <a href="#"><i class="fa fa-folder fa-fw"></i> Parametros<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <li> <a href="#"> Productos</a> </li>
          <li> <a href="#"> Tipos de Almacenes</a> </li>
        </ul>
        <!-- /.nav-second-level --> 
      </li>
      <!---->
      <li> <a href="../../formupdpass.php"><i class="fa fa-key fa-fw"></i> Cambiar Contrase&ntilde;a</a></li>
      <li> <a href="../../logout.php"><i class="fa fa-sign-out fa-fw"></i>Salir</a></li>
    </ul>
  </div>
  <!-- /.sidebar-collapse --> 
</div>