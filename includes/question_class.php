<?php

include_once 'db_connection.php'; // $db
//$s_token = $_SESSION['s_token'];
//echo $s_token;

//$c_token = $_SESSION["coursetoken"];
//echo $c_token;

class Frageerg {
public $id;
public $anzantworten;
public $durchschnitt;
public $minimum;
public $maximum;
public $stdabweichung;

}

class Auswertung
{
public $s_token;
public $c_token;
private $ergebnisse;
private $comments;

//Methods
public function __construct ($s_token, $c_token)
{
$this->s_token = $s_token;
$this->c_token = $c_token;
$db = new mysqli("localhost", "root", "", "survey");
$this->lade_punkteergebnisse($db);
}
//public function setId ($id){
//$this->id = $id;
//echo $this->id;
//}


public function get_Comments ($db){
$this->comments = array();
$sql = "select comment from answered a, student s WHERE a.mnr=s.mnr AND status = '1' AND c_token = '" . $this->c_token . "' AND a.s_token = '" . $this->s_token . "' ;";

$result = mysqli_query ($db, $sql);
while ($row = mysqli_fetch_assoc($result))
{
$this->comments[] = $row["comment"];
}
}

public function commentlist ()
{
$list = "";
for ($i = 0; $i < sizeof($this->comments); $i++)
{
$list .= "<p>" . $this->comments[$i] . "</p> <p> </p>";
}
return $list;
}
/*
protected function lade_punkteergebnisse ($db,$id){

$this->ergebnisse = array();
$sql = "select id, avg(a_value) as avg, min(a_value) as min, max(a_value) as max, count(*) as anz from rating r, answered a, student s WHERE r.mnr= a.mnr AND a.mnr= s.mnr AND s.kurs= '" . $this->c_token . "' and  r.s_token = '" . $this->s_token . "' ;";
$frageerg = new FrageErgebnis;
$frageerg->anzantworten = $row["anz"];
$frageerg->durchschnitt = $row["avg"];
$frageerg->minimum = $row["min"];
$frageerg->maximum = $row["max"];
$this->ergebnisse[] = $frageerg;
}*/

public function erg_fuer_frage ($id)
{ return $this->ergebnisse[$id];
echo $this->ergebnisse[$id];
}

}






