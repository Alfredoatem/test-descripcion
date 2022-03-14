<?php
$gestion = 2021;

/*CAMBIA FORMATO DE FECHA*/
function newdate($fecha){
	$nf = ($fecha!='')?date('d/m/Y',strtotime($fecha)):'';
	return $nf;
}

function newdatetime($fecha){
	$nf = ($fecha!='')?date('Y-m-d',strtotime($fecha)):'';
	return $nf;
}

function dateascii($fecha){
	$nf = ($fecha!='')?date('Ymd',strtotime($fecha)):'';
	return $nf;
}

function dias($fi,$ff){
	$dias	= (strtotime($fi)-strtotime($ff))/86400;
	$dias = abs($dias); $dias = floor($dias);		
	return $dias;
}

function desmes($mes){
	switch ($mes){
		case '01': $dmes = "Enero"; break;
		case '02': $dmes = "Febrero"; break;
		case '03': $dmes = "Marzo"; break;
		case '04': $dmes = "Abril"; break;
		case '05': $dmes = "Mayo"; break;
		case '06': $dmes = "Junio"; break;
		case '07': $dmes = "Julio"; break;
		case '08': $dmes = "Agosto"; break;
		case '09': $dmes = "Septiembre"; break;
		case '10': $dmes = "Octubre"; break;
		case '11': $dmes = "Noviembre"; break;
		case '12': $dmes = "Diciembre"; break;
	}
	return $dmes;
}

function cargo_estado($tipo){
	if($tipo=='O')
		return 'Observ.';
	elseif($tipo=='A')
		return 'Aproba.';
	elseif($tipo=='R')
		return 'En Rev.';
	elseif($tipo=='X')
		return 'Anulad.';
	elseif($tipo=='T')
		return 'Traspa.';
	elseif($tipo=='J')
		return 'Regula.';
	elseif($tipo=='D')
		return 'Dscto.';
	else
		return 'Sin Dscgo.';		
}

function reemplazo($var){
	$reemp=str_replace(",",".",$var);
	return $reemp;
}

function position($var){
	$inicio=strpos($var,'.');
	return $inicio;
}

/*-------------------------------------FUNCIONES DE BASE ---------------------------------------*/
function genid($col,$tb){
	global $db;
	$sql="SELECT max($col) num FROM $tb";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);	
	$n = $r['num']+1;
	return $n;
}

function cuentadet($g, $d, $n){
	global $db;
	$qry ="SELECT count(*) as num FROM detalma WHERE gestion='$g' AND dcto='$d' AND nro='$n' ";
	$r = $db->query($qry)->fetch(PDO::FETCH_ASSOC);	
	return $r['num'];	
}

function genidkar($g,$n,$i,$t){
	global $db;
	$sql="select nvl(max(id),0) idkar from kardesigep where gestion='$g' AND nro='$n' AND idprev='$i' AND tipo='$t'";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);	
	$n = $r['idkar']+1000;
	return $n;
}

function gencpbte($c){
	global $db;
	$qry = "SELECT max(ncont) num FROM maeconta WHERE dcont='$c'";
  $r = $db->query($qry)->fetch(PDO::FETCH_ASSOC);
	$n = $r['num']+1;
	return $n;
}

function verpermalma($user){
	global $db;
	$qry ="SELECT count(*) as num FROM permalma WHERE usuario = '".$user."' ";
	$r = $db->query($qry)->fetch(PDO::FETCH_ASSOC);	
	$val = ($r['num']>1)?1:0;
	return $val;	
}

function verdupli($user){
	global $db;
	$qry ="SELECT count(*) as num FROM usercargo WHERE usr_user='".$user."' ";
	$r = $db->query($qry)->fetch(PDO::FETCH_ASSOC);	
	$val = ($r['num']==1)?1:0;
	return $val;	
}

function verdescargo($g,$n,$i,$t){
	global $db;
	$qry ="SELECT count(*) as num FROM descsigep WHERE gestion='$g' AND nro='$n' AND idprev='$i' AND tipo='$t'";
	$r = $db->query($qry)->fetch(PDO::FETCH_ASSOC);
	$val = ($r['num']==1)?1:0;
	return $val;	
}
//prueba aux

function verglosaux($g,$d,$n){
    global $db;
//    $qry ="SELECT count(*) as num FROM descsigep WHERE gestion='$g' AND nro='$n' AND idprev='$i' AND tipo='$t'";
    $qry="SELECT count(*) as num FROM glosalma WHERE gestion='".$g."' AND dcto='".$d."' AND nro='".$n."' ";
    $r = $db->query($qry)->fetch(PDO::FETCH_ASSOC);
    $val = ($r['num']==1)?1:0;
    return $val;
}

