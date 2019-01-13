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
    <title>Hacking Challenge 0x00</title>
    <link href="https://fonts.googleapis.com/css?family=Oswald|Permanent+Marker|ZCOOL+KuaiLe" rel="stylesheet">
    <link rel="stylesheet" href="../data/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <img src="../data/img/bg.jpg" alt="" id="background"/>
    <div id="backCover">.</div>
    <div id="contentContainer">
      <div id="headLine">
        <h1>Hacking Challenge <span id="chalID">0x00</span></h1>
        <h2>Einführung</h2>
      </div>
      <div class="article">
        <h3>Einleitung & Aufgabenstellung</h3>
        Das hier ist die erste Hacking Challenge für die <a href="https://informatikag.de" target="_blank">Informatik-AG</a>. Auf dieser Seite ist absichtlich eine Sicherheitslücke eingebaut, die es euch ermöglicht die Aufgabe zu erfüllen. Euer Ziel ist es, dafür zu sorgen, dass jeder Benutzer, der diese Seite aufruft eine
        <a href="https://www.w3schools.com/jsref/met_win_alert.asp" target="_blank">Alert-Box</a> mit dem Inhalt "XSS on this page!" anzeigt. Am besten benutzt ihr FireFox, der ist am besten geeignet, um diese Art von Angriff durchzuführen. Die einzige Aktion des Benutzers darf maximal nur ein Klick sein. Es gelten die normalen Regeln des Anstandes. Bitte geht nicht böswillig an diese Aufgabe heran. Achso. Es kann auch durchaus sein, dass ich hier irgendwo ein paar Tipps eingebaut habe :P
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
          &lt;<a href="https://www.w3schools.com/tags/tag_button.asp" target="_blank">button</a> <a href="https://www.w3schools.com/jsref/event_onclick.asp" target="_blank">onclick</a>='<a href="https://www.w3schools.com/jsref/met_win_alert.asp" target="_blank">alert(&quot;Guten Tag&quot;);</a>'&gt;Ausprobieren&lt;/button&gt;
        </code>
      </div>
      <div class="article" id="comments">
        <h3>Kommentare</h3>
        <?php
          $comments = jsonRead("../data/sec/comments.json");
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
      <div class="article" id="writeComment">
        <h3>Kommentar schreiben</h3>
        <form action="" method="post">
          <label for="commentHeadLine">Überschrift:</label><br />
          <input type="text" name="commentHeadLine" value="<?php if(isset($_POST['commentHeadLine'])) echo $_POST['commentHeadLine'];  ?>" /><br />
          <label for="name" class="inv">Dein Name:</label>
          <input type="text" class="inv" name="name" value="<?php echo $_SESSION['USER-NAME'];  ?>"/>
          <label for="commentText">Kommentar:</label><br />
          <textarea name="commentText" value="<?php if(isset($_POST['commentText'])) echo $_POST['commentText'];  ?>"></textarea><br />
          <input type="submit" value="Kommentieren" />
        </form>
      </div>
      <div class="article" id="commentSearch">
        <h3>Kommentar suchen</h3>
        <form action="#commentSearch" method="post">
          <label for="search">Suche:</label><br />
          <input type="text" name="search" /><br />
          <input type="submit" name="searchSub" value="Suchen" />
        </form>
        <?php if (isset($_POST['searchSub'])): ?>
          The comment-db is not implemented yet.
        <?php endif; ?>
      </div>
      <div class="article" id="admin">
        <h3>Admin-Login</h3>
        <form action="#admin" method="post">
          <label for="us-name">Benutzername:</label><br />
          <input type="text" name="us-name" /><br />
          <label for="us-pw">Passwort:</label><br />
          <input type="password" name="us-pw" /><br />
          <input type="submit" name="adminSubmit" value="Login" />
        </form>
        <?php if (isset($_POST['adminSubmit'])): ?>
          Wrong username or password!
        <?php endif; ?>
      </div>
    </div>
    <div id="footer">
      © Shirkanesi 2019
    </div>
  </body>
</html>
