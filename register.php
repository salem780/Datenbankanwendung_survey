<?php
 //Author - Peter Metzger
 //Registrieren eines Befragers anahnd eines Benutzernamens, eines Passworts und einer Passwort wiederholen Überprüfung
include "db_connection.php";

// Überprüfung ob Werte vorhanden
if (!isset($_POST['username'], $_POST['password'])) {
// Fehlermeldung
	exit('Bitte das Registerformular komplett ausfüllen');
}
//Überprüfen ob Passwort zwischen 5 und 20 Zeichen hat
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
// Fehlermeldung
	exit('Passwort muss zwischen 5 und 20 Zeichen haben');
}
// Überprüfung ob Passwort gleich
if (!($_POST['password'] === $_POST['re-password'])) {
// Fehlermeldung
	exit ('Passwörter stimmen nicht überein');
}
// Test ob Username bereits vorhanden und Verhinderung von SQL Injection
if ($stmt = $db->prepare('SELECT * FROM Surveyor WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
//Fehlermeldung
		echo 'Der Benutzername existiert bereits';
	} else {
// Neuer Account wird angelegt
if ($stmt = $db->prepare('INSERT INTO Surveyor (username, password) VALUES (?, ?)')) {
// Password wird gehasht
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$stmt->bind_param('ss', $_POST['username'], $password);
	$stmt->execute();
	echo 'Du wurdest erfolgreich registriert. Hier geht es zum <a href="index.php">LogIn</a>';
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