function verestado($g,$n,$i,$t,$e){
	global $db;
	$qry ="SELECT count(*) as num FROM kardesigep WHERE gestion='$g' AND nro='$n' AND idprev='$i' AND tipo='$t' AND estado='$e'";
	$r = $db->query($qry)->fetch(PDO::FETCH_ASSOC);
	$val = ($r['num']>=1)?1:0;
	return $val;	
}

function verpasajes($g,$n){
	global $db;
	$qry ="SELECT count(*) as num FROM pyvsigep WHERE gestion='$g' AND nro='$n'";
	$r = $db->query($qry)->fetch(PDO::FETCH_ASSOC);
	$val = ($r['num']==1)?1:0;
	return $val;	
}

function verhtd($g,$n,$i,$t){
	global $db;
	$qry ="SELECT * FROM maesigep WHERE gestion='$g' AND nro='$n' AND idprev='$i' AND tipo='$t'";
	$r = $db->query($qry)->fetch(PDO::FETCH_ASSOC);
	$val = trim($r['htd']);
	return $val;	
}

function verpartpas($g,$n){
	global $db;
	$qry ="SELECT * FROM detsigep WHERE gestion='$g' AND nro='$n'";
  $p = $db->query($qry)->fetchAll(PDO::FETCH_ASSOC);
  $bandera = 0;
  foreach($p as $pyv){
    if(($pyv['part']=='221' || $pyv['part']=='222') && ($pyv['spart']=='10' || $pyv['part']=='20')){
      $bandera = 1;
    }
  }
	return $bandera;	
}

function verconta($d,$g,$n,$i,$t){
	global $db;
	$qry ="SELECT count(*) as num FROM maeconta WHERE dcont='$d' AND gestion='$g' AND nro='$n' AND idprev='$i' AND tipo='$t'";
	$r = $db->query($qry)->fetch(PDO::FETCH_ASSOC);
	$val = ($r['num']==1)?1:0;
	return $val;	
}

function vercodp($p){
	global $db;
	$qry ="SELECT count(*) as num FROM conpre21:sctas WHERE cod[1]='6' AND codp='".$p."' ";
	$r = $db->query($qry)->fetch(PDO::FETCH_ASSOC);	
	$val = ($r['num']>=1)?1:0;
	return $val;	
}

function verscta($s){
	global $db;
	$qry ="SELECT count(*) as num FROM conpre21:sctas WHERE cod='".$s."' ";
	$r = $db->query($qry)->fetch(PDO::FETCH_ASSOC);	
	$val = ($r['num']>=1)?1:0;
	return $val;	
}

function verpermiso($total,$vb,$d,$nc,$u,$m,$g=0,$n=0,$i=0,$t='N'){
	global $db;
	$qry ="SELECT count(*) as num FROM permisos WHERE programa='sialma' AND usuario='$u' AND menu='$m'";
    $r = $db->query($qry)->fetch(PDO::FETCH_ASSOC);
    //echo $qry;
    //echo $r['num']." ";
    // echo "ada".$total;
  if($_SESSION["sialmarol"]<>'admin'){
    if($r['num']>=1){
      if($m=="Vobo"){
          $val = "disabled";
      }
      elseif($m=="Detalle" || $m=="Eliminar"){
          if($vb=="S"){
              $val = "disabled";
          }
          elseif($d){
              $val = "disabled";
          }elseif( $nc){
              $val = "disabled";
          }elseif( $total>=1){
              $val = "disabled";
          }
          else{
              $val = "";
          }
      }elseif($m=="Editar" || $m=="Gloaux"){
          if($vb=="S"){
              $val = "disabled";
          }
          elseif( $d){
              $val = "disabled";
          }elseif( $nc){
              $val = "disabled";
          }else{
              $val = "";
          }
      }elseif($m=="Gencontab"){
          if($_SESSION["sialmarol"]=='conta'){
              $val = "";
          }
      }else{
        $val = "";
      }
    }else{
      $val = "disabled";
    }
  }else{
      //desde aca tn ontiveros
//      $val = $d;
      if($m=="Detalle" || $m=="Eliminar") {
          if ( $vb == "S" || isset($d) || isset($nc) || $total >= 1 ) {
              $val = "disabled";
        //   } elseif (isset($d)) {
        //       $val = "disabled";
        //   } elseif (isset($nc)) {
        //       $val = "disabled";
        //   } elseif( $total>=1){
        //       $val = "disabled";
          }else {
              $val = "";
          }
      }elseif($m=="Editar" || $m=="Gloaux"){
          if($vb=="S"){
              $val = "disabled";
          }
          elseif(isset($d)){
              $val = "disabled";
          }elseif(isset($nc)){
              $val = "disabled";
          }else{
              $val = "";
          }
      }elseif($m=="Vobo") {
              $val = "";
      }elseif($m=="Gencontab") {
          if ($_SESSION["sialmarol"] <> 'conta') {
              $val = "disabled";
          }
      }
  }
	return $val;	
}

