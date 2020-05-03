<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fragebogen ausfüllen</title>
  </head>
    <?php
    //Author: Alissa Templin
    include "db_connection.php";
    include 'session_student.php';
    include 'functions.php';

      //Funktion zur Erstellung und Vorbelegung der Radiobuttons
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
    //$_SESSION['question_number'] = 1;
    $s_token = $_SESSION['s_token'];
    }
    if(isset($_SESSION['s_token'])){
    $s_token = $_SESSION['s_token'];
    }

    //Anzahl der Fragen ermitteln
    $questions= $db->query("Select * from question WHERE question.s_token = '".$s_token."';");
    $num_of_questions= $questions->num_rows;
    $_SESSION['num_of_questions'] = $num_of_questions;
    $_SESSION['num_of_questions'] ++; //wegen Kommentarseite
    //echo $_SESSION['num_of_questions'];

    //Titel des Fragebogen ermitteln
    $sql= $db->query("Select * from survey WHERE survey.s_token = '".$s_token."';");
    $result= mysqli_fetch_assoc($sql);
    $s_title= $result["s_title"];

    //Wenn kein Button gedrückt wurde, Fragennummer = 1
    if ((isset ($_POST["nextqu"]) == false)  &&
        (isset ($_POST["prevqu"]) ==false)) {
        $_SESSION["question_number"] = 1;
            }
            /*
     //Verarbeitung der Antwort
     if (isset ($_POST["nextqu"]) || ($_POST["prevqu"])) {
          if ($_SESSION['question_number'] < $_SESSION['num_of_questions'])
            {
                if (isset($_POST["points"]))
                  {
                    //Punkte in DB speichern
                    inject_rating ($_SESSION['mnr'], $_SESSION['question_number'], $s_token, $_POST["points"]);
                  }
            }
           else {
              //Kommentar in DB speichern
              inject_comment($_SESSION['mnr'], $s_token, $_POST["comment"]);
                }
        }
*/
    //Verarbeitung, wenn Nächste Button gedrückt wurde
    if (isset ($_POST["nextqu"]) == true) {
    $_SESSION['question_number'] ++;
    }
    //Verarbeitung, wenn Zurück Button gedrückt wurde
    if (isset ($_POST["prevqu"]) ==true ) {
    $_SESSION['question_number'] --;
    }


    echo "<h2> Fragebogen: " . $s_title . "</h2>";
?>

  <form action="rate_questions2.php" method="post">
  <?php
   //Fragentext ermitteln
        if ($_SESSION['question_number'] < $_SESSION['num_of_questions'])
            {
               echo "<p> Frage " .$_SESSION['question_number']. ":</p>";

               $sql= $db->query("Select text from question where s_token = '".$s_token."' AND
                                 id = '".$_SESSION['question_number']."';");

                  if ($sql)
                      {
                      $result = mysqli_fetch_assoc($sql);
                      echo $result["text"];
                      }
        echo "<br/>";
        echo "<br/>";

        //Radiobuttons ausgeben
        $sql = $db->query("Select a_value from rating where s_token = '".$s_token."' AND mnr = '".$_SESSION['mnr']."' AND id = '".$_SESSION['question_number']."';");
            $pre_value = 0;
            if($sql)
            {
            $result= mysqli_fetch_assoc ($sql);
            if($result)
            {
            $pre_value = $result["a_value"];
            }
            }
            for ($v = 1; $v <=5; $v++)
                checkRadioButton ($v, $pre_value);
        }
        else {
        //Textfeld für Kommentar
        echo "<p> Kommentar hinzufügen: </p>";
            echo '<textarea name= "comment" cols="50" rows="8">';
            $sql = $db->query("Select comment from answered where s_token = '".$s_token."' AND mnr = '".$_SESSION['mnr']."';");
            if ($sql)
            {
            $result = mysqli_fetch_assoc ($sql);
            if ($result) echo $result["comment"];
            }
            echo '</textarea>';
        }

?>

<br/>

            <!-- Buttons erzeugen -->
            <input type="submit"
                <?php if ($_SESSION["question_number"] == 1) echo "disabled"; ?>
                name="prevqu" value="Zurück"/>
            <input type="submit"
                <?php
                if ($_SESSION["question_number"] == $_SESSION['num_of_questions']) echo "disabled"; ?>
            name="nextqu" value="Vorwärts"/>
            <br/>

    </form>




    </body>
  </html>