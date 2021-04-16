<script type="text/javascript">
$(function(){
  $("#cambialma").click(function(){
    $.ajax({
      type : 'POST',
      url : "../ajax/ajaxselalma.php",
      success : function(html){
        location.reload();
      }
    });
  });
});
</script>

<ul class="nav navbar-top-links navbar-right">
  <li><div><i class="fa fa-users fa-fw"></i> <?=$_SESSION["sialmanombre"]?></div></li>
  <!-- /.dropdown -->
  <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i> </a>
    <ul class="dropdown-menu dropdown-user">
      <li><a href="#" id="cambialma"><i class="fa fa-user fa-fw"></i> Cambiar Almacen</a> </li>
      <li><a href="../../formupdpass.php"><i class="fa fa-gear fa-fw"></i> Contrase&ntilde;a</a> </li>
      <li class="divider"></li>
      <li><a href="../../logout.php"><i class="fa fa-sign-out fa-fw"></i> Salir</a> </li>
    </ul>
    <!-- /.dropdown-user --> 
  </li>
  <!-- /.dropdown -->
</ul>
