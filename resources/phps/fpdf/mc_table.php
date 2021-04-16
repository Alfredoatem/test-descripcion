<?php

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;
var $colors;

function Header()
{
	//Introducir Cabecera
}
function SetWidths($w)
{
	//Arreglo con dimensiones
	$this->widths=$w;
}

function SetAligns($a)
{
	//Arreglo con alineciones
	$this->aligns=$a;
}

function SetColor($c)
{
	//Colores
	$this->colors=$c;
}
function SetFonts($f)
{
	//Fuentes
	$this->fuentes=$f;
}
function Row($data)
{
	//Calcula el Alto de la Fila
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=3.5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'J';
		$c=isset($this->colors[$i]) ? $this->colors[$i] : 'D';
		$f=isset($this->fuentes[$i]) ? $this->fuentes[$i] : 'Arial;;8';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		$this->Rect($x,$y,$w,$h,$c);
		//Print the text
		//$sf=explode(';',$f);
		//$this->SetFont($sf[0],$sf[1],$sf[2]);
		$this->MultiCell($w,3.5,$data[$i],0,$a);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		{
		$this->AddPage($this->CurOrientation);
		$this->SetX(15);
		}
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}
}
?>
