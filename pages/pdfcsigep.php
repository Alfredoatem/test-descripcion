<?php
/************************************************/
/*DESARROLLADO POR	:	ING. JOSE LEDO REBOLLO  */
/*FECHA				:	02/05/2020 	 */
/*CELULAR			:	70614112		 */
/*LUGAR				:	MINDEFENSA - LA PAZ*/
/************************************************/
include "seguridad.php";
require "../resources/phps/n2l.php";
require "../resources/phps/fpdf/fpdf.php";
require "../resources/phps/fpdf/pdftable/pdftable.inc.php";
include "../connections/connect.php";
include "../functions/global.php";

$g = $_GET['g'];
$n = $_GET['n'];
$i = $_GET['i'];
$t = $_GET['t'];

if($g!='' && $n!='' && $i!='' && $t!=''){
}else{
	echo "<script>alert('Seleccione el Preventivo')</script>";
	exit;
}

class PDF extends PDFTable{
	function Header(){
		parent::Header();
    global $db;
		global $g;
		global $n;
		global $i;
    global $t;
		
		$this->SetFont('Arial','',7);
		$this->SetMargins(15,10,10);
		$this->SetXY(15,10);
	    
    $encabezado='
    <table border=0 cellpadding=1>
			<tr>
				<td width=50 size=8 style="bold" align="center">MINISTERIO DE DEFENSA</td>
				<td width=120 size=8 style="bold" align="right">Fecha Imp.:</td>
				<td width=20 size=8 style="bold" align="right">'.date('d/m/Y').'</td>
			</tr>
		</table>';
    $this->htmltable($encabezado,1);
    
    $encabezado='
    <table border=0 cellpadding=1>
      <tr>
				<td width=50 size=8 style="bold" align="center">UNIDAD FINANCIERA</td>
				<td width=120 size=8 style="bold" align="right">Preventivo :</td>
        <td width=20 size=8 style="bold" align="right">'.$n.'.'.$i.'</td>
			</tr>
		</table>';
    $this->SetXY(15,14);
    $this->htmltable($encabezado,1);
    
    $encabezado='
    <table border=0 cellpadding=1>
      <tr>
				<td width=50 size=8 style="bold" align="center">La Paz - Bolivia</td>
				<td width=120 size=8 style="bold" align="right">Gestion :</td>
        <td width=20 size=8 style="bold" align="right">'.$g.'</td>
			</tr>
		</table>';
    $this->SetXY(15,18);
    $this->htmltable($encabezado,1);
    
    $titulo='
    <table border=0 cellpadding=1>
      <tr>
				<td width=190 size=10 style="bold" align="center">CARGO DE CUENTA - SIGEP</td>
			</tr>
		</table>';
    $this->SetXY(15,14);
    $this->htmltable($titulo,1);
    
    $this->SetLineWidth(0.1);
		$this->Line(15,24,205,24);
    
    $qry = "SELECT m.*,estado,anexo FROM maesigep m  ";
    $qry.= "LEFT OUTER JOIN descsigep d ON d.gestion = m.gestion AND d.nro = m.nro AND d.idprev = m.idprev AND d.tipo = m.tipo ";
    $qry.= "WHERE m.gestion = '$g' AND m.nro = '$n' AND m.idprev = '$i' AND m.tipo = '$t'";

    $p = $db->prepare($qry);
    $p->execute();
    $m = $p->fetch(PDO::FETCH_ASSOC);
        
		$maestro='
		<table border=0>
			<tr>
				<td size=8 style="bold">FECHA</td>
				<td size=8 colspan="3">: '.newdate($m["fecha"]).'</td>
			</tr>
      <tr>
				<td size=8 style="bold">CUENTADANTE</td>
				<td size=8 colspan="3">: '.bscta($m["scta"]).'</td>
			</tr>
      <tr>
				<td size=8 style="bold">GLOSA</td>
				<td size=8 colspan="3">: '.$m["glosa"].'</td>
			</tr>
      <tr>
				<td size=8 style="bold">ANEXO</td>
				<td size=8 colspan="3">: '.$m["anexo"].'</td>
			</tr>
      <tr>
				<td width=25 size=8 style="bold">HTD</td>
				<td width=70 size=8>: '.$m["htd"].'</td>
				<td width=25 size=8 style="bold">US. REVISOR</td>
				<td width=70 size=8>: '.brevisor($g,$n,$i,$t).'</td>
			</tr>
      <tr>
				<td size=8 style="bold">FUENTE FINAN.</td>
				<td size=8>: '.$m["fte"].'</td>
				<td size=8 style="bold">ORG. FINANC.</td>
				<td size=8>: '.$m["orgfin"].'</td>
			</tr>
      <tr>
				<td size=8 style="bold">PROGRAMA</td>
				<td size=8>: '.$m["prog"].'</td>
				<td size=8 style="bold">PROYECTO</td>
				<td size=8>: '.$m["proy"].'</td>
			</tr>
      <tr>
				<td size=8 style="bold">ACTIVIDAD</td>
				<td size=8>: '.$m["act"].'</td>
				<td size=8 style="bold">ESTADO</td>
				<td size=8>: '.$m["estado"].'</td>
			</tr>
		</table>';
    $this->SetXY(15,27);
		$this->htmltable($maestro);
    $this->Ln(5);
    
    $this->SetFont('Arial','B',7,true);
    $this->Cell(80,6,'PARTIDA','TB',0,'C');
    $this->Cell(80,6,'SUB PARTIDA','TB',0,'C');
    $this->Cell(30,6,'MONTO','TB',1,'C');
	}
	function Footer(){
    $this->SetFont('Arial','I',8);
    $txt = "La Rendicion de Cuentas de los recursos y/o bienes descritos en el presente documento, ";
    $txt.= "deberan  ser  presentados  junto a la  Planilla de Rendicion de Cuentas la cual tiene ";
    $txt.= "caracter de declaracion jurada, siendo  de  absoluta  responsabilidad del Cuentadante ";
    $txt.= "la veracidad y autenticidad de la documentacion presentada como descargo.";
    $this->SetY(-40);
    $this->MultiCell(190,3,$txt,0,'J');
    
    $this->Ln(1);
    $aut = " A U T O R I Z A C I O N";
    $this->Cell(190,3,$aut,0,1,'C');
    $this->Ln(1);
    
    $txt = "Autorizo al Ministerio de Defensa, efectuar el descuento de mis haberes por incumplimiento ";
    $txt.= "en la presentacion de mis descargos, por los recursos y/o bienes recibidos dentro el plazo ";
    $txt.= "establecido en el Reglamento para la Rendicion de Cuentas en actual vigencia.";
    $this->MultiCell(190,3,$txt,0,'J');
    
		$this->SetY(-12);
		$this->SetFont('Arial','',8);
		$this->Cell(190,7,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$pdf=new PDF();
$pdf->FPDF('P','mm','Letter');

$pdf->AddPage();
$pdf->SetMargins(15,10,15);
$pdf->SetAutoPageBreak(true, 40);
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',7,true);

$qry = "SELECT * FROM detsigep WHERE gestion = '$g' AND nro = '$n' AND idprev = '$i' AND tipo = '$t' ";
$p = $db->prepare($qry);
$p->execute();

while($des = $p->fetch(PDO::FETCH_ASSOC)){
  $pdf->Cell(80,6,$des['part'].' '.bpart($des['part']),1,0,'L');
  $pdf->Cell(80,6,$des['spart'].' '.bspart($des['part'],$des['spart']),1,0,'L');
  $pdf->Cell(30,6,number_format($des['monto'],2),1,1,'R');
  $tmonto = $tmonto + $des['monto'];
}
$pdf->SetFont('Arial','B',7,true);
$pdf->Cell(160,6,'TOTAL','T',0,'R');
$pdf->Cell(30,6,number_format($tmonto,2),1,1,'R');

$pdf->htmltable($report);
$pdf->Output('Prev_'.$g.'_'.$n.'_'.$i.'_'.$n.'.pdf','I');
?>
