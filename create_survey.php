<?php
include "db_connection.php";
$courses = $db->query("select c_token from course;");
//$number_of_rows = $courses->num_rows;
//echo $number_of_rows;
//print_r($row);
//$array = $courses->fetch_object();
//print_r($array);
//foreach($array as $spalte=>$value){
//echo $spalte . $value;
//}


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
<th> <label>Titel: </th> <th> <input type="text" name="s_title"> </label> </th>
</tr>
<tr>
<th> <label>Kürzel: </th> <th> <input type="text" name="s_token"> </label> </th>
</tr>
<tr>
<th> <label>Anzahl der Fragen:</th> <th> <input type="number" name="number_of_questions"> </label> </th>
</tr>
</table> <br>

<label>Kurse, die an der Umfrage teilnehmen dürfen: </label> <br>
<!-- while Schleife, die alle Kurse aus der Datenbank ausliest und dementsprechend viele Checkboxen erstellt -->
<?php
while(($row = $courses->fetch_object()) != false) {
echo "<label><input type='checkbox' name='course[]' value='$row->c_token'>$row->c_token</label> <br>";
}
?> <br>
<input type="submit" value="Fragebogen erstellen">
</form>
  </body>
</html>