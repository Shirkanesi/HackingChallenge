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
    <title>Hacking Challenge 0x02</title>
    <link href="https://fonts.googleapis.com/css?family=Oswald|Permanent+Marker|ZCOOL+KuaiLe" rel="stylesheet">
    <link rel="stylesheet" href="../data/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <img src="../data/img/bg.jpg" alt="" id="background"/>
    <div id="backCover">.</div>
    <div id="contentContainer">
      <div id="headLine">
        <h1>Hacking Challenge <span id="chalID">0x02</span></h1>
        <h2>ESS QUE ELL EI 2.0</h2>
      </div>
      <div class="article">
        <h3>Technische Einleitung / Background</h3>
        <!--Wie funktioniert so ein Log-In-System?  - Ganz einfach. Im Hintergrund arbeitet eine <a href="https://www.w3schools.com/sql/" target="_blank">Datenbank</a>, die uns die gesamte Arbeit abnimmt.<br />
        Ach so. Habt ihr den Hinweis gefunden? Er versteckt sich tatsächlich schon im Titel: "ESS QUE ELL EI" betont das mal englisch. Man kommt auf "<a href="https://de.wikipedia.org/wiki/SQL-Injection" target="_blank">SQL I</a>", eine SQL-Injection (=Einschleusung).-->

        Versuchen wir doch einmal zu verstehen, wie die Datenbank-Abfrage aussehen könnte.
        Wichtiger Hinweis: Die Datenbank mit den Benutzerdaten trägt den Namen <strong>users</strong>!
        <code>
          SELECT * FROM comments WHERE comment <a href="https://www.w3schools.com/sql/sql_like.asp" target="_blank">LIKE</a> "<a href="https://www.w3schools.com/sql/sql_wildcards.asp" target="_blank">%</a><span class="var">search-input</span><a href="https://www.w3schools.com/sql/sql_wildcards.asp" target="_blank">%</a>";
        </code>
        Diese Abfrage liefert uns alle Kommentare zurück, die den Suchbegriff (<span class="var">search-input</span>) enthalten ist.<br />
        Ich gebe euch noch folgende Tipps: <br />
        &emsp;Ein ; beendet einen SQL-Befehl.<br />
        &emsp;Ein <a href="https://www.w3schools.com/sql/sql_comments.asp" target="_blank">--</a> beginnt einen <a href="https://www.w3schools.com/sql/sql_comments.asp" target="_blank">Kommentar</a>. Das bedeutet, dass alles, was dahinter steht nicht als tatsächlicher Code angesehen wird.
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
