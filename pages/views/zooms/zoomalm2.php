<?php 
require_once "../../../connections/connect.php";
require_once "../../../functions/global.php";

$criterio = "";

if(isset($_GET["txtalm"])==null){
    $txtalm = '';
}
else{
    $txtalm = $_GET["txtalm"];
}

if ($txtalm!=''){
	$txtalm=mb_strtoupper($_GET['txtalm']);
	$criterio .= "AND des matches '*$txtalm*' ";
}
$registros = 5;

if(isset($_GET["pagina"])==null){
    $pagina = 0;
}
else{
    $pagina = $_GET["pagina"];
}


if (!$pagina) { 
	$inicio = 0; 
	$pagina = 1; 
}else{ 
	$inicio = ($pagina - 1) * $registros; 
}

$sql = "SELECT count(*) as num FROM paramalmacen WHERE 1=1 ".$criterio;
$cont = $db->prepare($sql);
$cont->execute();
$r = $cont->fetch(PDO::FETCH_ASSOC);
$total=$r['num'];

$sql = "SELECT skip $inicio first $registros * FROM paramalmacen WHERE 1=1 ".$criterio;
$sql .= "ORDER BY 1 ";
$query = $db->prepare($sql);
$query->execute();
$tpaginas = ceil($total/$registros);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Zoom Almacen</title>
<!-- Bootstrap Core CSS -->
<link href="../../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="../../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
<!-- Custom Fonts -->
<link href="../../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  
<link href="../../../resources/scripts/ui/jquery-ui.custom.css" rel="stylesheet"  type="text/css" />
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- jQuery  -->
<script src="../../../vendor/jquery/jquery.min.js"></script> 
<script language="JavaScript" src="../../../resources/scripts/ui/jquery-ui.custom.js" type="text/javascript"></script>
<!-- Bootstrap Core JavaScript --> 
<script src="../../../vendor/bootstrap/js/bootstrap.min.js"></script> 
<style>
  .container{
    margin-top: 20px;
  }
  .pagination{
	  margin:0px 0;
  }
</style>
<script type='text/javascript'>
$(function(){
    $('.sel').click(function(){
        var index = $('.sel').index(this);
        var valor = $('.codigo:eq('+index+')').text();
        var indice = $('#indice').val();
        var clase = '.hdncodalm:eq('+indice+')';
        window.opener.$(clase).val(valor).focusin();
        self.close();
    })
    $('.pagination .disabled a, .pagination .active a').on('click', function(e) {
        e.preventDefault();
    });
});
</script>
</head>

<body>
  <div class="container">
    <form role="form" class="form-horizontal" method="get" action="zoomalm.php">
      <div class="form-group">
        <div class="col-lg-12">
          <div class="input-group">
            <input name="txtalm" class="form-control" placeholder="Almacen">
            <span class="input-group-btn">
              <button class="btn btn-primary" type="submit">Buscar</button>
            </span>
            <input type="hidden" name="indice" id="indice" value="<?=$_GET['indice']?>"/>
          </div>
        </div>
      </div>
    </form>
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr class="bg-primary">
          <th scope="col" width="15%">Cod.</th>
          <th scope="col" width="70%">Repartición</th>
          <th scope="col" width="15%"></th>
        </tr>
      </thead>
      <tbody>
        <? while($row = $query->fetch(PDO::FETCH_ASSOC)) {?>
        <tr>
          <td height="25" class="codigo"><?=trim($row['cod'])?></td>
          <td><?=trim($row['des'])?></td>
          <td align="center"><a href="#" class="sel"><span class="fa fa-check-circle-o"></span></a></td>
        </tr>
        <?
        }
        ?>
      </tbody>
    </table>
    <nav aria-label="Page navigation">
      <ul class="pagination">
      <?
      if($tpaginas > 1) {
        $link = "&txtalm=$txtalm&indice=".$_GET['indice'];
        $disableprev = (($pagina - 1)>0)?"":"disabled";
        $disablenext = (($pagina + 1)<=$tpaginas)?"":"disabled";
        ?>
          <li class="<?=$disableprev?>"><a href="zoomalm2.php?pagina=<?="0".$link;?>"><span aria-hidden="true">&larr;</span> Primero</a></li>
          <li class="<?=$disableprev?>"><a href="zoomalm2.php?pagina=<?=($pagina-1).$link;?>">Anterior</a></li>
          <li class="<?=$disablenext?>"><a href="zoomalm2.php?pagina=<?=($pagina+1).$link;?>">Siguiente</a></li>
          <li class="<?=$disablenext?>"><a href="zoomalm2.php?pagina=<?=$tpaginas.$link;?>">Ultimo <span aria-hidden="true">&rarr;</span></a></li>
        <? 
      }
      ?>
      </ul>
    </nav>
  </div>
</body>
</html>
