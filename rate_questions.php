
<?php
//Author: Alissa Templin
?>

<?php
include "db_connection.php";
include 'session_student.php';
//$s_token = $_POST['survey'];
//$questions= $db->query("Select * from survey, question WHERE survey.s_token = $s_token AND survey.s_token = question.s_token;");
//$s_title = $_POST["s_title"];
//$s_title = $db->real_escape_string($s_title);
//AND question.ID = $_SESSION["aktfrage"]

if(isset($_POST['survey'])){
$_SESSION['s_token'] = $_POST['survey'];
$s_token = $_SESSION['s_token'];
$questions= $db->query("Select * from question WHERE question.s_token = '".$s_token."';");
$num_of_questions= $questions->num_rows;
$_SESSION['anzfragen'] = $num_of_questions;
$rows = array();
while($row = mysqli_fetch_assoc($questions)){
$rows[] = $row['Text'];
}
$_SESSION['rows'] = $rows;
//$rows = $_SESSION['rows'];
//print_r($rows);
}
?>

<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Frage</title>
  </head>
  <body>


<?php

//echo "survey.s_title";


if ((isset ($_POST["nextqu"]) == false)  &&
    (isset ($_POST["prevqu"]) ==false)) {
    $rows = $_SESSION['rows'];
    $_SESSION["aktfrage"] = 1;
    //print_r($rows[$_SESSION["aktfrage"]-1]);
        }

if (isset ($_POST["nextqu"]) == true) {
$rows = $_SESSION['rows'];
$_SESSION["aktfrage"] ++;
//print_r($rows[$_SESSION["aktfrage"]-1]);
}

if (isset ($_POST["prevqu"]) ==true ) {
$rows = $_SESSION['rows'];
$_SESSION["aktfrage"] --;
//print_r($rows[$_SESSION["aktfrage"]-1]);
}

?>


<h1> Fragebogen: </h1>
<h4> Frage <?php echo $_SESSION["aktfrage"]; ?>: <?php print_r($rows[$_SESSION["aktfrage"]-1]);?></h4>





<form action="rate_questions.php" method="post">
<label><input type='radio' name='points' value="1">1</label>
<label><input type='radio' name='points' value="2">2</label>
<label><input type='radio' name='points' value="3">3</label>
<label><input type='radio' name='points' value="4">4</label>
<label><input type='radio' name='points' value="5">5</label> <br>
<br/>
<input type="submit"
    <?php if ($_SESSION["aktfrage"] == 1) echo "disabled"; ?>
    name="prevqu" value="Zurück"/>
<input type="submit"
    <?php
    if ($_SESSION["aktfrage"] == $_SESSION["anzfragen"]) echo "disabled"; ?>
name="nextqu" value="Vorwärts"/>
<br/>
</form>
<a href="logout.php">ausloggen</a>
  </body>
</html>