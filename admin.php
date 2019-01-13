<?php
  include 'data/sec/php/loginCheck.php';
  include 'data/sec/php/jsonStuff.php';
  if($_SESSION['RANK']>0){
    header("Location: qwertz.php");
  }

  echo "<div class=\"inv\">";
  function addSolved($challenge, $points, $id){
    $dataFile = jsonRead("data/sec/userdata.json");
    if($dataFile[$_SESSION['USER-ID']]['solves'][$challenge] != "solved"){
      @$dataFile[$_SESSION['USER-ID']]['solves'][$challenge] = "solved";
      $dataFile[$_SESSION['USER-ID']]['score'] += $points;
      jsonWrite("data/sec/userdata.json", $dataFile);
    }
  }


  $change = false;
  foreach ($_POST as $key => $value) {
    if(strpos($key, "0x00")!==false){
      $id = explode("-", $key)[0];
      addSolved("0x00", 75, $id);
      $change = true;
    }
  }
  if($change){
    header("Location: admin.php");
  }
  echo "</div>";
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Hacking Challenge - Admin</title>
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
        <h2>Admin-Interface</h2>
      </div>
      <div class="article">
        <h3>Hallo <?php echo $_SESSION['USER-NAME']; ?>,</h3>
        Wie geht es dir?
      </div>
      <?php
        $dataFile = jsonRead("data/sec/userdata.json");

        foreach ($dataFile as $id => $value) {
          $sol = "<br />";
          foreach ($value['solves'] as $name => $SolveMARK) {
            $sol .= '<span class="indent">'.$name."</span><br />";
          }
          echo '
          <div class="article">
            <h3>'.hex2bin($value['name']).' ('.$id.')</h3>
            Punktestand: '.$value['score'].' Punkte <br />
            Gelößte Challenges: '.$sol.'
            <form method="post"><input type="submit" name="'.$id.'-0x00" value="0x00 gelößt." /></form>
          </div>
          ';
        }

       ?>


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
