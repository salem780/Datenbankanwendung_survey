<?php
include_once 'db_connection.php';
include 'session_surveyor.php';

//include 'functions.php';


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
//$coursetitles= "";
//$s_token="";



// Dropdown menü, alle Fragebögen auslesen, die ein User erstellt hat

$surveys = $db->query("select distinct s.s_title from activation a, survey s where s.s_token = a.s_token AND s.username = '$username';");

//Dropdown zur titelauswahl

echo "<form action='rating.php' method='POST'>";
echo "<select name='surveytitles'  required>";

while($row = mysqli_fetch_assoc($surveys)){
  echo "<option name= 'title' value = ".$row['s_title'].">".$row['s_title']."</option>";



}
echo "<input type='submit' name='titlesearch' value='Suchen'/>";
//echo "</select></form>";




//if die sessionvariable null dann header auf dieselbe seite

if(isset($_POST["titlesearch"])){

$selected_survey = $_POST['surveytitles'];
$_SESSION["surveytitles"] = $selected_survey;
$selected_survey = $_SESSION["surveytitles"];
//echo $_SESSION["surveytitles"];




$s_token = $db->query("select s_token from survey where s_title = '".$selected_survey."';");
$s_token = mysqli_fetch_assoc($s_token);
$s_token = $s_token["s_token"];
$_SESSION['s_token'] = $s_token;



$coursetoken = $db->query("select c_token from activation where  s_token ='".$_SESSION['s_token']."' ;");



//echo "<form action='rating.php' method='POST'>";
echo "<select name='coursetoken'>";
while($row = mysqli_fetch_assoc($coursetoken)){
 echo "<option name= 'title' value = ".$row['c_token'].">".$row['c_token']."</option>";
//echo "<label><input type='checkbox' name='coursetitles' value=".$row['c_token'].">".htmlentities($row['c_token'])."</label> <br>";
}

echo "<input type='submit' name='coursesearch', value='Suchen'/>";
echo "</select></form>";

$questions = $db->query("select id from rating where s_token ='".$_SESSION['s_token']."' ;");
}
else { echo "Bitte Titel auswählen";}
$selected_course = $row['c_token'];

if(isset($_POST["coursesearch"])){
include 'includes/question_class.php';
$selected_course = $_POST['coursetoken'];
$_SESSION["coursetoken"] = $selected_course;
echo"<br>
<br>";
echo "<label for='text'><b>Umfragetitel<b>: " .$_SESSION["surveytitles"]. "</label> <br>";
echo"<br>";
echo "<label for='text'><b>Befragter Kurs<b>: " .$_SESSION["coursetoken"]. "</label> <br>";
echo "<label for='text'><b>Umfragekürzel<b>: " .$_SESSION['s_token']. "</label> <br>";

include_once 'includes/question_class.php';
$auswertung1 = new Auswertung ();
$auswertung1->setSurveytoken($_SESSION['s_token']);
$auswertung1->setCoursetoken($_SESSION["coursetoken"]);
$auswertung1->lade_kommentare($db);

$questions = $db->query("select id, text from question where s_token ='".$_SESSION['s_token']."' ;");

echo "<form action='rating.php' method='POST'>";
echo "<table id='resulttable' , border='1' , width='100%'>";
echo "<h2>Fragebogenauswertung</h2>";
echo "<tr>";
echo "<th>Id</th>";
echo "<th>Frage</th>";
echo "<th>Durchschnitt</th>";
echo "<th>Max</th>";
echo "<th>Min</th>";
echo "<th>Standardabweichung</th>";
echo "</tr>";


while($row = mysqli_fetch_assoc($questions)){




echo "<td>".$row['id']."</td>";
echo "<td>".$row['text']."</td>";
echo "</tr>";


}

echo "</table></form>";


}



?>






             <form>


                 <h2>Kommentare der Befragten</h2>

                 <label>comments</label>
                 <textarea id="text" name="text" cols="35" rows="4"></textarea>

             </form>

     </div>
<a href='surveyor_logged.php'> Zurück zur Startseite</a>
 </div>


 </body>
 </html>