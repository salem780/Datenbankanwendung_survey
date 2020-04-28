 <!DOCTYPE html>
                      <!--Author: Peter Metzger
                      LogIn Seite für Befrager-->
                                   <html>
                                     <head>
                                       <meta charset="utf-8" />
                                       <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                                       <title>Befrager LogIn</title>
                                     </head>
                                     <body>
                                        <main>
                                            <div class="wrapper-main">
                                            <section class="section-default">
                                            <h1>LogIn</h1>
                                            <form class="form-signup" action="authenticate.php" method="POST">
                                                <input type="text" name="username" placeholder="Benutzername" required></br></br>
                                                <input type="password" name="password" placeholder="Passwort" required></br>
                                                <button type="submit" name="submit">LogIn</button></br>
                                            </form>
                                            <p>Hier gehts <a href="registration.php">zur Registrierung</a> für Befrager und hier gehts zum Studenten <a href="student_login.php">LogIn</a>.</p>
                                            </section>
                                            </div>
                                        </main>

                                     </body>
                                   </html>