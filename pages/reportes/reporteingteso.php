<?php
session_start();
require('../../vendor/FPDF/fpdf.php');
require('../../resources/phps/n2l.php');
include "../../connections/connect.php";

$showBorder     = 0;
$SUMAtotal      = 0;
// 
$documento = base64_decode($_GET['documento']);
//
$documento = explode( ',',base64_decode($_GET['documento']));
//
$sqlParamGranalma = "SELECT p.cod as codigo, p.des as descripcion, t.des as des FROM paramgranalma p inner join paramtipoalma t on p.codtipoalma=t.cod where p.cod = '".substr($documento[0], 0, 1)."' ";
$queryParamGranalma = $db->prepare($sqlParamGranalma);
$queryParamGranalma->execute();
$dataParamGranalma = $queryParamGranalma->fetch(PDO::FETCH_ASSOC);
// 
$sqlingteso = "SELECT * FROM ingteso WHERE dcto = '".$documento[0]."' and nro = '".$documento[1]."' and gestion = '".$documento[2]."' ";
$queryingteso = $db->prepare($sqlingteso);
$queryingteso->execute();
$dataingteso = $queryingteso->fetch(PDO::FETCH_ASSOC);
// 
$txtfechav        = $dataingteso['fecha_v'];
$txtfechadep        = $dataingteso['fecha_dep'];
$txtcodcon        = $dataingteso['codcon'];
$txtinter        = $dataingteso['inter'];
$txtopbanco        = $dataingteso['opbanco'];
$txtcodcta        = $dataingteso['codcta'];
$txtobs        = $dataingteso['obs'];
$txtrepar        = $dataingteso['repar'];
$txtdctoc        = $dataingteso['dcto_c'];
$txtprograma        = $dataingteso['programa'];
$txtclase        = $dataingteso['clase'];
$txtcta        = $dataingteso['cta'];
$txtrubro        = $dataingteso['rubro'];
$txtestado        = $dataingteso['estado'];
$txtfecest        = $dataingteso['fec_est'];
$txtffin        = $dataingteso['ffin'];
$txtobsa        = $dataingteso['obsa'];
$txtpreventivo        = $dataingteso['preventivo'];
$txtmonto        = $dataingteso['monto'];
$txtglosa         = $dataAlma['glosa'];
$txthtd           = $dataAlma['ref4'];
$txtpedi          = $dataAlma['ref2'];
//$txtcmpbte        = $dataAlma[''];
//$txtordencom      = $dataAlma[''];
$txtsoli          = $dataAlma['ref1'];
//$txtdir           = $dataAlma[''];
//$txtunidad        = $dataAlma[''];
$txtcoti          = $dataAlma['ref3'];
//$txtfechaaviso    = $dataAlma[''];
$txtempresa       = $dataAlma['obs1'];
$txtfactura       = $dataAlma['obs2'];
// 
$almacen = $dataParamGranalma['descripcion'];
$clase = $dataParamGranalma['des'];
// print_r($sqlParamGranalma);
// 
$alturaDatosTabla = 0.5;
$isPainted = False;

