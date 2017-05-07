<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

session_unset();
// Destroying All Sessions
if(session_destroy())
{
// Redirecting To Home Page
    header("Location: index.php");
}
?>