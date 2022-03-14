<? 
/************************************************/
/*DESARROLLADO POR	:	ING. JOSE LEDO REBOLLO  */
/*FECHA				:	02/05/2020 	 */
/*CELULAR			:	70614112		 */
/*LUGAR				:	MINDEFENSA - LA PAZ*/
/************************************************/
ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
ini_set('memory_limit', '512M');

include "../pages/seguridad.php";
require('../resources/phps/fpdf/fpdf.php');
require('../resources/phps/fpdf/pdftable/pdftable.inc.php');
include('../connections/connect.php');
include('../functions/global.php');

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
				<td width=190 size=8 style="bold" align="center"> EXISTENCIA DE PRODUCTOS POR ALMACEN AL '.$_GET['frep'].'</td>
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

$flag=0;
switch ($_GET['orden']) {
	case 1:
		if(trim($_GET['crifvenc']) != 1 ){
			$sql = "select * from (";
			$sql.= "select d.codalm, d.codprod, sum(dcant) ingresos,sum(hcant) salidas, d.fvenc ";
			$sql.= "from maealma m inner join detalma d on m.dcto=d.dcto and m.nro=d.nro ";
			$sql.= "inner join paramdctoalma z on m.dcto=z.cod ";
			$sql.= "where m.voboalma<>'A'  ";
			$sql.= " ".$criterio." group by 1,2,5 )  ORDER BY codalm, codprod ";
			$flag=1;
		}else{
			$sql = "select * from (";
		$sql.= "select d.codalm, d.codprod, sum(dcant) ingresos,sum(hcant) salidas ";
		$sql.= "from maealma m inner join detalma d on m.dcto=d.dcto and m.nro=d.nro ";
		$sql.= "inner join paramdctoalma z on m.dcto=z.cod ";
		$sql.= "where m.voboalma<>'A'  ";
		$sql.= " ".$criterio." group by 1,2 )  ORDER BY codalm, codprod ";			
		}
	break;
	case 2:
		if(trim($_GET['crifvenc']) != 1 ){
			$sql = "select * from (";
			$sql.= "select d.codalm, d.codprod, p.des, sum(dcant) ingresos,sum(hcant) salidas, d.fvenc ";
			$sql.= "from maealma m inner join detalma d on m.dcto=d.dcto and m.nro=d.nro ";
			$sql.= "inner join paramdctoalma z on m.dcto=z.cod ";
			$sql.= "inner join conpre21:producto p on p.cod=d.codprod ";
			$sql.= "where m.voboalma<>'A'  ";
			$sql.= " ".$criterio." group by 1,2,3,6 )  ORDER BY codalm, des ";
			$flag=1;
		}else{
			$sql = "select * from (";
		$sql.= "select d.codalm, d.codprod, p.des, sum(dcant) ingresos,sum(hcant) salidas ";
		$sql.= "from maealma m inner join detalma d on m.dcto=d.dcto and m.nro=d.nro ";
		$sql.= "inner join paramdctoalma z on m.dcto=z.cod ";
		$sql.= "inner join conpre21:producto p on p.cod=d.codprod ";
		$sql.= "where m.voboalma<>'A'  ";
		$sql.= " ".$criterio." group by 1,2,3 )  ORDER BY codalm, des ";			
		}
	break;
	}
//echo $sql;
$pdf=new PDF();
$pdf->FPDF('P','mm',array(216,330));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8,true);
$pdf->SetMargins(10,10,15,15);

	$p = $db->query($sql)->fetchAll(PDO::FETCH_GROUP);
	$c = 0;
	$pdf->SetFont('Arial','',7,true);
	$pdf->Ln(2);
	foreach($p as $alm => $v){		  
			$pdf->SetFont('Arial','B',7,true);
		  	$pdf->Cell(305,5,trim($alm)." - ".balm($alm),0,1,'L',false);	  
			$pdf->Cell(17,5,'PRODUCTO',1,0,'L');
			$pdf->Cell(75,5,'DESCRIPCION',1,0,'L');
			$pdf->Cell(20,5,'UNIDAD',1,0,'L');
			$pdf->Cell(20,5,'INGRESOS',1,0,'R');
			$pdf->Cell(20,5,'SALIDAS',1,0,'R');
			$pdf->Cell(20,5,'SALDOS',1,0,'R');
			$pdf->Cell(20,5,'F. VENC',1,1,'R');
			foreach($v as $fila => $csig){
				$pdf->SetFont('Arial','',7,true);
				$c++;				
				$desprod = bprod($csig['codprod']);
				$saldo = $csig['ingresos'] - $csig['salidas'];
				$pdf->Cell(17,4,$csig['codprod'],0,0,'L');
				$pdf->Cell(75,4,trim($desprod),0,0,'L');
				$pdf->Cell(20,4,bunimedprod($csig['codprod']),0,0,'L');
				$pdf->Cell(20,4,number_format($csig['ingresos'],2),0,0,'R');
				$pdf->Cell(20,4,number_format($csig['salidas'],2),0,0,'R');
				$pdf->Cell(20,4,number_format($saldo,2),0,0,'R');
				if ($flag==1) $pdf->Cell(20,4,$csig['fvenc'],0,0,'R');
				$pdf->Cell(5,4,'',0,1,'R');
			}
	}
	$pdf->Output('existencias.pdf','I');
	unset($pdf);
?>