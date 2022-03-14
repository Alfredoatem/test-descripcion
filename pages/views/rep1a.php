<? 
/************************************************/
/*DESARROLLADO POR	:	ING. JOSE LEDO REBOLLO  */
/*FECHA				:	02/05/2020 	 */
/*CELULAR			:	70614112		 */
/*LUGAR				:	MINDEFENSA - LA PAZ*/
/************************************************/
ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
ini_set('memory_limit', '512M');

//include "../pages/seguridad.php";
require('../../resources/phps/fpdf/fpdf.php');
require('../../resources/phps/fpdf/pdftable/pdftable.inc.php');
include('../../connections/connect.php');
include('../../functions/global.php');

if(trim($_GET['criterio'])!=''){
  $criterio = base64_decode($_GET['criterio']);
}else{
	echo "<script>alert('Seleccione Criterio de Busqueda')</script>";
	exit;
}
/*
echo $criterio."<br>";
echo $_GET['orden']."<br>";
echo $_GET['crifvenc']."<br>";
echo $_GET['frep']."<br>";*/

class PDF extends PDFTable{
	function Header(){
		parent::Header();
		$this->SetFont('Arial','',5);
		$this->SetMargins(15,10,15,15);
		$this->SetXY(15,10);
    
		$encabezado='
    <table border=0 cellpadding=1>
			<tr>
				<td width=50 size=7 style="bold" align="center">MINISTERIO DE DEFENSA</td>
				<td width=120 size=7 style="bold" align="right">Fecha Imp.:</td>
				<td width=20 size=7 style="bold" align="right">'.date('d/m/Y').'</td>
			</tr>
		</table>';
    $this->htmltable($encabezado,1);
		
		$encabezado='
    <table border=0 cellpadding=1>
      <tr>
				<td width=50 size=7 style="bold" align="center">UNIDAD FINANCIERA</td>
				<td width=120 size=7 style="bold" align="right">Hora :</td>
        <td width=20 size=7 style="bold" align="right">'.date('H:i:s').'</td>
			</tr>
		</table>';
    $this->SetXY(15,13);
    $this->htmltable($encabezado,1);
    
    $encabezado='
    <table border=0 cellpadding=1>
      <tr>
				<td width=50 size=7 style="bold" align="center">La Paz - Bolivia</td>
				<td width=120 size=7 style="bold" align="right"></td>
        <td width=20 size=7 style="bold" align="right"></td>
			</tr>
		</table>';
    $this->SetXY(15,16);
    $this->htmltable($encabezado,1);
    
	$this->SetFont('Arial','B',5);
    $titulo='
    <table border=0 cellpadding=1>
      <tr>
				<td width=190 size=8 style="bold" align="center"> INGRESOS REGISTRADOS HASTA '.$_GET['frep'].'</td>
			</tr>
		</table>';
    $this->SetXY(15,14);
    $this->htmltable($titulo,1);
    $this->Ln(2);
	}
	function Footer(){
		$this->SetY(-12);
		$this->SetFont('Arial','I',5);
		$this->Cell(305,7,'Pag '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

//$sql = "select i.codcon, c.des, sum(i.monto) as enero from ingteso i, conpre21:conceing c	where i.codcon=c.cod and month(i.fecha_v)=1  group by i.codcon, c.des order by 1,2";
//$sql = "select i.codcon, c.des ,sum(i.monto) enero  from ingteso i, conpre21:conceing c where c.cod='CI1B' and i.codcon='CI1B' and month(i.fecha_v)=1 group by codcon, des";
//$sql = "select i.codcon, c.des ,sum(i.monto) enero, max(fecha_v) fecha from ingteso i, conpre21:conceing c where c.cod=i.codcon and month(i.fecha_v)=1 group by codcon, des order by 1,2";
$sql = "select i.codcon, c.des ,sum(i.monto) enero from ingteso i, conpre21:conceing c where c.cod=i.codcon and month(i.fecha_v)=1 group by codcon, des order by 1,2";
//$sql2 = "select i.codcon, c.des,sum(i.monto) febrero from ingteso i, conpre21:conceing c where c.cod=i.codcon and month(i.fecha_v)=2 group by des order by 1,2";
//echo $sql;
$pdf=new PDF();
$pdf->FPDF('P','mm',array(216,330));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8,true);
$pdf->SetMargins(10,10,15,15);

	$p = $db->query($sql)->fetchAll(PDO::FETCH_GROUP);
	//$q = $db->query($sql2)->fetchAll(PDO::FETCH_GROUP);
	
	$c = 0;
	$pdf->SetFont('Arial','',7,true);
	$pdf->Ln(2);
	
		  
			$pdf->SetFont('Arial','B',7,true);
		  	//$pdf->Cell(305,5,trim('DCTO.:')." .- ".balm($alm),0,1,'L',false);	  
			$pdf->Cell(17,5,'CODIGO',1,0,'L');//CABECERA DE CODIGO
			$pdf->Cell(75,5,'DESCRIPCION',1,0,'L');//CABECERA DE DESCRIPCION
			$pdf->Cell(20,5,'ENERO',1,0,'L');//CABECERA DE SUMA MONTO ENERO
			$pdf->Cell(18,5,'',0,1,'L');
			//$pdf->Cell(20,5,'INGRESOS',1,0,'R');
			//$pdf->Cell(20,5,'SALIDAS',1,0,'R');
			//$pdf->Cell(20,5,'SALDOS',1,0,'R');
			//$pdf->Cell(20,5,'F. VENC',1,1,'R');
		foreach($p as $alm => $v){		
			foreach($v as $fila => $csig){
				//$pdf->Cell(18,5,'',0,1,'L');
				//$dataingteso = $queryingteso->fetch(PDO::FETCH_ASSOC);
				
				$codcon = trim($codcon);
				
				$pdf->Cell(17,5,trim($alm),1,0,'L');
				$pdf->Cell(75,5,$csig['des'],1,0,'L');
				$pdf->Cell(20,5,number_format($csig['enero'],2),1,0,'R');
				//$pdf->Cell(19,5,$csig['fecha'],0,0,'L');
				$pdf->Cell(18,5,'',0,1,'L');
			}
	}
	
	$pdf->Output('existencias.pdf','I');
	unset($pdf);
?>