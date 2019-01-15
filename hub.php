<?php
  include 'data/sec/php/loginCheck.php';
  include 'data/sec/php/jsonStuff.php';

  echo "<div class=\"inv\">";
  function addSolved($challenge, $points){
    $dataFile = jsonRead("data/sec/userdata.json");
    if($dataFile[$_SESSION['USER-ID']]['solves'][$challenge] != "solved"){
      @$dataFile[$_SESSION['USER-ID']]['solves'][$challenge] = "solved";
      $dataFile[$_SESSION['USER-ID']]['score'] += $points;
      jsonWrite("data/sec/userdata.json", $dataFile);
    }
  }



  //var_dump($_SESSION);

  $change = false;

  if(isset($_POST['0x01-input'])){
    if($_POST['0x01-input'] === "CTF{77354ba7-0567-478f-9086-8dd3307c5be7}"){
      addSolved("0x01", 100);
    }
    $change = true;
  }
  if(isset($_POST['0x02-input'])){
    if($_POST['0x02-input'] === "Jul14n15tC00l"){
      addSolved("0x02", 100);
    }else if($_POST['0x02-input'] === "IchWillAdminSein-123-PW"){
      addSolved("0x02-b", 25);
    }
    $change = true;
  }

  if($change){
    header("Location: hub.php");
  }

  $dataFile = jsonRead("data/sec/userdata.json");
  $score = $dataFile[$_SESSION['USER-ID']]['score'];

  echo "</div>";


 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Hacking Challenge</title>
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
        <h3>Hallo <?php echo $_SESSION['USER-NAME']; ?>,</h3>
        Wie geht es dir? <br />Auf dieser Seite kannst du alle verfügbaren Aufgaben sehen und auch die Lösungen (Flags) abgeben.
        Die Punkteangaben beziehen sich immer auf die Hauptaufgabe. Es kann durchaus sein, dass es auch noch weniger Pukte für eine andere Eingabe geben kann.
        Also: Immer schön aufmerksam sein und schauen, ob man auch noch andere spannende Informationen finden kann. Viel Spaß
        <h3>Dein momentaner Punktestand beträgt: <u><?php echo $score; ?> Punkte</u></h3>
      </div>
      <div class="article">
        <h3><span class="chalID">0x00</span>: Einführung</h3>
        <a href="0x00/" class="toChallenge" target="_blank">Zur Challenge</a>
      </div>
      <div class="article">
        <h3><span class="chalID">0x01</span>: ESS QUE ELL EI  (+100 Punkte)</h3>
        <a href="0x01/" class="toChallenge" target="_blank">Zur Challenge</a>
        <form class="abgabe" method="post" action="">
          <input type="text" name="0x01-input" pattern="[C]+[T]+[F]+[{]+.+[}]" title="CTF{YOUR FLAG}" placeholder="Flag (Format: CTF{})"/>
          <input type="submit" value="Abgeben" />
        </form>
      </div>
      <div class="article">
        <h3><span class="chalID">0x02</span>: ESS QUE ELL EI 2 .0  (+100 Punkte)</h3>
        <a href="0x02/" class="toChallenge" target="_blank">Zur Challenge</a>
        <form class="abgabe" method="post" action="">
          <input type="text" name="0x02-input" placeholder="Admin-Passwort"/>
          <input type="submit" value="Abgeben" />
        </form>
      </div>
      <div class="article">
        <h3>Einleitung & Aufgabenstellung</h3>
        Das hier ist die erste Hacking Challenge für die <a href="https://informatikag.de" target="_blank">Informatik-AG</a>. Auf dieser Seite ist absichtlich eine Sicherheitslücke eingebaut, die es euch ermöglicht die Aufgabe zu erfüllen. Euer Ziel ist es, dafür zu sorgen, dass jeder Benutzer, der diese Seite aufruft eine
        <a href="https://www.w3schools.com/jsref/met_win_alert.asp" target="_blank">Alert-Box</a> mit dem Inhalt "XSS on this page!" anzeigt. Am besten benutzt ihr FireFox, der ist am besten geeignet, um diese Art von Angriff durchzuführen. Die einzige Aktion des Benutzers darf maximal nur ein Klick sein. Es gelten die normalen Regeln des Anstandes. Bitte geht nicht böswillig an diese Aufgabe heran. Achso. Es kann auch durchaus sein, dass ich hier irgendwo ein paar Tipps eingebaut habe :P
      </div>
    </div>
    <div id="footer">
      © Shirkanesi 2019
    </div>
  </body>
</html>
