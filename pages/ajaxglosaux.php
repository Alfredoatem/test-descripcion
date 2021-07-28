<?
require_once "seguridad.php";
require_once "../connections/connect.php";
require_once "../functions/global.php";
global $db;
$txtgest=$_POST['txtgest'];
$txtnro=$_POST['txtnro'];
$txtdcto=$_POST['txtdcto'];
$txtglosaux=$_POST['gloaux'];
try {
  if(verglosaux($txtgest,$txtdcto,$txtnro)=="1"){
    echo "<strong>No se puede agregar o actualizar Glosa Auxiliar.</strong> Ya cuenta con una!!!";
  }else{
      $sql = "INSERT INTO glosalma (dcto, nro, gloaux, gestion) VALUES ('$txtdcto','$txtnro','$txtglosaux','$txtgest')";
      $query = $db->prepare($sql);
      $query->execute();
      if($query){
          echo "Ok";
      }else{
          echo "Algo salio mal";
//        var_dump($query->errorinfo(), TRUE);
      }
  }
} catch (Exception $e) {
  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}

