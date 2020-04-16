<?php
//Author - Salina Moser
//Formular, um Daten um die Auswertung zu sehen

include "session_surveyor.php";
include "db_connection.php";

?>
<!DOCTYPE html>
<html>
<head>
<h1>Ergebnisauswertung</h1>
</head>
<body>
<?php
//session variable

$username = $_SESSION["username"];
echo $_SESSION['username'];

// Dropdown menü, alle Fragebögen auslesen, die ein User erstellt hat

$surveys = $db->query("select distinct s.s_title from activation a, survey s where s.s_token = a.s_token AND s.username = '$username';");


<div class="grid-container">
    <div class="grid-item">







            <form>
                <select name = "course">
                    <option value="course1">Kurs1</option>
                    <option value="course2">Kurs2</option>
                    <option value="course3">Kurs3</option>
                    <option value="course4">Kurs4</option>
                    <option value="surveytitle4">Kurs5</option>
                </select>



                <input type="submit" name="suchen", value="Suchen"/>
            </form>


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