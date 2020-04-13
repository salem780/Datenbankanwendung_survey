<?php
//Author - Lea Buchhold
//Verarbeitung des Formulars der Datei processing_delete_or_send_added_questions.php (Erzeugung der Felder für die hinzuzufügende Fragen)

include "db_connection.php";

$number_of_questions = $_POST["number_of_questions"];

 echo "<form action='send_added_questions.php' method='post'>";
          for($i=1; $i <= $number_of_questions; $i++){
          echo "<label for='text'>Frage $i </label> <br>
          <textarea id='text' name='questions[]' cols='50' rows='4' required></textarea> <br> <br>";
          }
          //Verstecktes Inputfeld, um Umfragenkürzel mit zu übergeben
          echo "<input type='hidden' name='s_token' value=".$_POST["s_token"].">";
          echo "<input type='submit' value='Fragen hinzufügen' name='send_added_questions'/></form>";

//}
?>