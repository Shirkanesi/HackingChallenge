<?php
  include '../data/sec/php/loginCheck.php';
 ?>
<?php
  include '../data/sec/php/jsonStuff.php';

  if(isset($_POST['commentText']) && isset($_POST['name']) && isset($_POST['commentHeadLine'])){
    if($_POST['commentText'] != "" && $_POST['name'] != "" && $_POST['commentHeadLine'] != ""){#
      $data = jsonRead("../data/sec/comments.json");
      $toPush = array('headLine' => $_POST['commentHeadLine'] , 'name' => $_POST['name'], 'text' => $_POST['commentText']);
      $data[count($data)] = $toPush;
      jsonWrite("../data/sec/comments.json", $data);
      unset($_POST);
      header("Location: index.php#comments");
    }else{
      header("Location: index.php#writeComment");
    }
  }

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Hacking Challenge 0x01</title>
    <link href="https://fonts.googleapis.com/css?family=Oswald|Permanent+Marker|ZCOOL+KuaiLe" rel="stylesheet">
    <link rel="stylesheet" href="../data/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <img src="../data/img/bg.jpg" alt="" id="background"/>
    <div id="backCover">.</div>
    <div id="contentContainer">
      <div id="headLine">
        <h1>Hacking Challenge <span id="chalID">0x01</span></h1>
        <h2>ESS QUE ELL EI</h2>
      </div>
      <div class="article">
        <h3>Technische Einleitung / Background</h3>
        Wie funktioniert so ein Log-In-System?  - Ganz einfach. Im Hintergrund arbeitet eine <a href="https://www.w3schools.com/sql/" target="_blank">Datenbank</a>, die uns die gesamte Arbeit abnimmt.<br />
        Ach so. Habt ihr den Hinweis gefunden? Er versteckt sich tatsächlich schon im Titel: "ESS QUE ELL EI" betont das mal englisch. Man kommt auf "<a href="https://de.wikipedia.org/wiki/SQL-Injection" target="_blank">SQL I</a>", eine SQL-Injection (=Einschleusung).
        Versuchen wir doch einmal zu verstehen, wie die Datenbank-Abfrage aussehen könnte.
        <code>
          SELECT * FROM users WHERE username="<span class="var">name-input</span>" <a href="https://www.w3schools.com/sql/sql_and_or.asp" target="_blank">AND</a> password="<span class="var">password-input</span>";
        </code>
        Diese Abfrage liefert uns alle Benutzer zurück, die sowohl dem angegeben Benutzernamen (<span class="var">name-input</span>) und das
        angegbene Passwort (<span class="var">password-input</span>) besitzen. Das Anmeldesystem zählt dann einfach nur, ob es einen Benutzer gibt,
        auf den diese Bedingung zutrifft. Beachtet am besten aber auch einen der anderen Operatoren.
      </div>
    </div>
    <div id="footer">
      © Shirkanesi 2019
    </div>
  </body>
</html>


<?php

//SELECT * FROM users WHERE username="admin" AND password="test" OR "1"="1"


 ?>
