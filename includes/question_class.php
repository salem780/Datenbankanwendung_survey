<?php

include_once 'db_connection.php'; // $db
//$s_token = $_SESSION['s_token'];
//echo $s_token;

//$c_token = $_SESSION["coursetoken"];
//echo $c_token;
class FrageErgebnis
{
public $anzantworten;
public $durchschnitt;
public $minimum;
public $maximum;
public $stdabweichung;
}
class Auswertung
{
public $s_token;
private $c_token;
private $id;
private $comments;

//Methods
public function setSurveytoken ($s_token){
$this->s_token = $s_token;
echo $this->s_token;
}

public function setCoursetoken($c_token){
$this->c_token = $c_token;
echo $this->c_token;


}

public function get_Comments ($db){
//$this->comments[] = array();
$sql = "select comment from answered a, student s WHERE a.mnr=s.mnr AND status = '1' AND c_token = '" . $this->c_token . "' AND a.s_token = '" . $this->s_token . "' ;";
$result = mysqli_query($db,$sql);
$resultCheck = mysqli_num_rows($result);


while ($row = mysqli_fetch_assoc($result)){
$this->comments[] = $row['comment'];
}
}

public function kommentarzusammenfassung ()
{
$commentlist = "";
for ($i = 0; $i < sizeof ($this->comments); $i++)
{
$commentlist.= "<p>" . $this->comments[$i] . "</p> <p> </p>";
}
return $commentlist;
}



}






