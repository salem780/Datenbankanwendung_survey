<!DOCTYPE html>
 <!--Author: Peter Metzger
 Registrierungsseite für Befrager-->
       <html>
         <head>
           <meta charset="utf-8" />
           <meta name="viewport" content="width=device-width, initial-scale=1.0" />
           <title>Registrierung Befrager </title>
         </head>
         <body>
            <main>
                <div class="wrapper-main">
                <section class="section-default">
                <h1>Registrierung</h1>
                <form class="form-signup" action="register.php" method="POST">
                    <input type="text" name="username" placeholder="Benutzername" required></br></br>
                    <input type="password" name="password" placeholder="Passwort" required></br>
                    <input type="password" name="re-password" placeholder="Passwort wiederholen" required></br>
                    <button type="submit" name="submit">Register</button></br></br>
                </form>
                <a href="index.php">Zum LogIn</a>
                </section>
                </div>
            </main>

         </body>
       </html>