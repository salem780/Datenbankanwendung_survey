<?php
//Author - Lea Buchhold
//Formular, um Daten für den zu erstellenden Fragebogen zu erfassen

include "session_surveyor.php";
include "db_connection.php";
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
<h1> Fragebogen erstellen </h1>

<form action="processing_create_survey.php" method="POST">
<table>
<tr>
<th> <label>Titel: </th> <th> <input type="text" name="s_title" maxlength="32" required> </label> </th>
</tr>
<tr>
<th> <label>Kürzel: </th> <th> <input type="text" name="s_token" maxlength="4" required> </label> </th>
</tr>
<tr>
<th> <label>Anzahl der Fragen:</th> <th> <input type="number" name="number_of_questions" min="1" required> </label> </th>
</tr>
</table> <br>

<label>Kurse, die an der Umfrage teilnehmen dürfen: </label> <br>
<?php
//Dynamische Erzeugung von Checkboxen und Labels nach der Anzahl der bestehenden Kurse
while($row = mysqli_fetch_assoc($courses)){
echo "<label><input type='checkbox' name='course[]' value=".$row['c_token'].">".htmlentities($row['c_token'])."</label> <br>";
}
?> <br>
<input type="submit" name="submit_survey" value="Fragebogen erstellen">
</form>
  </body>
</html>