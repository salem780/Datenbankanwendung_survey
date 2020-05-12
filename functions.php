<?php

//Author - Lea Buchhold
//Prüfen, ob Titel bereits vergeben ist
function check_s_title($s_title, $db){
$check_s_title = $db->query("select s_title from survey where s_title = '".$s_title."';");
$number_of_rows = $check_s_title->num_rows;
if($number_of_rows > 0){
  //Falsch zurückgeben, wenn Titel bereits vergeben ist
  return false;
  }else{
  return true;
  }
}

//Author - Lea Buchhold
//Prüfen, ob Kürzel bereits vergeben ist
function check_s_token($s_token, $db){
$check_s_token = $db->query("select s_token from survey where s_token = '".$s_token."';");
$number_of_rows = $check_s_token->num_rows;
if ($number_of_rows > 0){
  //Falsch zurückgeben, wenn Kürzel bereits vergeben ist
  return false;
  }else{
  return true;
  }
}

//Author - Peter Metzger
//Bewertung für Frage eintragen
function inject_rating($mnr, $question_number, $s_token, $points){
    include "db_connection.php";
        //Bisheriges Rating löschen
        $stmt = $db->prepare('DELETE from Rating where mnr = ? AND id = ? AND s_token = ?;');
        $stmt->bind_param('sss', $mnr, $question_number, $s_token);
        $stmt->execute();
        //Neuen Antwortwert speichern
        $stmt = $db->prepare('INSERT INTO Rating (MNR, ID, s_token, a_value) VALUES (?, ?, ?, ?);');
        $stmt->bind_param('ssss', $mnr, $question_number, $s_token, $points);
	    $stmt->execute();
    $stmt->close();
$db->close();
}

//Author - Peter Metzger
//Belegung des Kommentarfelds am Ende eines Fragebogens
function inject_comment($comment, $mnr, $s_token){
    include "db_connection.php";
        $stmt = $db->prepare('UPDATE Answered SET comment = ? WHERE mnr = ? AND s_token = ?;');
	    $stmt->bind_param('sss', $comment, $mnr, $s_token);
	    $stmt->execute();
    $stmt->close();
$db->close();
}

//Author - Peter Metzger
//Fragebogen als abgeschlossen markieren
function set_status($mnr, $s_token, $comment){
    include "db_connection.php";
          $stmt = $db->prepare('UPDATE Answered SET status = 1 WHERE mnr = ? AND s_token = ?;');
    	  $stmt->bind_param('ss', $mnr, $s_token);
    	  $stmt->execute();
    $stmt->close();
$db->close();
}

//Author - Alissa Templin
//Abfrage der freigeschalteten Fragebögen für die eingegebene MNR
function check_mnr($db, $mnr){
$_SESSION['survey_active'] = $db->query("Select * from answered, survey WHERE answered.s_token = survey.s_token AND answered.status = '0' AND answered.mnr = $mnr;");
$num_of_rows = $_SESSION['survey_active']->num_rows;
if ($num_of_rows > 0) {
return true;
}else{
return false;}
}

//Author - Peter Metzger
//Eingabe verifizieren anhand eines oberen und unteren limits und individuelle Fehlermeldung
function verify_input($input, $u_limit, $d_limit, $description){
    if (strlen($input) > $u_limit || strlen($input) < $d_limit) {
         //Fehlermeldung
         return exit('Ungültige Eingabe. '.$description.' muss zwischen '.$d_limit.' und '.$u_limit.' Zeichen haben');

    } else
    {
        return true;
    }
}
?>