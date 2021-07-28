<?php
/************************************************/
/*DESARROLLADO POR	:	ING. JOSE LEDO REBOLLO  */
/*FECHA				:	27/02/2020 	 */
/*CELULAR			:	70614112		 */
/*LUGAR				:	MINDEFENSA - LA PAZ*/
/************************************************/
$sql = "select e.*,case when cant is null then 0 else cant end cant from (";
$sql.= "select gestion,cod,des from paramestado, (select unique gestion from maesigep WHERE estprev='C') ";
$sql.= ") e left outer join (";
$sql.= "select m.gestion, case when estado is null then 'S' else estado end est, count(*) cant ";
$sql.= "from maesigep m left outer join descsigep d on d.gestion = m.gestion and d.nro = m.nro and d.idprev = m.idprev and d.tipo = m.tipo ";
$sql.= "WHERE estprev='C' group by 1,2";
$sql.= ") g on g.est = e.cod and e.gestion = g.gestion ";
$sql.= "order by e.gestion,cod";

$p = $db->query($sql)->fetchAll(PDO::FETCH_GROUP);

$datoschart= "";
foreach($p as $anio => $v){
  $datoschart.= "{ anio: ".$anio.", ";
  $elementos = "";
  $cabecera = "";
  foreach($v as $fila => $csig){
    $elementos.= trim($csig['des']).":".$csig['cant'].", ";
    $cabecera.= "'".trim($csig['des'])."',";
  }
  $elementos = substr($elementos, 0, -2); 
  $datoschart.=$elementos. "}, ";
}
$datoschart = substr($datoschart, 0, -2);
$cabecera = substr($cabecera, 0, -1);
?>