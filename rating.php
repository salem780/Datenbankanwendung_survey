<?php
include_once 'db_connection.php';
include 'session_surveyor.php';
?>

 <!DOCTYPE html>
 <html>
 <head>
     <style>
         .grid-container {
             display: grid;
             grid-template-columns: auto ;
             background-color: #2196F3;
             padding: 10px;
         }

         .grid-item {
             background-color: rgba(255, 255, 255, 0.8);
             border: 1px solid rgba(0, 0, 0, 0);
             padding: 20px;
             font-size: 15px;
             text-align: left;
         }
     </style>
 </head>
 <body>
 <h1>Ergebnisauswertung</h1>
<div class="grid-container">
     <div class="grid-item">


<?php
//session variable

$username = $_SESSION["username"];
echo $_SESSION['username'];

// Dropdown menü, alle Fragebögen auslesen, die ein User erstellt hat

$surveys = $db->query("select distinct s.s_title from activation a, survey s where s.s_token = a.s_token AND s.username = '$username';");

//Combobox zur Kursauswahl
echo "<form method='POST'>";
echo "<select name='surveytitles'>";
while($row = mysqli_fetch_assoc($surveys)){
  echo "<option>".$row["s_title"]."</option>";

}

echo "<input type='submit' name='titlesearch', value='Suchen'/>";
echo "</select></form>";

if(isset($_POST["titlesearch"])){

$selected_title = $_POST['surveytitles'];
echo $selected_title;



$s_token = $db->query("select s_token from survey where s_title = '".$selected_title."';");
$s_token = mysqli_fetch_assoc($s_token);
$s_token = $s_token["s_token"];

$coursetitles = $db->query("select c_name from course c, activation a where c.c_token  = a.c_token AND
                            a.s_token ='".$s_token."' ;");
}
echo "<form method='POST'>";
echo "<select name ='coursetitles'>";
while ($row = mysqli_fetch_assoc($coursetitles)){
echo "<option>".$row["c_name"]."<option>";
}
echo "<input type='submit' name='coursesearch', value='Suchen'/>";
echo "</select></form>";

if(isset($_POST["coursesearch"])){

$selected_course = $_POST['coursetitles'];
echo $selected_course;
}

echo "</select></form>";
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
 </html>*/