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
      <li role="presentation" class="disabled"><a href="#"><?=buseralma($_SESSION["sialmausr"],$_SESSION["sialmagalm"])?></a></li>
      <li> <a href="../inicio.php"><i class="fa fa-home fa-fw"></i> Inicio</a> </li>
      <li> <a href="#"><i class="fa fa-archive fa-fw"></i> Transacciones<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level" id="transac">
        </ul>
        <!-- /.nav-second-level --> 
      </li>
      <li> <a href="#"><i class="fa fa-tasks fa-fw"></i> Reportes<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <li> <a href="../../formcrirep1.php"> Cargo y Descargo SIGEP</a> </li>
          <li> <a href="../../formcrirep2.php"> Cargo y Descargo SIGEP Fecha y Dias Transcurridos</a> </li>
          <li> <a href="../../formcrirep3.php"> Cargo y Descargo SIGEP Sin Agrupar</a> </li>
          <li> <a href="../../formcrirep4.php"> Cargo y Descargo SIGEP Incluye Notificacion</a> </li>
          <li> <a href="../../formcrirep5.php"> Cargo y Descargo SIGEP Por Fecha de Descargo</a> </li>
          <li> <a href="../../formcrirep6.php"> Cargo y Descargo SIGEP Pasajes y Viaticos</a> </li>
        </ul>
        <!-- /.nav-second-level --> 
      </li>
      <li> <a href="#"><i class="fa fa-folder fa-fw"></i> Parametros<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <li> <a href="../../listsctas.php"> Subcuentas</a> </li>
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
