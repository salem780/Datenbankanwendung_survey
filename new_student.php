<?php
 //Author - Peter Metzger
 //Alle Matrikelnummern eines ausgewählten Kurses und neue Matrikelnummern hinzufügen Felder
include "db_connection.php";
include "session_surveyor.php";

if (!isset($_POST['course'])){
//Fehlermeldung
	exit('Bitte einen Kurs auswählen');
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Neuen Studenten anlegen</title>
  </head>
  <body>
<h1>Alle Studenten auf einen Blick</h1>

<?php
//Abfrage des eingegebenen Kurses, um Matrikelnummern anzuzeigen
 $course = $_POST["course"];
 $c_token = $course[0];
 $_SESSION["c_token"] = $c_token;
 $mnr = $db->query("select mnr from student where c_token = '".$c_token."';");

 echo "<h4>$c_token</h4>";

//Ausgeben der Daten
while($row = mysqli_fetch_assoc($mnr)) {
  echo $row["mnr"] . "<br>";
 }
?>
<br>
 <div class="wrapper-main">
                        <section class="section-default">
                        <h3>Neuen Student erstellen</h3>
                        <form class="form-signup" action="create_student.php" method="POST">
                            <input type="text" name="mnr" placeholder="Matrikelnummer" required></br>
                            <input type="text" name="student_name" placeholder="Name" required></br>
                            <?php echo "<input type='text' name='c_token' value='$c_token' disabled><br>";?>
                            <button type="submit" name="submit">Erstellen</button></br></br>
                        </form>
                        </section>
                        </div>


 <p>Hier gehts zurück <a href='course.php'>zur Kursübersicht</a>.</p>

  </body>
</html>