<?php
//Author - Lea Buchhold
//Verarbeitung der Informationen des Formulars aus der Datei copy_survey.php (Einfügen des Titels, des Kürzels etc. in diverse Tabellen)
//Kopieren der Fragen

include "session_surveyor.php";
include "db_connection.php";
include "functions.php";

//Eingaben der Inputfelder auslesen
$s_title = $_POST["s_title"];
$s_token = $_POST["s_token"];

//vor Injection schützen
$s_title = $db->real_escape_string($s_title);
$s_token = $db->real_escape_string($s_token);

//Prüfen, ob Titel bereits vergeben ist, indem eigene Funktion aufgerufen wird
if(!check_s_title($s_title, $db)){
echo "Der Titel ist bereits vergeben. <br>";
echo "<a href='copy_survey.php'>Zurück zu: Fragebogen kopieren</a> <br>";

}else{

  //Prüfen, ob Kürzel bereits vergeben ist, indem eigene Funktion aufgerufen wird
  if(!check_s_token($s_token, $db)){
    echo "Das Kürzel ist bereits vergeben.<br>";
    echo "<a href='copy_survey.php'>Zurück zu: Fragebogen kopieren</a> <br>";
   }else{

       //Prüfen, ob der Fragebogen mindestens einem Kurs zugewiesen ist
       if(!isset($_POST['course'])){
       echo "Bitte den Fragebogen für mindestens einen Kurs freischalten.<br>";
       echo "<a href='copy_survey.php'>Zurück zu: Fragebogen kopieren</a> <br>";
       }else{
            $selected_survey = $_POST['surveys'];

            //Kürzel des ausgewählten Fragebogens selektieren
            $s_token_selected = $db->query("select s_token from survey where s_title = '".$selected_survey."';");
            $s_token_selected = mysqli_fetch_assoc($s_token_selected);
            $s_token_selected = $s_token_selected["s_token"];


            //Einfügen der Inputfelderdaten in die Tabelle Survey
            if(!$db->query("insert into survey (s_token, s_title, username) values ('".$s_token."', '".$s_title."', '".$_SESSION['username']."');")){
            echo 'Fehler beim Einfügen in die Tabelle Survey';
            }

            //Einfügen der Information, für welche(n) Kurs(e) der Fragebogen freigeschaltet ist
            //Auslesen der freigeschalteten Studenten und Einfügen der Statusinformation für die freigeschalteten Studenten
            foreach ($_POST['course'] as $c_token) {
                $db->query("insert into activation(c_token, s_token) values ('".$c_token."', '".$s_token."');");
                $result = $db->query("select MNR from student where c_token = '".$c_token."';");
                while($row = mysqli_fetch_assoc($result)){
                $db->query("insert into answered (MNR, s_token, status) values ('".$row["MNR"]."', '".$s_token."', 0);");
                }
            }

            //Speichern der Fragen des zu kopierenden Fragebogens
            if(!$questions = $db->query("select id, text from question where s_token = '".$s_token_selected."';")){
            echo "Fehler beim Auslesen der Fragen";
            }

            //Einfügen der Fragen
            while($row = mysqli_fetch_assoc($questions)){
            $db->query("insert into question (id, text, s_token) values ('".$row["id"]."', '".$row["text"]."', '".$s_token."');");
            }


            echo "Der Fragebogen wurde kopiert. <br>";
            echo "<a href='delete_or_add_questions.php'>Hier können Sie Fragen löschen oder hinzufügen</a> <br>";
            echo "<a href='surveyor_logged.php'> Zurück zur Startseite</a>";

            }

       }
    }

?>