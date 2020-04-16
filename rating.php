<?php
include_once 'db_connection.php';
include 'session_surveyor.php';

?>


 <!DOCTYPE html>
 <html>
 <head>
 </head>
 <body>
 <h1>Ergebnisauswertung</h1>
<div class="grid-container">
     <div class="grid-item">


<?php


$username = $_SESSION["username"];
echo $_SESSION['username'];



// Dropdown menü, alle Fragebögen auslesen, die ein User erstellt hat

$surveys = $db->query("select distinct s.s_title from activation a, survey s where s.s_token = a.s_token AND s.username = '$username';");

//Dropdown zur titelauswahl
echo "<form action='rating.php' method='POST'>";
echo "<select name='surveytitles' value = 'test'>";
//echo "<option selected = 'selected' name= 'title' value = ''></option>";
while($row = mysqli_fetch_assoc($surveys)){
  echo "<option name= 'title' value = ".$row['s_title'].">".$row['s_title']."</option>";
}

echo "<input type='submit' name='titlesearch', value='Suchen'/>";
echo "</select></form>";
$selected_survey= $row['s_title'];

if(isset($_POST["titlesearch"])){
$selected_survey = $_POST['surveytitles'];
$_SESSION["surveytitles"] = $selected_survey;
$selected_survey = $_SESSION["surveytitles"];
echo $_SESSION["surveytitles"];
}


$s_token = $db->query("select s_token from survey where s_title = '".$selected_survey."';");
$s_token = mysqli_fetch_assoc($s_token);
$s_token = $s_token["s_token"];

$coursetitles = $db->query("select c_token from activation where  s_token ='".$s_token."' ;");


echo "<form action='rating.php' method='POST'>";
echo "<select name='coursetitles'>";
while($row = mysqli_fetch_assoc($coursetitles)){
  echo "<option name= 'title' value = ".$row['c_token'].">".$row['c_token']."</option>";

}
echo "<input type='submit' name='coursesearch', value='Suchen'/>";
echo "</select></form>";
//$selected_course = $row['c_token'];

if(isset($_POST["coursesearch"])){

$selected_course = $_POST['coursetitles'];
$_SESSION["coursetitles"] = $selected_course;
echo $_SESSION["coursetitles"];
echo $_SESSION["surveytitles"];

}

?>
             <form>

                 <table id="resulttable" , border="1" , width="100%">
                     <h2>Fragebogenauswertung</h2>

                     <tr>
                         <th>Frage</th>
                         <th>Durchschnitt</th>
                         <th>Max</th>
                         <th>Min</th>
                         <th>Standardabweichung</th>

                     </tr>

                     <tr>
                         <td>Frage 1</td>
                         <td>50</td>
                         <td>100</td>
                         <td>20</td>
                         <td>4,5</td>

                     </tr>
                     <tr>


                 </table>
             </form>


             <form>


                 <h2>Kommentare der Befragten</h2>

                 <label>comments</label>
                 <textarea id="text" name="text" cols="35" rows="4"></textarea>

             </form>

     </div>

 </div>


 </body>
 </html>