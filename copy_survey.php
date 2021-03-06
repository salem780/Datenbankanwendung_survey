<?php
//Author - Lea Buchhold
//Formular, um Daten für den zu kopierenden Fragebogen zu erfassen (Neuer Titel, neues Kürzel, zugewiesene Kurse)

include "session_surveyor.php";
include "db_connection.php";

//alle Fragebögen auslesen, die der User erstellt hat
$surveys = $db->query("select s_title from survey where username = '".$_SESSION['username']."';");

//Prüfen, ob ein Fragebogen erstellt wurde
if($surveys->num_rows == 0){
echo "Sie haben noch keinen Fragebogen erstellt!<br>";
echo "<a href='create_survey.php'>Einen Fragebogen erstellen</a><br>";
echo "<a href='surveyor_logged.php'>Zurück zur Startseite</a>";
exit;
}

//Kurse auslesen:
$courses = $db->query("select c_token from course;");

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Datenbanken Survey</title>
  </head>
  <body>
<h1> Fragebogen kopieren </h1>

<form method="POST" action="processing_copy_survey.php">
<table>
<tr>
<th>Fragebogen auswählen: </th>
<th> <select name='surveys'>
<?php
//Combobox zum Auswählen des zu kopierenden Fragebogens
while($row = mysqli_fetch_assoc($surveys)){
echo "<option>".htmlentities($row["s_title"])."</option>";
}
?>
</select>
</th>
</tr>
<tr>
<th> <label>Neuer Titel: </th> <th> <input type="text" name="s_title" maxlength="32" required> </label> </th>
</tr>
<tr>
<th> <label>Neues Kürzel: </th> <th> <input type="text" name="s_token" maxlength="4" required> </label> </th>
</tr>
</table> <br>

<label>Kurse, die an der Umfrage teilnehmen dürfen: </label> <br>
<?php
//Dynamische Erzeugung von Checkboxen und Labels nach der Anzahl der bestehenden Kurse
while($row = mysqli_fetch_assoc($courses)){
echo "<label><input type='checkbox' name='course[]' value=".$row['c_token'].">".htmlentities($row['c_token'])."</label> <br>";
}
?> <br>
<input type="submit" value="Fragebogen kopieren" name="submit_copy">
</form>
  </body>
</html>
