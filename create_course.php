<?php
 //Author - Peter Metzger
 //Registrieren eines neuen Kurses
include "db_connection.php";
include "session_surveyor.php";

// Überprüfung ob Werte vorhanden
if (!isset($_POST['c_token'], $_POST['c_name'])) {
// Fehlermeldung
	exit('Bitte das Formular komplett ausfüllen');
}

// Test ob Kurskürzel bereits vorhanden und Verhinderung von SQL Injection
if ($stmt = $db->prepare('SELECT * FROM Course WHERE c_token = ?')) {
	$stmt->bind_param('s', $_POST['c_token']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
//Fehlermeldung
		echo 'Das Kurskürzel existiert bereits';
	} else {
// Neuer Kurs wird angelegt
if ($stmt = $db->prepare('INSERT INTO Course (c_token, c_name) VALUES (?, ?)')) {
	$stmt->bind_param('ss', $_POST['c_token'], $_POST['c_name']);
	$stmt->execute();
	echo 'Der Kurs wurde erfolgreich erstellt. Hier gehts <a href="course.php">zur Kursübersicht</a>.';
} else {
// Fehlermeldung
	echo 'Registrierung wurde nicht abgeschlossen';
}
	}
	$stmt->close();
} else {
//Fehlermeldung
echo 'Registrierung wurde nicht abgeschlossen';
}
$db->close();
?>