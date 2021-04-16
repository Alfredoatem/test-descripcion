<?php
session_start();
if ($_SESSION["authsialma"] == "si"){
}elseif($_SESSION["authsialma"] == "pendiente"){
?>
<script> parent.location.href='../../autalma.php' </script>
<?
  exit();
}else{
?>
<script> parent.location.href='../index.php' </script>
<?
  exit();
}
?>