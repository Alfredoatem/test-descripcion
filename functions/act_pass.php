<?
include "../pages/seguridad.php"; 
include("../connections/connect.php");
include("global.php");

if($_POST['newpass2']!=''){
	$qr = $db->prepare("SELECT contrasena FROM userweb WHERE codper='".$_SESSION['haberpcod']."'");
	$qr->execute();
	$rs = $qr->fetch(PDO::FETCH_ASSOC);
	
	$filapass = trim($rs['contrasena']);
	$oldpass = md5($_POST['oldpass']);
	$newpass2 = md5($_POST['newpass2']);
	
	if($filapass==$oldpass && $newpass2!=md5('MINDEF2012')){
		$upd = $db->prepare("UPDATE userweb SET contrasena='$newpass2' WHERE codper='".$_SESSION['haberpcod']."'");
		$upd->execute();
		?>
		<script>
		alert("Password Cambiado Correctamente");
		document.location='../logout.php'
		</script> 
		<?
	}
	elseif($newpass2==md5('MINDEF2012'))
	{ 
	?>
		<script>
		alert("Password INCORRECTO!! Intente con otro");
		history.go(-1);
		</script>
	<?
	}
	else
	{
	?>
		<script language="JavaScript" type="text/javascript">
		alert("Su Password no coincide con el Antiguo");
		history.go(-1);
		</script>
	<?
	}
}
?> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Password - Change</title>
<link rel="stylesheet" href="../recursos/estilos/gralestilo.css" type="text/css" />
<script type="text/javascript">
<!--
function validar(){
	if (document.formpass.oldpass.value==""){
	alert("Introduzca su Password Antiguo")
	document.formpass.oldpass.focus()
	return 0;
	}
	if (document.formpass.newpass1.value==""){
	alert("Introduzca Su Nuevo Password")
	document.formpass.newpass1.focus()
	return 0;
	}
	if (document.formpass.newpass2.value!=document.formpass.newpass1.value){
	alert("No Coincide con el Nuevo Password")
	document.formpass.newpass2.focus()
	return 0;
	}
	document.formpass.submit();
}
//-->
</script>

</head>

<body>
<br>
<form name="formpass" method="post" action="act_pass.php" class="forma">
<table align="center" cellpadding="2" cellspacing="1">
  <tr>
    <td width="150"> Password  Antiguo: </td>
    <td width="150">
      <input name="oldpass" type="password" id="oldpass">    </td>
  </tr>
  <tr>
    <td>Nuevo Password :  </td>
    <td><input name="newpass1" type="password" id="newpass1"></td>
  </tr>
  <tr>
    <td>Confirmar Password : </td>
    <td><input name="newpass2" type="password" id="newpass2"></td>
  </tr>
  <tr>
    <td height="40" colspan="2" align="center"><input name="boton" type="button" id="boton" onClick="validar()" value="Cambiar"></td>
    </tr>
</table>
</form>
</body>
</html>
