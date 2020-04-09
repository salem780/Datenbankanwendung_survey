<?php
include "db_connection.php";
session_start();

//Eingaben der Inputfelder auslesen
$s_title = $_POST["s_title"];
$s_token = $_POST["s_token"];
$number_of_questions = $_POST["number_of_questions"];

//vor Injection schützen
$s_title = $db->real_escape_string($s_title);
$s_token = $db->real_escape_string($s_token);

//Variable global verfügbar machen, um in send_questions.php Zugriff zu ermöglichen
$_SESSION["s_token"] = $s_token;

//Enfügen der Inputfelderdaten in die Tabelle Survey
if(!$db->query("insert into survey (s_token, s_title, username) values ('".$s_token."', '".$s_title."', 'username')")){
echo 'Fehler beim Ausführen des SQL Befehls';
}else{
echo 'nice';
}

//Einfügen der Information, für welche(n) Kurs(e) der Fragebogen freigeschaltet ist
foreach ($_POST['course'] as $c_token) {
    $db->query("insert into activation(c_token, s_token) values ('".$c_token."', '".$s_token."')");
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Datenbanken Survey</title>
  </head>
  <body>
  <h1>Hier bitte die Fragen erfassen: </h1>
<!-- Formular, um Fragen zu erfassen
     Dynamische Erzeugung der Felder durch for Schleife -->
<form action="send_questions.php" method="post">
      <?php
      for($i=1; $i <= $number_of_questions; $i++){
      echo "<label for='text'>Frage $i </label> <br>
      <textarea id='text' name='questions[]' cols='50' rows='4'></textarea> <br> <br>";
      }
      ?>
      <input type="submit" value="Fragen abschicken" />
</form>
  </body>
</html>