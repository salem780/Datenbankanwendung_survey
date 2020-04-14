<?php
 //Author - Peter Metzger
 //Startseite neuen Kurs erstellen
include "session_surveyor.php";
?>

<!DOCTYPE html>
<!--
Author - Peter Metzger
 -->
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kurs erstellen</title>
  </head>
  <body>
            <main>
                       <div class="wrapper-main">
                       <section class="section-default">
                       <h1>Neuen Kurs erstellen</h1>
                       <form class="form-signup" action="create_course.php" method="POST">
                           <input type="text" name="c_token" placeholder="Kurskürzel" required></br>
                           <input type="text" name="c_name" placeholder="Kursname" required></br>
                           <button type="submit" name="submit">Erstellen</button></br>
                       </form>
                       <p>Hier gehts <a href="course.php">zur Kursübersicht</a>.</p>
                       </section>
                       </div>
            </main>
  </body>
</html>