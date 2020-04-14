<?php
 //Author: Peter Metzger
 //Session für Student
session_start();
if(!isset($_SESSION['mnr'])) {
    die('Bitte zuerst hier <a href="student_login.php">einloggen</a>');
}
?>