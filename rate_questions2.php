  <!DOCTYPE html>
  <html lang="de">
    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Fragebogen ausfüllen</title>
    </head>

      <?php
  //Zugriff über URL verhindern
  if (!isset($_POST['survey']) && !isset($_POST['nextqu']) && !isset($_POST['prevqu']) && !isset($_POST['sendsurvey']) && !isset($_POST['save'])) {
      echo "<a href='activated_surveys.php'> Zurück zur Fragebogenauswahl</a><br>";
      exit();
  }

  //Author: Alissa Templin
  //Umsetzung des Fragenblättern und der Bewertung der Fragen
  include "db_connection.php";
  include 'session_student.php';
  include 'functions.php';

  //Funktion zur Erstellung und Vorbelegung der Radiobuttons
  function checkRadioButton($a_value, $pre_value) {
      echo '<input type="radio"  name="points" value="' . ($a_value) . '" ';
      if ($a_value == $pre_value)
          echo " checked ";
      echo '/>';
      echo '<label for="points"> ' . htmlentities($a_value) . ' </label> ';
  }

  ?>

      <body>
      <?php

  if (isset($_POST['survey'])) {
      $_SESSION['s_token'] = $_POST['survey'];
      $s_token             = $_SESSION['s_token'];
  }

  if (isset($_SESSION['s_token'])) {
      $s_token = $_SESSION['s_token'];
  }


  //Anzahl der Fragen ermitteln
  $questions                    = $db->query("Select * from question WHERE question.s_token = '" . htmlentities($s_token) . "';");
  $num_of_questions             = $questions->num_rows;
  $_SESSION['num_of_questions'] = $num_of_questions;
  //Eine weitere Seite hinzufügen
  $_SESSION['num_of_questions']++;


  //Titel des Fragebogen ermitteln
  $sql     = $db->query("Select * from survey WHERE survey.s_token = '" . htmlentities($s_token) . "';");
  $result  = mysqli_fetch_assoc($sql);
  $s_title = $result["s_title"];

  //Wenn kein Button gedrückt wurde, Fragennummer = 1
  if ((isset($_POST["nextqu"]) == false) && (isset($_POST["prevqu"]) == false)) {
      $_SESSION["question_number"] = 1;
  }


  //Verarbeitung der Antwort
  if (isset($_POST["nextqu"]) || isset($_POST["prevqu"]) || isset($_POST["sendsurvey"]) || isset($_POST["save"])) {
        // Wenn es sich um eine Frage handelt, dann die Funktion inject_rating aufrufen
        if ($_SESSION['question_number'] < $_SESSION['num_of_questions']) {

            if (isset($_POST["points"])) {
                  //Punkte in Db speichern
                  inject_rating($_SESSION['mnr'], $_SESSION['question_number'], $s_token, $_POST["points"]);
                  }

        }
   }

  if (isset($_POST["comment"])) {
      //Kommentar in DB speichern
      inject_comment($_POST["comment"], $_SESSION['mnr'], $s_token);
  }

  //Verarbeitung, wenn Fragebogen abschicken Button gedrückt wurde
  if (isset($_POST["sendsurvey"])) {
      set_status($_SESSION['mnr'], $s_token);
      echo "<h4> Vielen Dank für die Beantwortung des Fragebogens: " . htmlentities($s_title) . "</h4>";
  }

  if (isset($_POST["save"]) || isset($_POST["sendsurvey"])) {
      echo '<a href="activated_surveys.php"> Hier können Sie weitere Fragebögen beantworten </a> </br>';
      echo '<a href="logout.php"> Ausloggen </a>';
      exit();
  }

  //Verarbeitung, wenn Vorwärts Button gedrückt wurde
  if (isset($_POST["nextqu"])) {
      $_SESSION['question_number']++;
  }
  //Verarbeitung, wenn Zurück Button gedrückt wurde
  if (isset($_POST["prevqu"])) {
      $_SESSION['question_number']--;
  }

  echo "<h2> Fragebogen: " . $s_title . "</h2>";
  ?>

    <form action="rate_questions2.php" method="post">
    <?php
  //Prüfen, ob alle Fragen eines Fragebogen beantwortet wurden
  $sql                 = $db->query("Select * from rating where s_token = '" . $s_token . "' AND mnr = '" . $_SESSION['mnr'] . "';");
  $num_rated_questions = $sql->num_rows;
  if ($num_rated_questions == $_SESSION['num_of_questions'] - 1) {
      $var = true;
  } else {
      $var = false;
  }

  //Fragentext ermitteln
  if ($_SESSION['question_number'] < $_SESSION['num_of_questions']) {
      echo "<p> Frage " . $_SESSION['question_number'] . " von " . ($_SESSION['num_of_questions'] - 1) . ": </p>";


      $sql = $db->query("Select text from question where s_token = '" . $s_token . "' AND
                                   id = '" . $_SESSION['question_number'] . "';");

      if ($sql) {
          $result = mysqli_fetch_assoc($sql);
          echo $result["text"];
      }
      echo "<br/>";
      echo "<br/>";

      //Prüfen, ob Wert vorbelegt ist und Aufruf der Funktion zur Vorbelegung und Erstellung der Radiobuttons
      $sql       = $db->query("Select a_value from rating where s_token = '" . $s_token . "' AND mnr = '" . $_SESSION['mnr'] . "' AND id = '" . $_SESSION['question_number'] . "';");
      $pre_value = 0;
      if ($sql) {
          $result = mysqli_fetch_assoc($sql);
          if ($result) {
              $pre_value = $result["a_value"];
          }
      }
      for ($v = 1; $v <= 5; $v++)
          checkRadioButton($v, $pre_value);

  } else {
      //Textfeld für Kommentar
      echo "<p> Kommentar hinzufügen: </p>";
      echo '<textarea name= "comment" cols="50" rows="8">';
      $sql = $db->query("Select comment from answered where s_token = '" . $s_token . "' AND mnr = '" . $_SESSION['mnr'] . "';");
      if ($sql) {
          $result = mysqli_fetch_assoc($sql);
          if ($result)
              echo $result["comment"];
      }
      echo '</textarea>';
  }

  ?>

  <br/>
              <!-- Buttons erzeugen: Zurück, Vorwärts, Fragebogen abschicken, Später fertig beantworten-->
              <br/>
              <input type="submit"
                  <?php if ($_SESSION["question_number"] == 1) echo "disabled";?>
                 name="prevqu" value="Zurück"/>

              <input type="submit" <?php if ($_SESSION["question_number"] == $_SESSION['num_of_questions']) echo "disabled"; ?>
             name="nextqu" value="Vorwärts"/>
              <br/> <br/>

               <input type="submit"
                          <?php if ($var == false) echo "disabled"; ?>
                         name="sendsurvey" value="Fragebogen abschicken"/>
              <br/>
               <input type="submit" name="save" value="Später fertig beantworten"/>

   </form>

      </body>
    </html>