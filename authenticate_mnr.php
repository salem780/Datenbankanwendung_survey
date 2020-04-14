<?php
 //Author - Peter Metzger
 //Authentifizierung eines Studenten anhand der Matrikelnummer
include "db_connection.php";
session_start();

// Überprüfung ob Wert eingetragen
if (!isset($_POST['mnr'])) {
// Fehlermeldung
	exit('Bitte das Formular komplett ausfüllen');
}
//Überprüfung ob Matrikelnummer vorhanden
if ($stmt = $db->prepare('SELECT mnr FROM Student WHERE mnr = ?')) {
	$stmt->bind_param('s', $_POST['mnr']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
    	//Erfolgreiche Verifizierung, Session wird gestartet
    	session_regenerate_id();
        $_SESSION['mnr'] = $_POST['mnr'];
        header("Location: activated_surveys.php");
    }
    //Fehlermeldung
    else {
    	echo 'Matrikelnummer nicht vorhanden';
    }
    $stmt->close();
}
$db->close();
?>