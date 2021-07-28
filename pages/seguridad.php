<?php
session_start();
if ($_SESSION["authsialma"] == "si"){
}elseif($_SESSION["authsialma"] == "pendiente"){
?>
<script> parent.location.href='../../autalma.php' </script>
<?php
  exit();
}else{
?>
<script> parent.location.href='../index.php' </script>
<?php
  exit();
}
?>