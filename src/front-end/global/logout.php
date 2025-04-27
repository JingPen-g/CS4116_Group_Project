<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy(); // Destroy the session
header("Location: login"); // Redirect to the login page
exit();
?>