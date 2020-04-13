<?php
//Author - Lea Buchhold
//Auswahl, eines Fragebogens
//Diesem Fragebogen entweder Fragen hinzufügen oder Fragen löschen

include "db_connection.php";

//alle Fragebögen auslesen, die der User erstellt hat
$surveys = $db->query("select s_title from survey where username = 'username';");
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Datenbanken Survey</title>
  </head>
  <body>
<h1> Fragen löschen oder hinzufügen </h1>

<form method="POST" action="processing_delete_or_add_questions.php">

Fragebogen auswählen:
<select name='surveys'>
<?php
//Combobox zum Auswählen des zu kopierenden Fragebogens
while($row = mysqli_fetch_assoc($surveys)){
echo "<option>".$row["s_title"]."</option>";
}
?>
</select> <br> <br>
<input type="submit" value="Fragen löschen" name="submit_delete_questions">
<input type="submit" value="Fragen hinzufügen" name="submit_add_questions">
</form>

  </body>
</html>