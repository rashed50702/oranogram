<?php
session_start();

// Destroy the session data
session_destroy();

// Redirect the user to the login page (index.php in your case)
header("Location: index.php");
exit;
?>
