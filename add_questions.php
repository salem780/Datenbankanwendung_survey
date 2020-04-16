<?php
//Author - Lea Buchhold
//Verarbeitung des Formulars der Datei processing_delete_or_send_added_questions.php (Erzeugung der Felder für die hinzuzufügende Fragen)

include "session_surveyor.php";

//Zufriff durch Eingabe der Datei in der URL verhindern
if (!isset($_POST["add_number_of_questions"])) {
    echo "<a href='surveyor_logged.php'> Zurück zur Startseite</a><br>";
	exit("So geht das aber nicht!");
}

include "db_connection.php";

$number_of_questions = $db->real_escape_string($_POST["number_of_questions"]);

 echo "<form action='send_added_questions.php' method='post'>";
          for($i=1; $i <= $number_of_questions; $i++){
          echo "<label for='text'>Frage $i </label> <br>
          <textarea id='text' name='questions[]' cols='50' rows='4' required></textarea> <br> <br>";
          }
          //Verstecktes Inputfeld, um Umfragenkürzel mit zu übergeben
          echo "<input type='hidden' name='s_token' value=".$_POST["s_token"].">";
          echo "<input type='submit' value='Fragen hinzufügen' name='send_added_questions'/></form>";

?>