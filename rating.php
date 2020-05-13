<?php
//Author - Salina Moser
//Formular, um kursweise eine Auswertung durchzuführen und anzuzeigen
include_once 'db_connection.php';
include 'session_surveyor.php';
include_once 'includes/question_class.php';
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Ergebnisauswertung</h1>
<div class="grid-container">
<div class="grid-item">
<?php

//Username in Variable speichern
$username = $_SESSION["username"];
echo '<a>Willkommen zu deiner Auswertung </a>';
echo $_SESSION['username'];

// Alle Fragebögentitel auslesen, die ein User erstellt hat und die bereits beantwortet wurden
$surveys = $db->query("select distinct s.s_title from survey s, answered an where an.status = '1' AND s.username = '$username' AND an.s_token = s.s_token ;");

//Dropdown zur Titelauswahl
echo "<form action='rating.php' method='POST'>";
echo "<select name='surveytitles'  required>";
while($row = mysqli_fetch_assoc($surveys)){
echo "<option name= 'title' value = ".$row['s_title'].">".htmlentities($row['s_title'])."</option>";}
echo "<input type='submit' name='titlesearch' value='Suchen' />";

//Titel in Sessionvariable speichern
if(isset($_POST["titlesearch"])){
$selected_survey = htmlentities($_POST['surveytitles']);
$_SESSION["surveytitles"] = $selected_survey;
//Surveytoken in Sessionvariable speichern
$surveytoken = $db->query("select s_token from survey where s_title = '".$_SESSION['surveytitles']."';");
$result = mysqli_fetch_assoc($surveytoken);
$_SESSION['s_token'] = htmlentities($result["s_token"]);

//Kurse auslesen, die für diesen Fragebogenkürzel freigeschaltet sind
$coursetoken = $db->query("select distinct c_token from student s, answered an where an.status = '1'AND an.mnr = s.mnr AND an.s_token ='".$_SESSION['s_token']."' ;");
//Dropdown zur Kursauswahl
echo "<select name='coursetoken'>";
while($row = mysqli_fetch_assoc($coursetoken)){
echo "<option name= 'title' value = ".$row['c_token'].">".htmlentities($row['c_token'])."</option>";
}
echo "<input type='submit'  name='coursesearch', value='Suchen'/>";
echo "</select></form>";

//Fragen des Fragebogens aus DB holen
$questions = $db->query("select id from rating where s_token ='".$_SESSION['s_token']."' ;");
}
//Ausgeben der Auswertung zum ausgewählten Fragebogen und Kurs
if(isset($_POST["coursesearch"])){
//Coursetoken in Sessionvariable speichern
$selected_course = htmlentities($_POST['coursetoken']);
$_SESSION["coursetoken"] = $selected_course;
echo"<br>
<br>";

//ausgewählten Fragebogen und Kurs anzeigen lassen
echo "<label for='text'><b>Umfragetitel<b>: " .$_SESSION["surveytitles"]. "</label> <br>";
echo "<label for='text'><b>Befragter Kurs<b>: " .$_SESSION["coursetoken"]. "</label> <br>";
//Tabelle erzeugen
echo "<form action='rating.php' method='POST'>";
echo "<table id='resulttable' , border='1' , width='100%'>";
echo "<h2>Fragebogenauswertung</h2>";
echo "<tr>";
echo "<th>Id</th>";
echo "<th>Frage</th>";
echo "<th>Durchschnitt</th>";
echo "<th>Max</th>";
echo "<th>Min</th>";
echo "<th>Standardabweichung</th>";
echo "</tr>";

//Konstruktor aufrufen um Fragenergebnisse sowie Kommentarliste zu erzeugen und Sessionvariablen übergeben
$evaluation = new Evaluation ($_SESSION['s_token'], $_SESSION["coursetoken"]);

//Dynamische Erzeugung von Tabellenzeilen nach der Anzahl der existierenden Fragen
//alle Fragen und Berechnungen des Fragebogens durch Methodenaufruf ausgeben
$result = mysqli_query ($db, "select id, text from question WHERE s_token ='".$_SESSION['s_token']."';");
while ($row = mysqli_fetch_assoc($result))
{
echo '<tr> <td> '. htmlentities($row["id"]). '</td>';
echo '<td> '. htmlentities($row["text"]). '</td>';
$q_result= $evaluation->get_results(htmlentities($row["id"]));

echo '<td>' .round($q_result->average,2).'</td>';
echo '<td>' . $q_result->min . '</td>';
echo '<td>' . $q_result->max . '</td>';
echo '<td>' . round($q_result->std_deviation,2) . '</td>';
echo '</tr>';
}
echo "</table></form>";

//Kommentarliste ausgeben
echo $evaluation->get_comments($db);
}
?>
</div>
<a href='surveyor_logged.php'> Zurück zur Startseite</a>
</div>
</body>
</html>