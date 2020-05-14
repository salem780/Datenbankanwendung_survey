<?php
 //Author - Peter Metzger
 //Alle Matrikelnummern eines ausgewählten Kurses und neue Matrikelnummern hinzufügen
include "db_connection.php";
include "session_surveyor.php";

if (!isset($_POST['course']) AND !isset($_SESSION['c_token'])){
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
//Falls Postvariable vorhanden, diese in $c_token speichern und Session eröffnen. Falls Postvariable nicht vorhanden, Sessionvariable in $c_token speichern.
 if (isset($_POST["course"])) {
  $course = $_POST["course"];
  $c_token = $course[0];
  $_SESSION["c_token"] = $c_token;
 } else{
  $c_token = $_SESSION['c_token'];
 }

  echo "<h4>". htmlentities($c_token) . "</h4>";

 //Matrikelnummern des Kurses in $mnr speichern
    $stmt = $db->prepare('SELECT mnr FROM Student WHERE c_token = ?');
	$stmt->bind_param('s', $c_token);
	$stmt->execute();
    $stmt->bind_result($mnr);

//Ausgeben der Daten
    while ($stmt->fetch()) {
    echo htmlentities($mnr) . "<br>";
    }

    $stmt->close();
$db->close();
?>
<br>
 <div class="wrapper-main">
                        <section class="section-default">
                        <h3>Neuen Student erstellen</h3>
                        <form class="form-signup" action="create_student.php" method="POST">
                            <input type="number" min="1000" name="mnr" placeholder="Matrikelnummer" required></br>
                            <input type="text" name="student_name" placeholder="Name" required></br>
                            <input type='text' name='c_token' value= '<?php echo htmlentities($c_token) ?>' disabled><br>
                            <button type="submit" name="submit">Erstellen</button></br></br>
                        </form>
                        </section>
                        </div>


 <p>Hier gehts zurück <a href='course.php'>zur Kursübersicht</a>.</p>

  </body>
</html>