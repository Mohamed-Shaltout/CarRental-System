<?php
session_start();
session_destroy();
header('Location: ../modules\login.php');
exit;
?>
