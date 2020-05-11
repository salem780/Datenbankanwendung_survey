<?php
 //Author - Peter Metzger
 //Kursübersicht
include "db_connection.php";
include "session_surveyor.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kursübersicht</title>
  </head>
  <body>
<h1>Alle Kurse auf einem Blick</h1><br>
<form method="POST" action="new_student.php">
<label>Einen Kurs anwählen, um die Studenten anzusehen und neue hinzuzufügen.</label> <br><br>
<?php
//Löschen der Kurs Sessionvariable, damit ein Kurs ausgewählt werden muss
 unset($_SESSION['c_token']);
//Dynamische Erzeugung von Radiobuttons und Labels nach der Anzahl der bestehenden Kurse
$courses = $db->query("select c_token from course;");
while($row = mysqli_fetch_assoc($courses)){
echo "<label><input type='radio' name='course[]' value=".$row['c_token'].">".htmlentities($row['c_token'])."</label> <br>";
}
?> <br>
<button type="submit" name="submit">Diesen Kurs bearbeiten</button></br>
</form>
<p>Hier gehts zurück zum <a href='new_course.php'>Kurs erstellen</a> und hier zur <a href='surveyor_logged.php'>Startseite</a>.</p>
  </body>
</html>