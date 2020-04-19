<?php
include_once 'db_connection.php';
include 'session_surveyor.php';
//include 'functions.php';
//include 'question_class.php';

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




$s_token = $db->query("select s_token from survey where s_title = '".$selected_survey."';");
$s_token = mysqli_fetch_assoc($s_token);
$s_token = $s_token["s_token"];
$_SESSION['s_token'] = $s_token;


$coursetitles = $db->query("select c_token from activation where  s_token ='".$_SESSION['s_token']."' ;");



echo "<form action='rating.php' method='POST'>";
echo "<select name='coursetitles'>";
while($row = mysqli_fetch_assoc($coursetitles)){
 echo "<option name= 'title' value = ".$row['c_token'].">".$row['c_token']."</option>";
//echo "<label><input type='checkbox' name='coursetitles' value=".$row['c_token'].">".htmlentities($row['c_token'])."</label> <br>";
}
echo "<input type='submit' name='coursesearch', value='Suchen'/>";
echo "</select></form>";

$questions = $db->query("select id from rating where s_token ='".$_SESSION['s_token']."' ;");
}
$selected_course = $row['c_token'];

if(isset($_POST["coursesearch"])){

$selected_course = $_POST['coursetitles'];
$_SESSION["coursetitles"] = $selected_course;
echo"<br>
<br>";
echo "<label for='text'><b>Umfragetitel<b>: " .$_SESSION["surveytitles"]. "</label> <br>";
echo"<br>";
echo "<label for='text'><b>Befragter Kurs<b>: " .$_SESSION["coursetitles"]. "</label> <br>";
echo "<label for='text'><b>Umfragekürzel<b>: " .$_SESSION['s_token']. "</label> <br>";

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
 echo "<tr>";
echo "<td>".$row['id']."</td>";

echo "<td>".$row['text']."</td>";
echo "</tr>";
}

echo "</table></form>";}


?>






             <form>


                 <h2>Kommentare der Befragten</h2>

                 <label>comments</label>
                 <textarea id="text" name="text" cols="35" rows="4"></textarea>

             </form>

     </div>

 </div>


 </body>
 </html>