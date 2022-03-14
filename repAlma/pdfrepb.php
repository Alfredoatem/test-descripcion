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

/*echo $criterio."<br>";
echo $_GET['fini']."<br>";
echo $_GET['ffin']."<br>";*/

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
				<td width=220 size=7 style="bold" align="right">Fecha Imp.:</td>
				<td width=20 size=7 style="bold" align="right">'.date('d/m/Y').'</td>
			</tr>
		</table>';
    $this->htmltable($encabezado,1);
		
		$encabezado='
    <table border=0 cellpadding=1>
      <tr>
				<td width=50 size=7 style="bold" align="center">UNIDAD FINANCIERA</td>
				<td width=220 size=7 style="bold" align="right">Hora :</td>
        		<td width=20 size=7 style="bold" align="right">'.date('H:i:s').'</td>
			</tr>
		</table>';
    $this->SetXY(15,13);
    $this->htmltable($encabezado,1);
    
    $encabezado='
    <table border=0 cellpadding=1>
      <tr>
				<td width=50 size=7 style="bold" align="center">La Paz - Bolivia</td>
				<td width=220 size=7 style="bold" align="right"></td>
       			<td width=20 size=7 style="bold" align="right"></td>
			</tr>
		</table>';
    $this->SetXY(15,16);
    $this->htmltable($encabezado,1);
    
	$this->SetFont('Arial','B',9);	
    $titulo='
    <table border=0 cellpadding=1>
      <tr>
				<td width=290 size=9 style="bold" align="center">  MOVIMIENTO DE PRODUCTOS POR ALMACEN DEL '.$_GET['fini'].' AL '.$_GET['ffin'].' </td>
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

//dcto,nro,fecha,codrep,codprod,dcant,hcant,pu, dcto_m,nro_m
//$sql= "select d.codprod cprod, m.*, d.* ";
$sql= "select d.codprod cprod, m.dcto,m.nro, m.fecha, m.codrep, d.codalm, d.codprod, d.dcant, d.hcant, d.pu, d.dcto_m, d.nro_m ";
$sql.= "from maealma m,detalma d ";
$sql.= "where m.dcto=d.dcto and m.nro=d.nro ";
$sql.= "and m.voboalma<>'A'  ";
//$sql.= "and m.dcto[1]='F' and d.codalm='002' and d.codprod='21020702' ";
//$sql.= "and m.dcto[1]='F'   ";
//$sql.= "and m.fecha between '31/12/2019' and '31/12/2021' ";
$sql.= " ".$criterio;
$sql.= " order by d.codalm,d.codprod,m.fecha,d.dcto,d.nro  ";

//echo $sql;
$pdf=new PDF();
$pdf->FPDF('L','mm',array(216,330));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8,true);
$pdf->SetMargins(10,10,15,15);

