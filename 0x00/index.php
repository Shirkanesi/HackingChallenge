<?php
  include 'data/jsonStuff.php';

  if(isset($_POST['commentText'])){
    $data = jsonRead("data/comments.json");
    $toPush = array('headLine' => $_POST['commentHeadLine'] , 'name' => $_POST['name'], 'text' => $_POST['commentText']);
    $data[count($data)] = $toPush;
    jsonWrite("data/comments.json", $data);
    unset($_POST);
    header("Location: index.php");
  }

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Hacking Challenge 0x00</title>
    <link href="https://fonts.googleapis.com/css?family=Oswald|Permanent+Marker" rel="stylesheet">
    <link rel="stylesheet" href="data/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <img src="data/img/bg.jpg" alt="" id="background"/>
    <div id="backCover">.</div>
    <div id="contentContainer">
      <div id="headLine">
        Hacking Challenge 0x00
      </div>
      <div class="article">
        <h3>Einleitung & Aufgabenstellung</h3>
        Das hier ist die erste Hacking Challenge für die Informatik-AG. Euer Ziel ist es, dafür zu sorgen, dass jeder Benutzer, der diese Seite aufruft eine
        Alert-Box mit dem Inhalt "XSS on this page!" anzeigt. Am besten benutzt ihr FireFox, der ist am besten geeignet, um diese Art von Angriff durchzuführen. Die einzige Aktion des Users darf maximal nur ein Klick sein. Es gelten die normalen Regeln des Anstandes. Bitte geht nicht böswillig an diese Aufgabe heran,
        sodass die Aufgabe für andere unlösbar wird. Achso. Es kann auch durchaus sein, dass ich hier irgendwo ein paar Tipps eingebaut habe :P
      </div>
      <div class="article">
        <h3>Technische Einleitung / Background</h3>
        Wie funktioniert so eine Alert-Box?  - Ganz einfach. Eine solche Box wird mit <a href="https://www.w3schools.com/js/default.asp" target="_blank">JavaScript</a> erzeugt. Der Syntax dafür
        lautet folgendermaßen:
        <code>
          alert("Guten Tag");
        </code>
        <button onclick='alert("Guten Tag");' class="try">Ausprobieren</button>
        Der <a href="https://www.w3schools.com/tags/tag_button.asp" target="_blank">Knopf</a> benutzt folgenden <a target="_blank" href="https://www.w3schools.com/html/">HTML-Syntax</a>:
        <code>
          &lt;<a href="https://www.w3schools.com/tags/tag_button.asp" target="_blank">button</a> <a href="https://www.w3schools.com/jsref/event_onclick.asp" target="_blank">onclick='alert(&quot;Guten Tag&quot;);'</a>&gt;Ausprobieren&lt;/button&gt;
        </code>
      </div>
      <div class="article">
        <h3>Kommentare</h3>
        <?php
          $comments = jsonRead("data/comments.json");
          if($comments == NULL) $comments = $data;
          //var_dump($data);
          foreach ($comments as $value) {
            echo '
            <div class="comment">
              <div class="commentHeader">
                '.$value['headLine'].'
              </div>
              <div class="commentName">
                von '.$value['name'].'
              </div>
              <div class="commentText">
                '.$value['text'].'
              </div>
            </div>
            ';
          }

         ?>
      </div>
      <div class="article">
        <h3>Kommentar schreiben</h3>
        <form action="" method="post">
          <label for="commentHeadLine">Überschrift:</label><br />
          <input type="text" name="commentHeadLine" /><br />
          <label for="name">Dein Name:</label><br />
          <input type="text" name="name" /><br />
          <label for="commentText">Kommentar:</label><br />
          <textarea name="commentText" ></textarea><br />
          <input type="submit" value="Kommentieren" />
        </form>
      </div>
    </div>
    <div id="footer">
      © Shirkanesi 2019
    </div>
  </body>
</html>
