<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Frage</title>
  </head>
  <?php
  //Author: Alissa Templin
  include "db_connection.php";
  include 'session_student.php';

    //Vorbelegung des Radiobuttons
  function checkRadioButton($a_value, $pre_value) {
    echo '<input type="radio" name="points" value="' . $a_value . '" ';
    if ($a_value == $pre_value)
        echo " checked ";
        echo '/>';
    }
  ?>
  <body>

<?php

if(isset($_POST['survey'])){
$_SESSION['s_token'] = $_POST['survey'];
$_SESSION['question_number'] = 1;
$s_token = $_SESSION['s_token'];
}
//Anzahl der Fragen ermitteln
$questions= $db->query("Select * from question WHERE question.s_token = '".$s_token."';");
$num_of_questions= $questions->num_rows;
$_SESSION['num_of_questions'] = $num_of_questions;
$_SESSION['num_of_questions'] ++; //wegen Kommentarseite
/*
//Titel des Fragebogens ermitteln
$survey = $db->query("Select * from survey where survey.s_title = '".$s_token."';");
$row_survey = mysqli_fetch_assoc($survey);
echo $row.['s_title'];
*/

$rows = array();
while($row = mysqli_fetch_assoc($questions)){
$rows[] = $row['Text'];
}
$_SESSION['rows'] = $rows;
//$rows = $_SESSION['rows'];
//print_r($rows);




/*
if (isset ($_POST["nextqu"]) || ($_POST["prevqu"])) {
    if ($_SESSION['question_number'] < $_SESSION['num_of_questions'])
    {
    if (isset($_POST["points"]))
    {
    //Punkte in DB speichern
    inject_rating ();
    }
    }
    else {
    //Kommentar in DB speichern
    inject_comment();
    }
}
*/
/*
if ((isset ($_POST["nextqu"]) == false)  &&
    (isset ($_POST["prevqu"]) ==false)) {
    $rows = $_SESSION['rows'];
    $_SESSION["aktfrage"] = 1;
        }
*/

if (isset ($_POST["nextqu"]) == true) {
$rows = $_SESSION['rows'];
$_SESSION['question_number'] ++;
}

if (isset ($_POST["prevqu"]) ==true ) {
$rows = $_SESSION['rows'];
$_SESSION['question_number'] --;
}

//echo "<h2> Fragebogen: " . $s_title . "</h2>";

?>

<h1> Fragebogen:  </h1>
<h4> Frage <?php echo $_SESSION["question_number"]; ?>: <?php print_r($rows[$_SESSION["question_number"]]);?></h4>

<form action="rate_questions.php" method="post">

<label><input type='radio' name='points' value="1">1</label>
<label><input type='radio' name='points' value="2">2</label>
<label><input type='radio' name='points' value="3">3</label>
<label><input type='radio' name='points' value="4">4</label>
<label><input type='radio' name='points' value="5">5</label> <br>

<br/>
<input type="submit"
    <?php if ($_SESSION["question_number"] == 1) echo "disabled"; ?>
    name="prevqu" value="Zurück"/>
<input type="submit"
    <?php
    if ($_SESSION["question_number"] == $_SESSION['num_of_questions']) echo "disabled"; ?>
name="nextqu" value="Vorwärts"/>
<br/>


</form>
<a href="logout.php">ausloggen</a>
  </body>
</html>

