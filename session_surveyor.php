<?php
 //Author: Peter Metzger
 //Session für Befrager
session_start();
if(!isset($_SESSION['username'])) {
    die('Bitte zuerst hier <a href="index.php">einloggen</a>');
}
?>
