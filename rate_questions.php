<?php session_start(); ?>

<?php
include "db_connection.php";
$questions= $db->query("Select question.* from survey, question WHERE survey.s_token = question.s_token;");


?>

<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fragen</title>
  </head>
  <body>

<?php

$num_of_questions= $questions->num_rows;

while(($row = $questions->fetch_object()) != false) {
             //echo "$row->s.s_title <br/>";
             $rows[] = $row;
             }
?>

<?php


if ((isset ($_POST["nextqu"]) == false)  &&
    (isset ($_POST["prevqu"]) ==false)) {
    $_SESSION["aktfrage"] = 1;
    $_SESSION["anzfragen"] = $num_of_questions;
        }

if (isset ($_POST["nextqu"]) == true) {
$_SESSION["aktfrage"] ++;
}

if (isset ($_POST["prevqu"]) ==true ) {
$_SESSION["aktfrage"] --;
}

?>

<h4> Frage <?php echo $_SESSION["aktfrage"]; ?> <h4>

<?php
foreach ($rows as $data) {
echo $data->Text;
}
?>


<br/>

<form action="rate_questions.php" method="post">
<input type="submit"
    <?php if ($_SESSION["aktfrage"] == 1) echo "disabled"; ?>
    name="prevqu" value="Prev"/>
<input type="submit"
    <?php
    if ($_SESSION["aktfrage"] == $_SESSION["anzfragen"]) echo "disabled"; ?>
name="nextqu" value="Next"/>

</form>

  </body>
</html>