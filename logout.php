<?php
session_start();
session_destroy();
header("Location: ../auth/admin_login.php");
exit();
?>
<?php include('../includes/footer.php'); ?>