class PDF extends FPDF
{
    function Header()
    {
        global $almacen;
        global $clase;
        global $txtfechav;
        global $txtfechadep;
        global $txtcodcon;
        global $txtinter;
        global $txtopbanco;
        global $txtcodcta;
        global $txtobs;
        global $txtrepar;
        global $txtdctoc;
        global $txtprograma;
        global $txtclase;
        global $txtcta;
        global $txtrubro;
        global $txtestado;
        global $txtfecest;
        global $txtffin;
        global $txtobsa;
        global $txtpreventivo;
        global $txtmonto;
        global $txtglosa;
        global $txthtd;
        global $txtpedi;
        //global $txtcmpbte;
        //global $txtordencom;
        global $txtsoli;
        //global $txtdir;
        //global $txtunidad;
        global $txtcoti;
        //global $txtfechaaviso;
        global $txtempresa;
        global $txtfactura;

        global $showBorder;

        $almacen = trim($almacen);
        $almacenDatos = explode(' ', $almacen);
        $ciudad = $almacenDatos[1];
        $txtalma = $almacenDatos[0];

        $clase      = trim($clase);
        $txtfechav   = trim($txtfechav);
        $txtfechadep   = trim($txtfechadep);
        $txtcodcon   = trim($txtcodcon);
        $txtinter   = trim($txtinter);
        $txtopbanco   = trim($txtopbanco);
        $txtcodcta   = trim($txtcodcta);
        $txtobs   = trim($txtobs);
        $txtrepar   = trim($txtrepar);
        $txtdctoc   = trim($txtdctoc);
        $txtprograma   = trim($txtprograma);
        $txtclase   = trim($txtclase);
        $txtcta   = trim($txtcta);
        $txtrubro   = trim($txtrubro);
        $txtestado   = trim($txtestado);
        $txtfecest   = trim($txtfecest);
        $txtffin   = trim($txtffin);
        $txtobsa   = trim($txtobsa);
        $txtpreventivo   = trim($txtpreventivo);
        $txtmonto   = trim($txtmonto);
        $txtglosa   = trim($txtglosa);
        $txthtd     = trim($txthtd);
        $txtpedi    = trim($txtpedi);
        $txtsoli    = trim($txtsoli);
        $txtcoti    = trim($txtcoti);
        $txtempresa = trim($txtempresa);
        $txtfactura = trim($txtfactura);


        $documento = explode( ',',base64_decode($_GET['documento']));

        $dcto           = $documento[0];
        $nro            = $documento[1];

        $titulo         = 'transaccion';

        // $txtfecha       = '29/03/2021';
        // $txthtd         = 'SBC00079';
        // $txtpedi        = '44';
        // $txtcmpbte      = 'R-';
        // $txtordencom    = '000000001';
        // $txtsoli        = 'SOF. MARCO ANTONIO CHIPANA QUISPE';
        // $txtdir         = 'DIRECCION GRAL DE ASUNTOS ADMINISTRATIVOS';
        // $txtunidad      = 'DIRECCION GRAL DE ASUNTOS ADMINISTRATIVOS';
        // $txtcoti        = 'LIC. SERGIO PEREZ';
        // $txtfechaaviso  = '';
        // $txtempresa     = 'CLAUDIA SOFIA RIOJA SELUM';
        // $txtfactura     = '00008/00009';



        $this->SetFont('Courier','',5);
        $this->SetFillColor(0, 0, 0);
        $this->Cell( 0, 0.2, 'MINISTERIO DE DEFENSA NACIONAL', $showBorder, 1, 'L');
        // $this->Ln(0); =================No.Dcto==================================
        $this->Cell( 0, 0.2, 'No.Dcto: ' . $dcto . '-' . $nro, $showBorder, 1, 'C');
        // $this->Ln(0);
        $this->Cell( 3, 0.2, 'Dir.Gral.Asuntos Administ.', $showBorder, 0, 'C');
        $this->Cell( 0, 0.2, 'Pag.No.: ' . $this->PageNo(), $showBorder, 1, 'R');
        $this->Cell( 3, 0.2, 'Unidad Administrativa', $showBorder, 1, 'C');
        $this->Cell( 3, 0.2, $almacenDatos[0] . ' ' . $clase, $showBorder, 1, 'C');
        $this->Cell( 3, 0.2, $ciudad . ' - Bolivia', $showBorder, 1, 'C');
        $this->Cell( 3, 0.2, 'Gestion: ' . $documento[2], $showBorder, 1, 'C');
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C', 0);
        $this->Cell( 0, 0.2, 'COMPROBANTE DE ' . strtoupper($titulo) . ' DE INGRESOS', $showBorder, 1, 'C');
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C', 0);
        // FECHA
        $this->Cell( 2, 0.2, 'FECHA VERIFICACION', $showBorder, 0, 'L');
        $this->Cell( 0, 0.2, ': ' . $txtfechav, $showBorder, 1, 'L');
        // HTD
        $this->Cell( 2, 0.2, 'FECHA DEPOSITO', $showBorder, 0, 'L');
        $this->Cell( 7, 0.2, ': ' . $txtfechadep, $showBorder, 0, 'L');
        // PEDIDO No
        $this->Cell( 2, 0.2, 'COD.CONC. INGRESO', $showBorder, 0, 'L');
        $this->Cell( 0, 0.2, ': ' . $txtcodcon, $showBorder, 1, 'L');
        // CMPBTE.PAGO>
        $this->Cell( 2, 0.2, 'OP. BANCO', $showBorder, 0, 'L');
        $this->Cell( 7, 0.2, ': ' . $txtopbanco, $showBorder, 0, 'L');
        // ORDEN COMPRA
        $this->Cell( 2, 0.2, 'COD.CTA.BANCARIA', $showBorder, 0, 'L');
        $this->Cell( 0, 0.2, ': ' . $txtcodcta, $showBorder, 1, 'L');
        // SOLICITADO
        $this->Cell( 2, 0.2, 'INTERESADO', $showBorder, 0, 'L');
        $this->Cell( 7, 0.2, ': ' . $txtinter, $showBorder, 0, 'L');
        // ADQUISICION
        $this->Cell( 2, 0.2, 'OBSERVACIONES', $showBorder, 0, 'L');
        $this->Cell( 0, 0.2, ': ' . $txtobs, $showBorder, 1, 'L');
        // DIRECCION
        $this->Cell( 2, 0.2, 'COD. REPARTICION', $showBorder, 0, 'L');
        $this->Cell( 7, 0.2, ': ' . $txtrepar, $showBorder, 0, 'L');
        // UNIDAD Y/O AREA
        $this->Cell( 2, 0.2, 'DCTO. CONTABLE', $showBorder, 0, 'L');
        $this->Cell( 0, 0.2, ': ' . $txtdctoc, $showBorder, 1, 'L');
        // COTIZADO
        $this->Cell( 2, 0.2, 'PROGRAMA', $showBorder, 0, 'L');
        $this->Cell( 0, 0.2, ': ' . $txtprograma, $showBorder, 1, 'L');
        // EMPRESA
        $this->Cell( 2, 0.2, 'ACTIVIDAD', $showBorder, 0, 'L');
        $this->Cell( 7, 0.2, ': ' . $txtclase, $showBorder, 0, 'L');
        // FACTURA
        $this->Cell( 2, 0.2, 'CTA. CONTABLE.', $showBorder, 0, 'L');
        $this->Cell( 0, 0.2, ': ' . $txtcta, $showBorder, 1, 'L');
          // EMPRESA
        $this->Cell( 2, 0.2, 'RUBRO', $showBorder, 0, 'L');
        $this->Cell( 7, 0.2, ': ' . $txtrubro, $showBorder, 0, 'L');
        // FACTURA
        $this->Cell( 2, 0.2, 'ESTADO.', $showBorder, 0, 'L');
        $this->Cell( 0, 0.2, ': ' . $txtestado, $showBorder, 1, 'L');
          // EMPRESA
          $this->Cell( 2, 0.2, 'FECHA A.', $showBorder, 0, 'L');
          $this->Cell( 7, 0.2, ': ' . $txtfecest, $showBorder, 0, 'L');
          // FACTURA
          $this->Cell( 2, 0.2, 'FUENTE FIN.', $showBorder, 0, 'L');
          $this->Cell( 0, 0.2, ': ' . $txtffin, $showBorder, 1, 'L');
      // EMPRESA
      $this->Cell( 2, 0.2, 'OBS. EST.', $showBorder, 0, 'L');
      $this->Cell( 7, 0.2, ': ' . $txtobsa, $showBorder, 0, 'L');
      // FACTURA
      $this->Cell( 2, 0.2, 'PREVENTIVO', $showBorder, 0, 'L');
      $this->Cell( 0, 0.2, ': ' . $txtpreventivo, $showBorder, 1, 'L');
      // MONTO BS
      $this->Cell( 2, 0.2, 'MONTO EN BS.', $showBorder, 0, 'L');
      $this->Cell( 0, 0.2, ': ' . $txtmonto, $showBorder, 1, 'L');
        // 
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C', 0);
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C');
        $this->SetFillColor(115, 115, 115);
        $this->Cell( 0, (1 / 100), '', $showBorder, 1, 'C', 1);
        $this->SetFillColor(0, 0, 0);
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C');
        // 
        /*$this->SetFont('Courier','',5);
        $this->Cell( 2, 0.2, 'CODIGO'         , $showBorder, 0, 'C', 0);
        $this->Cell( 0.5, 0.2, ''             , $showBorder, 0, 'C', 0);
        $this->Cell( 5, 0.2, 'DESCRIPCION'    , $showBorder, 0, 'L', 0);
        $this->Cell( 0.5, 0.2, ''             , $showBorder, 0, 'C', 0);
        $this->Cell( 3, 0.2, 'UNIDAD'         , $showBorder, 0, 'C', 0);
        $this->Cell( 0.5, 0.2, ''             , $showBorder, 0, 'C', 0);
        $this->Cell( 2, 0.2, 'CANTIDAD'       , $showBorder, 0, 'C', 0);
        $this->Cell( 0.5, 0.2, ''             , $showBorder, 0, 'C', 0);
        $this->Cell( 2, 0.2, 'PRECIO UNITARIO', $showBorder, 0, 'C', 0);
        $this->Cell( 0.5, 0.2, ''             , $showBorder, 0, 'C', 0);
        $this->Cell( 0, 0.2, 'CANTIDAD TOTAL'   , $showBorder, 1, 'C', 0);
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C');
        $this->SetFillColor(115, 115, 115);
        $this->Cell( 0, (1 / 100), ''        , $showBorder, 1, 'C', 1);
        $this->SetFillColor(0, 0, 0);
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C');
        */
    }
}