$qry = "SELECT distinct codalm  FROM (".$sql.") ORDER BY codalm";
//echo "...".$qry."<br>";
$p1 = $db->prepare($qry);
$p1->execute();

	while($row = $p1->fetch(PDO::FETCH_ASSOC)){
	  	$qry1 = "SELECT * FROM (".$sql.") where codalm = '".$row['codalm']."' order by 6,7,4,2,3";
  //echo $qry1."<br>";
		$auxalm ="";
		$auxalm = $row['codalm'];
		$p = $db->query($qry1)->fetchAll(PDO::FETCH_GROUP);

	$c = 0;
//	$pdf->SetFont('Arial','',7,true);
	$pdf->Ln(2);
	foreach($p as $pro => $v){					
			$pdf->SetFont('Arial','B',9,true);	
			$pdf->Cell(95,5,"Almacen: ".$auxalm."-".balm($auxalm),0,0,'L',false);			 
			$pdf->Cell(115,5,"Producto: ".trim($pro)."-". bprod($pro),0,0,'L',false);
			$pdf->Cell(105,5,"Unidad de medida: ".bunimedprod($pro),0,1,'L',false);
			$pdf->Cell(30,5,'DCTO.-NRO',1,0,'L');
			$pdf->Cell(25,5,'FECHA',1,0,'L');
			$pdf->Cell(85,5,'REPARTICION',1,0,'L');
			$pdf->Cell(35,5,'CANT.INGRESOS',1,0,'R');
			$pdf->Cell(35,5,'CANT.SALIDAS',1,0,'R');
			//$pdf->Cell(20,5,'DCTOM-NROM',1,0,'R');
			$pdf->Cell(35,5,'CANT.SALDOS',1,0,'R');
			$pdf->Cell(35,5,'PREC.UNITARIO',1,1,'R');
		//	$pdf->Cell(25,5,'MONTO DEBE',1,0,'R');
		//	$pdf->Cell(25,5,'MONTO HABER',1,0,'R');
		//	$pdf->Cell(25,5,'MONTO SALDO',1,1,'R');
			$toting = 0;
			$totsal = 0;
			$totdebe = 0;
			$tothaber = 0;
			//$prod='21020702';
			//$feci='01/06/2020';
			//$cond = " and m.dcto[1]='".$_SESSION["sialmagalm"]."'";//dcriterio
			//$codalm ='002';
			$dctoi = $_SESSION["sialmagalm"];
			
			//$antsaldo = bantsalprod($alm,$feci,$cond,$auxalm,$dctoi);	//dp,fi,condi,da,suc
			$pdf->SetFont('Arial','',9,true);
			$asaldo = bantsalprod($pro,$_GET['fini'],$_GET['crifec'],$auxalm,$dctoi);	//dp,fi,condi,da,suc
			$pdf->Cell(105,5,'Saldo anterior al '.$_GET['fini'],0,0,'R');
			$pdf->Cell(20,5,number_format($asaldo[0],2),0,1,'R');
			//$pdf->Cell(170,5,number_format($asaldo[1],4),0,1,'R');
			$scant = $asaldo[0];
			$msaldo = $asaldo[1];
			foreach($v as $fila => $row1){
				//$pdf->SetFont('Arial','',7,true);
				$c++;				
				$dctonro = $row1['dcto'].'-'.sprintf("%'.08d\n", $row1['nro']);				
				$dctonrom = $row1['dcto_m'].'-'.sprintf("%'.08d\n", $row1['nro_m']);
				$mdebe = $row1['dcant'] * $row1['pu'];
				$mhaber = $row1['hcant'] * $row1['pu'];
			
				$toting = $toting + $row1['dcant'];
				$totsal = $totsal + $row1['hcant'];
				$totdebe = $totdebe + $mdebe;
				$tothaber = $tothaber + $mhaber;

				 //let scant=scant+ddetalm.dcant-ddetalm.hcant				
   				//let msaldo=msaldo + ddetalm.dcant*ddetalm.pu - ddetalm.hcant*ddetalm.pu
				$scant = $scant + ($row1['dcant']-$row1['hcant']);				
				$msaldo = $msaldo + (($row1['dcant']*$row1['pu']) - ($row1['hcant']*$row1['pu']));

				$pdf->Cell(30,5,$dctonro,0,0,'L');
				$pdf->Cell(25,5,$row1['fecha'],0,0,'L');
				$pdf->Cell(85,5,brepar($row1['codrep']),0,0,'L');
				$pdf->Cell(35,5,number_format($row1['dcant'],2),0,0,'R');
				$pdf->Cell(35,5,number_format($row1['hcant'],2),0,0,'R');
				//$pdf->Cell(20,5,$dctonrom,0,0,'R');
				$pdf->Cell(35,5,number_format($scant,2),0,0,'R');
				$pdf->Cell(35,5,number_format($row1['pu'],4),0,0,'R');
			//	$pdf->Cell(25,5,number_format($mdebe,4),0,0,'R');
			//	$pdf->Cell(25,5,number_format($mhaber,4),0,0,'R');
			//	$pdf->Cell(25,5,number_format($msaldo,4),0,0,'R');				
				$pdf->Cell(5,4,'',0,1,'R');
			}
			$pdf->Ln(1);
			$pdf->SetFont('Arial','B',9,true);	
			$pdf->Cell(30,5,'TOTALES',0,0,'L');
			$pdf->Cell(25,5,'',0,0,'L');
			$pdf->Cell(85,5,'',0,0,'L');
			$pdf->Cell(35,5,number_format($toting,2),0,0,'R');
			$pdf->Cell(35,5,number_format($totsal,2),0,0,'R');
			/*$pdf->Cell(20,5,'',0,0,'R');
			$pdf->Cell(25,5,'',0,0,'R');
			$pdf->Cell(25,5,'',0,0,'R');
			$pdf->Cell(25,5,number_format($totdebe,4),0,0,'R');
			$pdf->Cell(25,5,number_format($tothaber,4),0,0,'R');*/
			$pdf->Cell(25,5,'',0,1,'R');
			$pdf->Ln(2);
			$pdf->AddPage();			
	}
}
	$pdf->Output('moviprod.pdf','I');
	unset($pdf);
?>