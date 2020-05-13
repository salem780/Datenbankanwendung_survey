<?php
//Author - Salina Moser
//Auswertungsklasse und Ergebnisklasse pro Frage zum Berechnen der einzelnen Ergebnisse und der Generierung zum Objekt "Gesamtauswertung" (Ausgabe in rating.php)
include_once 'db_connection.php';
//Klasse für das Ergebnis pro Frage
class Result {
public $id;
public $nr_answered;
public $average;
public $min;
public $max;
public $std_deviation;
}
//Klasse für die Gesamtauswertung
class Evaluation{
public $s_token;
public $c_token;
private $results;
private $comments;

//Konstruktor, der das Objekt Gesamtauswertung beim Aufruf in rating.php (line83) erzeugt
//beim Aufruf des Konstruktors werden die Kommentare aus der DB geladen und die Ergebnisse der Fragen des Fragebogens berechnet
public function __construct ($s_token, $c_token)
{
$this->s_token = $s_token;
$this->c_token = $c_token;
$db = new mysqli("localhost", "root", "", "survey");
$this->calc_result($db);


}
//Prozedur, die alle Kommentare zum Fragebogen ausliest und mit Leerzeile als Liste ausgibt
public function get_comments ($db){
$this->comments = array();
$sql = "select comment from answered a, student s WHERE a.mnr=s.mnr AND status = '1' AND c_token = '" . $this->c_token . "' AND a.s_token = '" . $this->s_token . "' ;";
$result = mysqli_query ($db, $sql);
while ($row = mysqli_fetch_assoc($result))
{
$this->comments[] = htmlentities($row["comment"]);
}
for ($x=0; $x<count($this->comments); $x++) {
echo "<p>" . $this->comments[$x] . "</p> ";

}
}

//Prozedur, welche die Frageergebnisse berechnet und diese in ein Array ablegt
private function calc_result ($db){
$this->results = array(1);
$sql = "select id, avg(a_value) as avg, min(a_value) as min, max(a_value) as max, count(id) as anz from rating r, answered a, student s WHERE r.mnr = a.mnr AND a.mnr = s.mnr AND c_token = '" . $this->c_token . "'AND a.s_token = '" . $this->s_token . "' group by id order by id;";
$result = mysqli_query ($db, $sql);
while ($row = mysqli_fetch_assoc($result))
{
$q_result = new Result;
$q_result->average = htmlentities($row["avg"]);
$q_result->min = htmlentities($row["min"]);
$q_result->max =htmlentities($row["max"]);
$q_result->nr_answered = htmlentities($row["anz"]);
$q_result->std_deviation = $this->calc_deviation($db, htmlentities($row["id"]), $q_result->average, $q_result->nr_answered);
$this->results[]= $q_result;
}
}

//Zugriffsmethode, die zur jeweiligen Frage die im Array gespeicherten Werte ausgibt (aufgerufen in line93 rating.php)
public function get_results ($id)
{ return $this->results[$id];
}

//Funktion, die die Standardabweichung für jede Frage kalkuliert und zurückgibt
private function calc_deviation($db, $id, $average, $nr_answered){
$sql = "select a_value from rating r, answered a, student s WHERE r.mnr = a.mnr AND a.mnr = s.mnr AND c_token = '" . $this->c_token . "'AND a.s_token = '" . $this->s_token . "' and id = '" . $id . "' ;";
$result = mysqli_query ($db, $sql);
$varianz = 0;
while ($row = mysqli_fetch_assoc($result)){
$varianz +=( (htmlentities($row["a_value"])- $average) * (htmlentities($row["a_value"]) - $average));
$standardabweichung= sqrt($varianz/ $nr_answered);
}
return $standardabweichung;
}
}