$pdf = new PDF('P','cm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(True, 1);
$pdf->SetLineWidth( (0.001) );
// $pdf->SetMargins( 2,5, 2,5, 2,5);
$pdf->AliasNbPages();

$pdf->SetFont('Courier','',5);
// $pdf->Cell( 0, 0.2, ''            , $showBorder, 1, 'C', 0);
$sqlDetalle = "SELECT dcto, nro, id, codalm, codprod, dcant, hcant, dcto_m, nro_m, pu, fvenc, gestion, p.cod 
               as copdroducto, p.des as nombreprod, u.des as unidadprod 
               from siaf:detalma d 
               inner join conpre21:producto p 
               on d.codprod=p.cod 
               inner join conpre21:unimedid u on p.codumed=u.cod 
               WHERE d.dcto = '".$documento[0]."' and d.nro = '".$documento[1]."' and d.gestion = '".$documento[2]."' ";
$queryDetalle = $db->prepare($sqlDetalle);
$queryDetalle->execute();
while( $dataDetalle = $queryDetalle->fetch(PDO::FETCH_ASSOC) ){
        
    if($isPainted==True){
        $pdf->SetFillColor(255, 255, 255);
        $isPainted=False;
    }else{
        $pdf->SetFillColor(230, 230, 230);
        $isPainted=True;
    }
    // 
    $pdf->Cell( 2  , $alturaDatosTabla, $dataDetalle['codprod'], $showBorder, 0, 'C', 1);
    $pdf->Cell( 0.5, $alturaDatosTabla, '', $showBorder, 0, 'C', 1);
    $pdf->Cell( 5  , $alturaDatosTabla, trim($dataDetalle['nombreprod']) . $i, $showBorder, 0, 'L', 1);
    $pdf->Cell( 0.5, $alturaDatosTabla, '', $showBorder, 0, 'C', 1);
    $pdf->Cell( 3  , $alturaDatosTabla, trim($dataDetalle['unidadprod']), $showBorder, 0, 'C', 1);
    $pdf->Cell( 0.5, $alturaDatosTabla, '', $showBorder, 0, 'C', 1);
    $pdf->Cell( 2  , $alturaDatosTabla, number_format(intval($dataDetalle['dcant']), 2, '.', ','), $showBorder, 0, 'C', 1);
    $pdf->Cell( 0.5, $alturaDatosTabla, '', $showBorder, 0, 'C', 1);
    $pdf->Cell( 2  , $alturaDatosTabla, number_format(intval($dataDetalle['pu']), 4, '.', ','), $showBorder, 0, 'C', 1);
    $pdf->Cell( 0.5, $alturaDatosTabla, '', $showBorder, 0, 'C', 1);
    $pdf->Cell( 2  , $alturaDatosTabla, number_format((intval($dataDetalle['dcant']) * intval($dataDetalle['pu'])), 2, '.', ','), $showBorder, 0, 'R', 1);
    $pdf->Cell( 0  , $alturaDatosTabla, '', $showBorder, 1, 'C', 1);
    $SUMAtotal += (intval($dataDetalle['dcant']) * intval($dataDetalle['pu']));

}
// 
$pdf->SetFillColor(0, 0, 0);
$pdf->SetFillColor(115, 115, 115);
$pdf->Cell( 0, (1 / 100), ''                                                , $showBorder, 1, 'C', 1);
$pdf->SetFillColor(0,0,0);
// 
/*
$pdf->Cell( 2, 0.2, ''                                                      , $showBorder, 0, 'C', 0);
$pdf->Cell( 8, 0.2, 'T O T A L'                                             , $showBorder, 0, 'C', 0);
$pdf->Cell( 6.5, 0.2, ''                                                    , $showBorder, 0, 'C', 0);
$pdf->Cell( 2, 0.2, number_format($SUMAtotal, 2, '.', ',')                  , $showBorder, 0, 'R', 0);
$pdf->Cell( 0, 0.2, ''                                                      , $showBorder, 1, 'C', 0);
*/
// 
/*
$pdf->Cell( 16, (1 / 100), ''                                                , $showBorder, 0, 'C', 0);
$pdf->SetFillColor(115, 115, 115);
$pdf->Cell( 0, (1 / 100), ''                                                , $showBorder, 1, 'C', 1);
$pdf->SetFillColor(0,0,0);
*/
// 
/*
$pdf->Cell( 12, 0.2, n2l($SUMAtotal) . ' 00/100'                            , $showBorder, 1, 'C', 0);
*/
// 
// 
// PIE DE PAGINA
$FooterLimite = 5; //CAMBIAR LA ALTURA DEL RECTANGO DEL PIE DE PAGINA
$FooterLimite = ($FooterLimite < 3) ? 3 : $FooterLimite;
// PUNTOS PARA LAS LINEAS
$widthFooter = 19.6;  //default 19.6
$heigthFooter = 1.6; //default 1.95
// 0.175
$x1 = 1.0;   //default 1
$y1 = 25.1; //default 23.65
// 0.225
$yMultiplier = 0.225;
$xMultiplier = 0;
$heigthMultiplier = 0.175;
$widthMultiplier  = 0;
//
$y1 -= ($yMultiplier * ($FooterLimite - 3));
$heigthFooter += ($heigthMultiplier * ($FooterLimite - 3));
//

$pdf->SetY((-2 - ($FooterLimite / 4) ));
$pdf->Cell( 0, 0.2, $lineaFooter, $showBorder, 1, 'C', 0 );
$pdf->Cell( 1, 0.2, '', $showBorder, 0, 'L', 0);
$pdf->Cell( 8, 0.2, '', $showBorder, 0, 'C', 0);
$pdf->Cell( 1, 0.2, '', $showBorder, 0, 'C', 0);
$pdf->Cell( 8, 0.2, '', $showBorder, 0, 'C', 0);
$pdf->Cell( 0, 0.2, '', $showBorder, 1, 'R', 0);
// 
for($x = 0; $x < $FooterLimite; $x++){    
    $pdf->Cell( 1, 0.2, '', $showBorder, 0, 'L', 0);
    $pdf->Cell( 8, 0.2, '', $showBorder, 0, 'C', 0);
    $pdf->Cell( 1, 0.2, '', $showBorder, 0, 'C', 0);
    $pdf->Cell( 8, 0.2, '', $showBorder, 0, 'C', 0);
    $pdf->Cell( 0, 0.2, '', $showBorder, 1, 'R', 0);
}
$pdf->Cell( 0, 0.2, $lineaFooter, $showBorder, 1, 'C', 0 );
// 
$pdf->Cell( 1, 0.2, '', $showBorder, 0, 'L', 0);
$pdf->Cell( 8, 0.2, 'ENCARGADO DE REGISTRO Y CONTROL', $showBorder, 0, 'C', 0);
$pdf->Cell( 1, 0.2, '', $showBorder, 0, 'C', 0);
$pdf->Cell( 8, 0.2, 'ENCARGADO DE TESORERIA', $showBorder, 0, 'C', 0);
$pdf->Cell( 0, 0.2, '', $showBorder, 1, 'R', 0);
// 
$pdf->Line(  $x1                ,  $y1                 , ($x1 + $widthFooter),  $y1                  );
$pdf->Line( ($x1 + $widthFooter),  $y1                 , ($x1 + $widthFooter), ($y1 + $heigthFooter) );
$pdf->Line( ($x1 + $widthFooter), ($y1 + $heigthFooter),  $x1                , ($y1 + $heigthFooter) );
$pdf->Line(  $x1                , ($y1 + $heigthFooter),  $x1                ,  $y1                  );
// 
$pdf->Line( ( ($x1 + $widthFooter) / 2 ), $y1, ( ($x1 + $widthFooter) / 2 ), ( $y1 + $heigthFooter ));
// 
$pdf->Line( $x1, ( ($y1 + $heigthFooter) - 0.4 ), ($x1 + $widthFooter), ( ($y1 + $heigthFooter) - 0.4 ));
    // 
// $pdf->Cell( 0, 0.2, '', $showBorder, 1, 'C');
$pdf->Output();

// $pdf->Cell( 0, 0.2, '', $showBorder, 0, 'C');


?>