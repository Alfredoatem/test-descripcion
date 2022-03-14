<?php
session_start();
require('fpdf.php');
require('../../resources/phps/n2l.php');

$showBorder     = 0;
$SUMAtotal      = 0;

// $txtfecha       =;
// $txthtd         =;
// $txtpedi        =;
// $txtcmpbte      =;
// $txtordencom    =;
// $txtsoli        =;
// $txtdir         =;
// $txtunidad      =;
// $txtcoti        =;
// $txtfechaaviso  =;
// $txtempresa     =;
// $txtfactura     =;
// 
$alturaDatosTabla = 0.5;
$isPainted = False;

class PDF extends FPDF
{
    function Header()
    {
        $showBorder     = 0;

        $dcto           = 'LC';
        $nro            = '1';

        $ciudad         = 'La Paz';
        $titulo         = 'ingreso';

        $txtfecha       = '29/03/2021';
        $txthtd         = 'SBC00079';
        $txtpedi        = '44';
        $txtcmpbte      = 'R-';
        $txtordencom    = '000000001';
        $txtsoli        = 'SOF. MARCO ANTONIO CHIPANA QUISPE';
        $txtdir         = 'DIRECCION GRAL DE ASUNTOS ADMINISTRATIVOS';
        $txtunidad      = 'DIRECCION GRAL DE ASUNTOS ADMINISTRATIVOS';
        $txtcoti        = 'LIC. SERGIO PEREZ';
        $txtfechaaviso  = '';
        $txtempresa     = 'CLAUDIA SOFIA RIOJA SELUM';
        $txtfactura     = '00008/00009';

        // 

        $this->SetFont('Courier','',5);
        $this->SetFillColor(0, 0, 0);
        $this->Cell( 0, 0.2, 'MINISTERIO DE DEFENSA NACIONAL', $showBorder, 1, 'L');
        // $this->Ln(0);
        $this->Cell( 0, 0.2, 'No.Dcto: ' . $dcto . '-' . $nro, $showBorder, 1, 'C');
        // $this->Ln(0);
        $this->Cell( 3, 0.2, 'Dir.Gral.Asuntos Administ.', $showBorder, 0, 'C');
        $this->Cell( 0, 0.2, 'Pag.No.: ' . $this->PageNo(), $showBorder, 1, 'R');
        $this->Cell( 3, 0.2, 'Unidad Administrativa', $showBorder, 1, 'C');
        $this->Cell( 3, 0.2, 'Almacenes', $showBorder, 1, 'C');
        $this->Cell( 3, 0.2, $ciudad . ' - Bolivia', $showBorder, 1, 'C');
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C', 0);
        $this->Cell( 0, 0.2, 'COMPROBANTE DE ' . strtoupper($titulo) . ' A ALMACENES', $showBorder, 1, 'C');
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C', 0);
        // FECHA
        $this->Cell( 2, 0.2, 'Fecha', $showBorder, 0, 'L');
        $this->Cell( 0, 0.2, ': ' . $txtfecha, $showBorder, 1, 'L');
        // HTD
        $this->Cell( 2, 0.2, 'H.T.D.', $showBorder, 0, 'L');
        $this->Cell( 5, 0.2, ': ' . $txthtd, $showBorder, 0, 'L');
        // PEDIDO No
        $this->Cell( 2, 0.2, 'PEDIDO No.', $showBorder, 0, 'L');
        $this->Cell( 2, 0.2, ': ' . $txtpedi, $showBorder, 0, 'L');
        // CMPBTE.PAGO>
        $this->Cell( 1.5, 0.2, 'CMPBTE.PAGO', $showBorder, 0, 'L');
        $this->Cell( 3.5, 0.2, ': ' . $txtcmpbte, $showBorder, 0, 'L');
        // ORDEN COMPRA
        $this->Cell( 1.5, 0.2, 'ORDEN COMPRA', $showBorder, 0, 'L');
        $this->Cell( 0, 0.2, ': ' . $txtordencom, $showBorder, 1, 'L');
        // SOLICITADO
        $this->Cell( 2, 0.2, 'SOLICITADO POR', $showBorder, 0, 'L');
        $this->Cell( 5, 0.2, ': ' . $txtsoli, $showBorder, 0, 'L');
        // ADQUISICION
        $this->Cell( 0, 0.2, 'ADQUISICION DE TONERS PARA EL MINISTERIO DE DEFENSA', $showBorder, 1, 'C');
        // DIRECCION
        $this->Cell( 2, 0.2, 'DIRECCION', $showBorder, 0, 'L');
        $this->Cell( 5, 0.2, ': ' . $txtdir, $showBorder, 0, 'L');
        // UNIDAD Y/O AREA
        $this->Cell( 2, 0.2, 'UNIDAD Y/O AREA', $showBorder, 0, 'L');
        $this->Cell( 0, 0.2, ': ' . $txtunidad, $showBorder, 1, 'L');
        // COTIZADO
        $this->Cell( 2, 0.2, 'COTIZADO POR', $showBorder, 0, 'L');
        $this->Cell( 14, 0.2, ': ' . $txtcoti, $showBorder, 0, 'L');
        // FECHA AVISO
        $this->Cell( 1.5, 0.2, 'FECHA AVISO', $showBorder, 0, 'L');
        $this->Cell( 0, 0.2, ': ' . $txtfecha, $showBorder, 1, 'L');
        // EMPRESA
        $this->Cell( 2, 0.2, 'EMPRESA', $showBorder, 0, 'L');
        $this->Cell( 9, 0.2, ': ' . $txtempresa, $showBorder, 0, 'L');
        // FACTURA
        $this->Cell( 1.5, 0.2, 'FACTURA No.', $showBorder, 0, 'L');
        $this->Cell( 0, 0.2, ': ' . $txtfactura, $showBorder, 1, 'L');
        // 
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C', 0);
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C');
        $this->SetFillColor(115, 115, 115);
        $this->Cell( 0, (1 / 100), '', $showBorder, 1, 'C', 1);
        $this->SetFillColor(0, 0, 0);
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C');
        // 
        $this->SetFont('Courier','',5);
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
        $this->Cell( 0, 0.2, 'PRECIO TOTAL'   , $showBorder, 1, 'C', 0);
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C');
        $this->SetFillColor(115, 115, 115);
        $this->Cell( 0, (1 / 100), ''        , $showBorder, 1, 'C', 1);
        $this->SetFillColor(0, 0, 0);
        $this->Cell( 0, 0.2, '', $showBorder, 1, 'C');

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
for($i = 0; $i < 50; $i++){
    $codigo = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
    $precio = rand(pow(10, 3-1), pow(10, 3)-1);
    $cantidad = rand(pow(10, 2-1), pow(10, 2)-1);
    if($isPainted==True){
        $pdf->SetFillColor(255, 255, 255);
        $isPainted=False;
    }else{
        $pdf->SetFillColor(230, 230, 230);
        $isPainted=True;
    }
    // 
    $pdf->Cell( 2, $alturaDatosTabla, $codigo                                             , $showBorder, 0, 'C', 1);
    $pdf->Cell( 0.5, $alturaDatosTabla, ''                                                , $showBorder, 0, 'C', 1);
    $pdf->Cell( 5, $alturaDatosTabla, 'Toner descripcion random ' . $i                    , $showBorder, 0, 'L', 1);
    $pdf->Cell( 0.5, $alturaDatosTabla, ''                                                , $showBorder, 0, 'C', 1);
    $pdf->Cell( 3, $alturaDatosTabla, 'PIEZA'                                             , $showBorder, 0, 'C', 1);
    $pdf->Cell( 0.5, $alturaDatosTabla, ''                                                , $showBorder, 0, 'C', 1);
    $pdf->Cell( 2, $alturaDatosTabla, number_format($cantidad, 2, '.', ',')               , $showBorder, 0, 'C', 1);
    $pdf->Cell( 0.5, $alturaDatosTabla, ''                                                , $showBorder, 0, 'C', 1);
    $pdf->Cell( 2, $alturaDatosTabla, number_format($precio, 4, '.', ',')                 , $showBorder, 0, 'C', 1);
    $pdf->Cell( 0.5, $alturaDatosTabla, ''                                                , $showBorder, 0, 'C', 1);
    $pdf->Cell( 2, $alturaDatosTabla, number_format(($cantidad * $precio), 2, '.', ',')   , $showBorder, 0, 'R', 1);
    $pdf->Cell( 0, $alturaDatosTabla, ''                                                  , $showBorder, 1, 'C', 1);
    $SUMAtotal += ($cantidad * $precio);
}
$pdf->SetFillColor(0, 0, 0);
$pdf->SetFillColor(115, 115, 115);
$pdf->Cell( 0, (1 / 100), ''                                                , $showBorder, 1, 'C', 1);
$pdf->SetFillColor(0,0,0);
// 
$pdf->Cell( 2, 0.2, ''                                                      , $showBorder, 0, 'C', 0);
$pdf->Cell( 8, 0.2, 'T O T A L'                                             , $showBorder, 0, 'C', 0);
$pdf->Cell( 6.5, 0.2, ''                                                    , $showBorder, 0, 'C', 0);
$pdf->Cell( 2, 0.2, number_format($SUMAtotal, 2, '.', ',')                  , $showBorder, 0, 'R', 0);
$pdf->Cell( 0, 0.2, ''                                                      , $showBorder, 1, 'C', 0);
// 
$pdf->Cell( 16, (1 / 100), ''                                                , $showBorder, 0, 'C', 0);
$pdf->SetFillColor(115, 115, 115);
$pdf->Cell( 0, (1 / 100), ''                                                , $showBorder, 1, 'C', 1);
$pdf->SetFillColor(0,0,0);
// 
$pdf->Cell( 12, 0.2, n2l($SUMAtotal) . ' 00/100'                            , $showBorder, 1, 'C', 0);
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
$pdf->Cell( 8, 0.2, 'ENCARGADO DE REGISTRO Y CONTROL', $showBorder, 0, 'C', 0);
$pdf->Cell( 1, 0.2, '', $showBorder, 0, 'C', 0);
$pdf->Cell( 8, 0.2, 'ENCARGADO DE ALMACENES', $showBorder, 0, 'C', 0);
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
$pdf->Cell( 8, 0.2, 'Almacenes', $showBorder, 0, 'C', 0);
$pdf->Cell( 1, 0.2, '', $showBorder, 0, 'C', 0);
$pdf->Cell( 8, 0.2, 'Nombre y Apellido', $showBorder, 0, 'C', 0);
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