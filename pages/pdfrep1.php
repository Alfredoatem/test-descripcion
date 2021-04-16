<? 
/************************************************/
/*DESARROLLADO POR	:	ING. JOSE LEDO REBOLLO  */
/*FECHA				:	02/05/2020 	 */
/*CELULAR			:	70614112		 */
/*LUGAR				:	MINDEFENSA - LA PAZ*/
/************************************************/
ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
ini_set('memory_limit', '512M');

include "seguridad.php";
require('../resources/phps/fpdf/fpdf.php');
require('../resources/phps/fpdf/pdftable/pdftable.inc.php');
include('../connections/connect.php');
include('../functions/global.php');

if(trim($_GET['cripart'])!=''){
  $cripart = "AND".base64_decode($_GET['cripart']);
}

if(trim($_GET['criterio'])!=''){
  $criterio = "WHERE".base64_decode($_GET['criterio']);
}else{
	echo "<script>alert('Seleccione Criterio de Busqueda')</script>";
	exit;
}

class PDF extends PDFTable{
	function Header(){
		parent::Header();
		$this->SetFont('Arial','B',6);
		$this->SetMargins(15,10,15,15);
		$this->SetXY(15,10);
    
		$encabezado='
    <table border=0 cellpadding=1>
			<tr>
				<td width=50 size=7 style="bold" align="center">MINISTERIO DE DEFENSA</td>
				<td width=235 size=7 style="bold" align="right">Fecha Imp.:</td>
				<td width=20 size=7 style="bold" align="right">'.date('d/m/Y').'</td>
			</tr>
		</table>';
    $this->htmltable($encabezado,1);
		
		$encabezado='
    <table border=0 cellpadding=1>
      <tr>
				<td width=50 size=7 style="bold" align="center">UNIDAD FINANCIERA</td>
				<td width=235 size=7 style="bold" align="right">Hora :</td>
        <td width=20 size=7 style="bold" align="right">'.date('H:i:s').'</td>
			</tr>
		</table>';
    $this->SetXY(15,13);
    $this->htmltable($encabezado,1);
    
    $encabezado='
    <table border=0 cellpadding=1>
      <tr>
				<td width=50 size=7 style="bold" align="center">La Paz - Bolivia</td>
				<td width=235 size=7 style="bold" align="right"></td>
        <td width=20 size=7 style="bold" align="right"></td>
			</tr>
		</table>';
    $this->SetXY(15,16);
    $this->htmltable($encabezado,1);
    
    $titulo='
    <table border=0 cellpadding=1>
      <tr>
				<td width=305 size=10 style="bold" align="center">ESTADO DE PREVENTIVOS Y SUS DESCARGOS SIGEP</td>
			</tr>
		</table>';
    $this->SetXY(15,14);
    $this->htmltable($titulo,1);
    
		$this->SetLineWidth(0.1);
		$this->Line(15,22,320,22);
    
		$encabezado='
		<table border=1>
			<tr>
				<td width=10 style="bold" height="6" size=5 border=0></td>
				<td width=10 style="bold" size=5>No.</td>
				<td width=15 style="bold" size=5>FECHA</td>
				<td width=90 style="bold" size=5>GLOSA</td>
				<td width=15 style="bold" align="right" size=5>GESTION</td>
				<td width=20 style="bold" align="right" size=5>PREVENTIVO</td>
				<td width=15 style="bold" align="right" size=5>ID</td>
        <td width=20 style="bold" align="right" size=5>ESTADO</td>
				<td width=30 style="bold" align="right" size=5>MONTO CARGO</td>
				<td width=30 style="bold" align="right" size=5>MONTO DESCARGO</td>
				<td width=30 style="bold" align="right" size=5>SALDO</td>
				<td width=20 style="bold" align="right" size=5>USUARIO</td>
			</tr>
		</table>';
		$this->SetXY(15,25);
		$this->htmltable($encabezado);
	}
	function Footer(){
		$this->SetY(-12);
		$this->SetFont('Arial','I',6);
		$this->Cell(305,7,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$sql = "SELECT * FROM (";
$sql.= "select m.scta, s.des, m.fecha, m.glosa[1,70] glosa, m.gestion, m.nro,m.idprev, m.usr_upd,m.tipo, ";
$sql.= "(case when c.estado is null then 'S' else c.estado end) estado,revisor,sum(monto) monto, ";
$sql.= "sum(case when c.estado is null then 0 else (monto) end) descargo ";
$sql.= "from maesigep m ";
$sql.= "inner join detsigep d on d.gestion = m.gestion and d.nro = m.nro and d.idprev=m.idprev and d.tipo=m.tipo ";
$sql.= "inner join conpre20:sctas s on s.cod=m.scta ";
$sql.= "left outer join descsigep c on c.gestion = m.gestion and c.nro = m.nro and c.idprev=m.idprev and c.tipo = m.tipo ";
$sql.= "where estprev='C' AND (c.estado<>'X' or c.estado is null) ".$cripart;
$sql.= "group by 1,2,3,4,5,6,7,8,9,10,11 ";
$sql.= ") ".$criterio." ORDER BY des ";

$pdf=new PDF();
$pdf->FPDF('L','mm',array(216,330));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',5,true);
$pdf->SetMargins(15,10,15,15);

$p = $db->query($sql)->fetchAll(PDO::FETCH_GROUP);

$c = 0;
$ttcargo=0;
$ttdescargo=0;
$nc = 0;

foreach($p as $scta => $v){
  $nc++;
	$tcargo = 0;
	$tdescargo = 0;
	
	$pdf->SetFont('Arial','B',5,true);
	$pdf->Cell(305,5,trim($scta)." - ".bscta($scta),0,1,'L',false);

  foreach($v as $fila => $csig){
    $c++;
    $saldo = ($csig['estado']=='O')?$csig['monto']:($csig['monto']-$csig['descargo']);
    $pdf->SetFont('Arial','',5,true);
    $pdf->Cell(10,3,'',0,0,'L');
    $pdf->Cell(10,3,$c,0,0,'L');
    $pdf->Cell(15,3,newdate($csig['fecha']),0,0,'L');
    $pdf->Cell(90,3,$csig['glosa'],0,0,'L');
    $pdf->Cell(15,3,$csig['gestion'],0,0,'R');
    $pdf->Cell(20,3,$csig['nro'],0,0,'R');
    $pdf->Cell(15,3,$csig['idprev'],0,0,'R');
    $pdf->Cell(20,3,$csig['estado'],0,0,'R');
    $pdf->Cell(30,3,number_format($csig['monto'],2),0,0,'R');
    $pdf->Cell(30,3,number_format($csig['descargo'],2),0,0,'R');
    $pdf->Cell(30,3,number_format($saldo,2),0,0,'R');
    $pdf->Cell(20,3,$csig['usr_upd'],0,1,'L');
    
    $tcargo = $tcargo + $csig['monto'];
    if($csig['estado']=='R' or $csig['estado']=='A' or $csig['estado']=='D')
      $tdescargo = $tdescargo + $csig['descargo'];
  }
  $pdf->SetFont('Arial','B',5,true);
  $pdf->Cell(10,3,$nc,0,0,'L');
  $pdf->Cell(10,3,'','T',0,'R');
  $pdf->Cell(175,3,'TOTAL CUENTADANTE:','T',0,'R');
  $pdf->Cell(30,3,number_format($tcargo,2),'T',0,'R');
  $pdf->Cell(30,3,number_format($tdescargo,2),'T',0,'R');
  $pdf->Cell(30,3,number_format(($tcargo-$tdescargo),2),'T',0,'R');
  $pdf->Cell(20,3,'','T',1,'R');

  $ttcargo = $ttcargo + $tcargo;
  $ttdescargo = $ttdescargo + $tdescargo;
}
$pdf->Cell(10,3,'','T',0,'R');
$pdf->Cell(185,3,'TOTALES:','T',0,'R');
$pdf->Cell(30,3,number_format($ttcargo,2),'T',0,'R');
$pdf->Cell(30,3,number_format($ttdescargo,2),'T',0,'R');
$pdf->Cell(30,3,number_format(($ttcargo-$ttdescargo),2),'T',0,'R');
$pdf->Cell(20,3,'','T',1,'R');


$pdf->Output('prev_y_des.pdf','I');
unset($pdf);
?>