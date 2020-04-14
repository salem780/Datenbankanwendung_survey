<?php
 //Author - Peter Metzger
 //Authentifizierung eines Befragers anhand des Benutzernamens und des Passwortes
include "db_connection.php";
session_start();

//Überprüfung ob Werte eingetragen
if (!isset($_POST['username'], $_POST['password'])) {
// Fehlermeldung
	exit('Bitte das Formular komplett ausfüllen');
}
//Überprüfung ob Benutzername vorhanden
if ($stmt = $db->prepare('SELECT password FROM Surveyor WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
    	$stmt->bind_result($password);
    	$stmt->fetch();
    	//Passwort wird überprüft
    	if (password_verify($_POST['password'], $password)) {
    		//Erfolgreiche Verifizierung, Session wird gestartet
    		session_regenerate_id();
    		$_SESSION['username'] = $_POST['username'];
    		header("Location: surveyor_logged.php");
    	}
    	//Fehlermeldung
    	else {
    		echo 'Falsches Passwort';
    	}
    } else {
    	echo 'Falscher Benutzername';
    }
    $stmt->close();
}
$db->close();
?>