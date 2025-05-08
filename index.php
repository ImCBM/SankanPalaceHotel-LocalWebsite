<?php
// Start the session
session_start();
// Redirect to the home page
header("Location: views/home.php");
exit();
?>