function generacodigo(){
	global $db;
	$qry ="SELECT LPAD(IFNULL(MAX(SUBSTRING(codigo,3)),0)+1,6,'0') AS Num FROM productos";
	$p = $db->prepare($qry);
	$p->execute();
	$gencod = $p->fetch(PDO::FETCH_ASSOC);	
	$codgen = 'PR'.$gencod['Num'];
	return $codgen;
}

/*-------------------------------------------- FUNCIONES DE BUSQUEDA--------------------------------------------*/

function buseralma($u, $a){
	global $db;
  
  if($_SESSION["sialmarol"]=='admin'){
    $sql = "SELECT t.des tipo, g.cod codgranalma, g.des alma ";
    $sql.= "FROM paramgranalma g INNER JOIN paramtipoalma t on t.cod = g.codtipoalma ";
    $sql.= "WHERE g.cod = '$a'";
  }else{
    $sql = "SELECT t.des tipo, codgranalma, g.des alma FROM permalma a ";
    $sql.= "INNER JOIN paramgranalma g on g.cod = a.codgranalma ";
    $sql.= "INNER JOIN paramtipoalma t on t.cod = g.codtipoalma ";
    $sql.= "WHERE a.usuario = '$u' AND g.cod = '$a' ";  
  }

	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
	return trim($r['tipo'])."<br>".trim($r['alma'])."<br>Dcto: ".trim($r['codgranalma']);	
}

function bdctoalma($c){
	global $db;
	$sql="SELECT * FROM paramdctoalma WHERE cod='$c'";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
	return trim($r['des']);	
}

function brepar($r){
	global $db;
	$sql="SELECT * FROM paramrepar WHERE cod='$r'";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);	
	return trim($r['des']);	
}

function breubic($r){
	global $db;
	$sql="SELECT * FROM paramubic WHERE cod='$r'";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);	
	return trim($r['des']);	
}

function balm($a){
	global $db;
	$sql="SELECT * FROM paramalmacen WHERE cod='$a'";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);	
	return trim($r['des']);	
}

function bprod($p){
	global $db;
	$sql="SELECT * FROM conpre21:producto WHERE cod='$p'";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);	
	return trim($r['des']);	
}

function bunimed($p){
	global $db;
	$sql="SELECT * FROM conpre21:unimedid WHERE cod='$p'";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
	return trim($r['des']);	
}

function bpart($p){
	global $db;
	$sql="SELECT * FROM parampart WHERE cod='$p'";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
	return trim($r['des']);	
}

function bspart($a,$s){
	global $db;
	$sql="SELECT * FROM paramspart WHERE pcod='$a' AND cod='$s'";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
  $desc = ($s=='00')?bpart($a):trim($r['des']);
	return $desc;	
}

function bcta($p){
	global $db;
	$sql="SELECT * FROM conpre21:ctas WHERE cod='$p'";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
	return trim($r['des']);	
}

function bscta($p){
	global $db;
	$sql="SELECT * FROM conpre21:sctas WHERE cod='$p'";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);	
	return trim($r['des']);	
}

function bnotisig($g,$n,$i,$t){
	global $db;
	$sql="SELECT * FROM notisigep WHERE gestion='$g' AND nro='$n' AND idprev='$i' AND tiprev='$t'";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);	
	return trim($r['nrodoc']);	
}

function brevisor($g,$n,$i,$t){
  global $db;
	$sql ="select k.*,usr_nombre FROM kardesigep k INNER JOIN usuarios u on u.usr_revisor = k.revisor ";
  $sql.="WHERE gestion='$g' AND nro='$n' AND idprev='$i' AND tipo='$t' ";
  $sql.="AND id in (SELECT MAX(id) from kardesigep WHERE gestion='$g' AND nro='$n' AND idprev='$i' AND tipo='$t') ";
	$r = $db->query($sql)->fetch(PDO::FETCH_ASSOC);	
	return trim($r['usr_nombre']);	
}
/*--------------------------------------------COMBOS--------------------------------------------*/

function cbo_almaus($d=""){
	global $db;
	$qry ="select * from almacen order by 2";
	$p = $db->prepare($qry);
	$p->execute();
	$o="";
	while ($r = $p->fetch(PDO::FETCH_ASSOC)){
		$sel=($d==$r['id_alma'])?'Selected':'';
		$o.="<option value=\"".$r['id_alma']."\" $sel>".$r['nombre_alma']."</option>";
	}
	return $o;
}

?>