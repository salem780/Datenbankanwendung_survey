<?php
 //Author: Peter Metzger
 //Ausloggen
session_start();
session_destroy();

echo 'Logout erfolgreich. Hier kommen Sie wieder zum Befrager <a href="index.php">LogIn</a> und hier zum Studenten <a href="student_login.php">LogIn</a>';
?>