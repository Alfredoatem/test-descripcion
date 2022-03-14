<?
/////// CONEXIÓN A LA BASE DE DATOS /////////
include "../../connections/connect.php";
include "../../functions/global.php";

//////////////// VALORES INICIALES ///////////////////////

$form="";
$sql="SELECT * FROM ingteso ORDER BY nro";
$query = $db->prepare($sql);
$query->execute();

///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
if(isset($_POST['ingteso']))
{
	$q=$db->query($sql)->fetch(PDO::FETCH_ASSOC);
	$sql="SELECT * FROM ingteso WHERE nro LIKE '%".$q."%' OR dcto LIKE '%".$q."%' OR inter LIKE '%".$q."%' OR obs LIKE '%".$q."%' OR fecha_v LIKE '%".$q."%' ";
    $query = $db->prepare($sql);
    $query->execute();
}
$query = $db->query($sql)->fetch(PDO::FETCH_ASSOC);

if ($query->num_rows > 0)
{
	$form.= 
	'<table class="table">
		<tr class="bg-primary">
			<td>ID ALUMNO</td>
			<td>NOMBRE</td>
			<td>CARRERA</td>
			<td>GRUPO</td>
			<td>FECHA INGRESO</td>
		</tr>';

    while($row = $query->fetch(PDO::FETCH_ASSOC))
	{
		$form.=
		'<tr>
			<td>'.$row['nro'].'</td>
			<td>'.$row['dcto'].'</td>
			<td>'.$row['inter'].'</td>
			<td>'.$row['obs'].'</td>
			<td>'.$row['fecha_v'].'</td>
		 </tr>
		';
	}

	$form.='</table>';
} else
	{
		$form="No se encontraron coincidencias con sus criterios de búsqueda.";
	}


echo $form;
?>
