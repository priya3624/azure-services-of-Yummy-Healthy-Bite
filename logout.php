<?php
session_start();
session_unset();
session_destroy();
echo "<script>alert('Logout successful!');</script>";
header('Refresh: .5; URL = front.php');
exit;
?>
