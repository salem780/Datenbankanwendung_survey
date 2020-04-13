<?php
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

<form action="db_create_survey.php" method="POST">
<table>
<tr>
<th> <label>Titel: </th> <th> <input type="text" name="s_title" required> </label> </th>
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
while(($row = $courses->fetch_object()) != false) {
echo "<label><input type='checkbox' name='course[]' value='$row->c_token'>$row->c_token</label> <br>";
}
?> <br>
<input type="submit" value="Fragebogen erstellen">
</form>
  </body>
</html>