<?php
//Author - Lea Buchhold
//Verarbeitung der Informationen des Formulars der Datei activate_survey.php (Freischaltung der Kurse für einen Fragebogen)

include "session_surveyor.php";

//Zufriff durch Eingabe der Datei in der URL verhindern
if (!isset($_POST["submit_course"])) {
    echo "<a href='surveyor_logged.php'> Zurück zur Startseite</a><br>";
	exit("So geht das aber nicht!");
}

include "db_connection.php";

 $selected_course = $_POST['courses'];
 $s_token = $_POST['s_token'];
 $s_title = $_POST['s_title'];

//Information der Freischaltung in die Tabelle activation einfügen
 $db->query("insert into activation(c_token, s_token) values ('".$selected_course."', '".$s_token."');");
//Auslesen der freigeschalteten Studenten und Einfügen der Statusinformation für die freigeschalteten Studenten
 $result = $db->query("select MNR from student where c_token = '".$selected_course."';");
 while($row = mysqli_fetch_assoc($result)){
    $db->query("insert into answered (MNR, s_token, status) values ('".$row["MNR"]."', '".$s_token."', 0);");
 }

 echo "Der Fragebogem '".htmlentities($s_title)."' wurde für den folgenden Kurs '".htmlentities($selected_course)."' erfolgreich freigeschaltet! <br>";
 echo "<a href='surveyor_logged.php'> Zurück zur Startseite</a>";

?>