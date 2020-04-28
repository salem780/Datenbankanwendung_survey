<?php
include "session_surveyor.php";
?>

<!DOCTYPE html>
<!--
Author - Lea Buchhold
Übersichtsseite, die erscheint, sobald sich der Fragebogenerfasser anmeldet. -->
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Datenbanken Survey</title>
  </head>
  <body>
  <?php
  echo "<h1>Hallo ".$_SESSION['username']."</h1>";
  ?>
  <a href="create_survey.php">Fragebogen erstellen</a> <br> <br>
  <a href="delete_survey.php">Fragebogen löschen</a> <br>
  <a href="copy_survey.php">Bestehenden Fragebogen kopieren</a> <br>
  <a href="delete_or_add_questions.php">Fragen löschen oder hinzufügen</a> <br>
  <a href="rating.php">Fragebogen auswerten</a><br><br>
  <a href="new_course.php">Neuen Kurs/Studenten erstellen</a> <br> <br>
  <a href="student_login.php">Studentenlogin</a><br><br>
  <a href="logout.php">ausloggen</a>
  </body>
</html>