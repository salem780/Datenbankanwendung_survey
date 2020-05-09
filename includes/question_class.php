<?php

include_once 'db_connection.php';


class Result {
public $id;
public $nr_answered;
public $average;
public $min;
public $max;
public $std_deviation;
}

class Evaluation
{
public $s_token;
public $c_token;
private $results;
private $comments;


public function __construct ($s_token, $c_token)
{
$this->s_token = $s_token;
$this->c_token = $c_token;
$db = new mysqli("localhost", "root", "", "survey");
$this->get_comments($db);
$this->calc_result($db);

}
private function get_comments ($db){
$this->comments = array();
$sql = "select comment from answered a, student s WHERE a.mnr=s.mnr AND status = '1' AND c_token = '" . $this->c_token . "' AND a.s_token = '" . $this->s_token . "' ;";

$result = mysqli_query ($db, $sql);
while ($row = mysqli_fetch_assoc($result))
{
$this->comments[] = $row["comment"];

}
}

public function all_comments ()
{  for ($x=0; $x<count($this->comments); $x++) {
	            echo "<p>" . $this->comments[$x] . "</p> ";
	            }
}


private function calc_result ($db)

{$this->results = array(1);
$sql = "select id, avg(a_value) as avg, min(a_value) as min, max(a_value) as max, count(id) as anz from rating r, answered a, student s WHERE r.mnr = a.mnr AND a.mnr = s.mnr AND c_token = '" . $this->c_token . "'AND a.s_token = '" . $this->s_token . "' group by id order by id;";
$result = mysqli_query ($db, $sql);

while ($row = mysqli_fetch_assoc($result))
{
$q_result = new Result;
$q_result->average = $row["avg"];
$q_result->min = $row["min"];
$q_result->max = $row["max"];
$q_result->nr_answered = $row["anz"];
$q_result->std_deviation = $this->calc_deviation($db, $row["id"], $q_result->average, $q_result->nr_answered);
$this->results[]= $q_result;

}
}

public function get_results ($id)
{ return $this->results[$id];
}

private function calc_deviation($db, $id, $average, $nr_answered){
$sql = "select a_value from rating r, answered a, student s WHERE r.mnr = a.mnr AND a.mnr = s.mnr AND c_token = '" . $this->c_token . "'AND a.s_token = '" . $this->s_token . "' and id = '" . $id . "' ;";
$result = mysqli_query ($db, $sql);
$varianz = 0;
while ($row = mysqli_fetch_assoc($result)){

$varianz +=( ($row["a_value"] - $average) * ($row["a_value"] - $average));

$standardabweichung= sqrt($varianz/ $nr_answered);

}
return $standardabweichung;
}


}