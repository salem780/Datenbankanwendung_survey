<?php
 //Author - Peter Metzger
 //Registrieren eines neuen Kurses
include "db_connection.php";
include "session_surveyor.php";

// Überprüfung ob Werte vorhanden
if (!isset($_POST['mnr'], $_POST['student_name'])) {
// Fehlermeldung
	exit('Bitte das Formular komplett ausfüllen');
}

// Test ob Matrikelnummer bereits vorhanden und Verhinderung von SQL Injection
if ($stmt = $db->prepare('SELECT * FROM Student WHERE mnr = ?')) {
	$stmt->bind_param('s', $_POST['mnr']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
//Fehlermeldung
		echo 'Der Student existiert bereits';
	} else {
// Neuer Student wird angelegt
if ($stmt = $db->prepare('INSERT INTO Student (mnr, student_name, c_token) VALUES (?, ?, ?)')) {
	$stmt->bind_param('sss', $_POST['mnr'], $_POST['student_name'], $_SESSION['c_token']);
	$stmt->execute();
    header("Location: course.php");
} else {
// Fehlermeldung
	echo 'Student wurde nicht angelegt';
}
	}
	$stmt->close();
} else {
//Fehlermeldung
echo 'Student wurde nicht angelegt';
}
$db->close();
?>