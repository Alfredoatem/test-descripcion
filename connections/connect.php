<?
try {
	$db = new PDO("informix:DSN=ifxsiaf", "informix", "informix");
  $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);

}catch(PDOException $e){
	 echo 'Falla de Conexion: ' . $e->getMessage();
}
?>