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
function inject_rating($_SESSION['mnr'], $_SESSION['aktfrage'], $s_token, $a_value){
    include "db_connection.php";
        $stmt = $db->prepare('INSERT INTO Rating (MNR, ID, s_token, a_value) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $_SESSION['mnr'], $_SESSION['aktfrage'], $s_token, $a_value);
	    $stmt->execute();
}

//Author - Peter Metzger
//Belegung des Kommentarfelds am Ende eines Fragebogens
function inject_comment($_SESSION['mnr'], $s_token, $comment){
    include "db_connection.php";
        $stmt = $db->prepare('UPDATE answered SET comment = ? WHERE mnr = ? AND s_token = ?'))
	    $stmt->bind_param('sss', $comment, $_SESSION['mnr'], $s_token);
	    $stmt->execute();
}

//Author - Peter Metzger
//Fragebogen als abgeschlossen markieren
function set_status($_SESSION['mnr'], $s_token){
    include "db_connection.php";
        $stmt = $db->prepare('UPDATE answered SET status = 1 WHERE mnr = ? AND s_token = ?'))
	    $stmt->bind_param('ss', $_SESSION['mnr'], $s_token);
	    $stmt->execute();
}

?>