//Author: Alissa Templin
<?php
include "db_connection.php";
$survey_active = $db->query("Select * from survey, activation, student WHERE survey.s_token = activation.s_token AND activation.c_token = student.c_token;");
?>

<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fragebogen</title>
  </head>
  <body>
   <?php

             while(($row = $survey_active->fetch_object()) != false) {
             //echo "$row->s.s_title <br/>";
             $rows[] = $row;
             }
    ?>

    <div data-role="main" class="ui-content">
    	<h1>Fragebögen</h1>
      <table id="Fragebögen_freigeschaltet" data-role="table" class="ui-responsive" data-mode="columntoggle" data-column-btn-text="Spalten" width="30%">
        <thead>
          <tr>
            <th>Kürzel</th>
            <th>Titel</th>
            <th>Ersteller</th>

          </tr>
        </thead>
        <tbody>
      <?php
      foreach ($rows as $data) {
      ?>
          <tr>
              <td>
                  <?php echo $data->s_token; ?>
              </td>
              <td>
                  <?php echo $data->s_title; ?>
              </td>
              <td>
                  <input type="button" value="Home" onclick="window.location.href='create_survey.php'" />
              </td>
        </tr>
      <?php
      }
      ?>
        </tbody>
      </table>


  </body>
</html>