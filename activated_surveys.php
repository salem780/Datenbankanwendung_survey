<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fragebogen</title>
  </head>
  <?php
//Author:Alissa Templin
//Erstellen einer Liste aller Fragebögen, die für den jeweiligen Studenten (MNR) zur Beantwortung freigeschaltet sind
include "db_connection.php";
include 'session_student.php';
include 'functions.php';
$mnr = $_SESSION['mnr'];

//Name des Studenten ermitteln
$sql    = $db->query("Select student_name from student WHERE mnr = '" . htmlentities($mnr) . "';");
$result = mysqli_fetch_assoc($sql);
$name   = $result["student_name"];

?>
 <body>
    <form method="POST" action="rate_questions2.php">
           <?php
        echo "<h1>Hallo " . htmlentities($name) . "</h1>";

        //Prüfen, ob es für die eingegebene MNR freigeschaltete Fragebögen gibt
        if (check_mnr($db, $mnr)) {
            echo "<label>Wähle einen Fragebogen aus, den du bewerten möchtest:</label> <br><br>";
            while ($row = mysqli_fetch_assoc($_SESSION['survey_active'])) {
                //Fragebogenliste mit Radiobuttons ausgeben
                echo "<label><input type='radio' name='survey' value=" . htmlentities($row['s_token']) . ">" . htmlentities($row['s_title']) . "</label> <br>";
            }

        } else {
            echo "Aktuell keine Fragebögen vorhanden!";
        }
        ?>

            <br>
            <!-- Buttons Beantworten und Ausloggen erzeugen-->
            <button type="submit" <?php if (!check_mnr($db, $mnr)) echo "hidden"; ?>
            name="Submit">Beantworten</button></br>
    </form>

    <br>
    <a href="logout.php">Ausloggen</a>

  </body>
</html>

