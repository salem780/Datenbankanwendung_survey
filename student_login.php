<!DOCTYPE html>
 <!--Author: Peter Metzger
 LogIn Seite für Studenten-->
              <html>
                <head>
                  <meta charset="utf-8" />
                  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                  <title>Studenten LogIn</title>
                </head>
                <body>
                   <main>
                       <div class="wrapper-main">
                       <section class="section-default">
                       <h1>LogIn</h1>
                       <form class="form-signup" action="authenticate_mnr.php" method="POST">
                           <input type="text" name="mnr" placeholder="Matrikelnummer" required></br></br>
                           <button type="submit" name="submit">LogIn</button></br>
                       </form>
                       <p>Hier gehts zum Befrager <a href="index.php">LogIn</p>
                       </section>
                       </div>
                   </main>

                </body>
              </html>