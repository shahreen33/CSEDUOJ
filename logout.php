<?php
session_start();

session_unset();
// Destroying All Sessions
if(session_destroy())
{
// Redirecting To Home Page
    header("Location: index.php");
}
?>