<?php
  session_start();
  include 'data/sec/php/jsonStuff.php';

  //var_dump($_SESSION);
  if(isset($_SESSION['ACCESS']) && $_SESSION['ACCESS'] === "granted"){
    header("Location: hub.php");
  }

  if(isset($_POST['reg-submit'])){
    $dataFile = jsonRead("data/sec/userdata.json");
    $toAdd = array();
    $toAdd['name'] = bin2hex($_POST['reg-username']);
    $toAdd['password'] = password_hash($_POST['reg-password'], PASSWORD_DEFAULT);
    $toAdd['score'] = 0;
    $toAdd['rank'] = 5;
    $toAdd['solves'] = array();
    $dataFile[count($dataFile)] = $toAdd;
    jsonWrite("data/sec/userdata.json", $dataFile);
  }


  if(isset($_POST['login-submit'])){
    $dataFile = jsonRead("data/sec/userdata.json");
    foreach ($dataFile as $key => $value) {
      //var_dump((string)$value['name'], bin2hex($_POST['login-username']));
      if((string)$value['name'] === (string)bin2hex($_POST['login-username'])){
        echo "Name found";
        if(password_verify($_POST['login-password'], $value['password'])){
          $_SESSION['ACCESS'] = "granted";
          $_SESSION['USER-ID'] = $key;
          $_SESSION['RANK'] = $value['rank'];
          $_SESSION['USER-NAME'] = $_POST['login-username'];
          header("Location: index.php");
          echo "SUCCESS!";
          break;
        }
      }
    }
    die();
  }


 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Hacking Challenges</title>
     <link href="https://fonts.googleapis.com/css?family=Oswald|Permanent+Marker|ZCOOL+KuaiLe" rel="stylesheet">
     <link rel="stylesheet" href="data/style.css" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
   <body>
     <img src="data/img/bg.jpg" alt="" id="background"/>
     <div id="backCover">.</div>
     <div id="contentContainer">
       <div id="headLine">
         <h1>Hacking Challenges</h1>
         <h2>by Shirkanesi</h2>
       </div>
       <div class="article">
         <h3>Anmeldung</h3>
         <?php if (isset($_GET['nologin'])): ?>
           <span style="color: red;">Du musst dich anmelden!!!!</span>
         <?php endif; ?>
         <form method="post" action="">
           <input type="text" name="login-username" placeholder="Benutzername" required/>
           <input type="password" name="login-password" placeholder="Passwort" required/>
           <input type="submit" name="login-submit" value="Anmelden"/>
         </form>
       </div>
       <div class="article">
         <h3>Registrierung</h3>
         <form method="post" action="">
           <input type="text" name="reg-username" placeholder="Benutzername" required/>
           <input type="password" name="reg-password" placeholder="Passwort" required/>
           <input type="password" name="reg-password2" placeholder="Passwort" required/>
           <input type="submit" name="reg-submit" value="Registrieren"/>
         </form>
       </div>
     </div>
     <div id="footer">
       © Shirkanesi 2019
     </div>
   </body>
 </html>
