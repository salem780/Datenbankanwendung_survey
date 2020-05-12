<?php
 //Author - Peter Metzger
 //Registrieren eines neuen Studenten
include "db_connection.php";
include "session_surveyor.php";
include "functions.php";

//Überprüfung ob Werte vorhanden
if (!isset($_POST['mnr'], $_POST['student_name'])) {
//Fehlermeldung
	exit('Bitte das Formular komplett ausfüllen');
}

verify_input($_POST['mnr'], 8, 4, 'Die Matrikelnummer');
verify_input($_POST['student_name'], 32, 1, 'Der Name');

//Test ob Matrikelnummer bereits vorhanden und Verhinderung von SQL Injection
    $stmt = $db->prepare('SELECT * FROM Student WHERE mnr = ?');
	$stmt->bind_param('s', $_POST['mnr']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
//Fehlermeldung
		echo 'Der Student existiert bereits';
	} else {
//Neuer Student wird angelegt
    $stmt = $db->prepare('INSERT INTO Student (mnr, student_name, c_token) VALUES (?, ?, ?)');
	$stmt->bind_param('sss', $_POST['mnr'], $_POST['student_name'], $_SESSION['c_token']);
	$stmt->execute();

//Auslesen der freigeschalteten Fragebogen und Einfügen mit Status auf 0 gesetzt
    $stmt = $db->prepare('SELECT s_token FROM activation WHERE c_token = ?');
	$stmt->bind_param('s', $_SESSION['c_token']);
	$stmt->execute();
    $stmt->bind_result($result);
        while ($stmt->fetch()) {
            $s_token[] = $result;
        }
        foreach ($s_token AS $s_token) {
        $stmt = $db->prepare('INSERT INTO answered (mnr, s_token, status) VALUES (?, ?, 0)');
        $stmt->bind_param('ss', $_POST['mnr'], $s_token);
        $stmt->execute();
        }

        header("Location: new_student.php");
}
	$stmt->close();
$db->close();
?>