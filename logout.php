<?php // start php code block
session_start(); // start session to access session variables
session_destroy(); // destroy all session data
header('Location: login.php'); // redirect to login page
exit; // stop script execution
// end php code block
?>