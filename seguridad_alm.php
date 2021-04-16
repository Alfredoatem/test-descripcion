<?php
session_start();
if ($_SESSION["authsialma"] == "pendiente"){
}elseif($_SESSION["authsialma"] == "si"){
?>
<script> parent.location.href='pages/index.php' </script>
<?
  exit();
}else{
?>
<script> parent.location.href='index.php' </script>
<?
  exit();
}
?>