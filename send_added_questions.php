<?php
include "db_connection.php";

$result = $db->query("select max(id) from question where s_token = '".$_POST["s_token"]."';");
$max_id = mysqli_fetch_assoc($result);
$max_id = $max_id["max(id)"];

$new_id = $max_id + 1;
//Einfügen der Fragen
foreach ($_POST['questions'] as $question) {
    $question = $db->real_escape_string($question);
    $db->query("insert into question(id, text, s_token) values ('".$new_id."', '".$question."', '".$_POST["s_token"]."');");
    $new_id++;
}

echo "Diese Fragen wurden erfolgreich hinzugefügt: <br> <br>";
//Hinzugefügte Fragen auslesen
$question_number = 1;
$added_questions = $db->query("select text from question where s_token = '".$_POST["s_token"]."' and id > '".$max_id."';");
while($row = mysqli_fetch_assoc($added_questions)){
echo "Frage ". $question_number . ": " . $row["text"]."<br>";
$question_number++;
}

echo "<a href='surveyor_logged.php'> Zurück zur Startseite</a>";
?>