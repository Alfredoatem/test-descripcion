<?
session_start();
if ($_SESSION["authsialma"] == "si" && $_SESSION["sialmarol"] == "admin"){}
else{
?>
<script> parent.location.href='../logout.php' </script>
<?
exit();
}
?>