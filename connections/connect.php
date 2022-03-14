<?php
  session_start();
  try {
    $db = new PDO("informix:DSN=ifxsiaf", "informix", "informix");
    $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //    $db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );

  }catch(PDOException $e){
    echo 'Falla de Conexion: ' . $e->getMessage();
  }
?>