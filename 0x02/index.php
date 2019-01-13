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
        <h2>ESS QUE ELL EI  2 .0</h2>
      </div>
      <div class="article">
        <h3>Einleitung & Aufgabenstellung</h3>
        Das hier ist die zweite Hacking Challenge für die <a href="https://informatikag.de" target="_blank">Informatik-AG</a>. Auf dieser Seite ist absichtlich eine Sicherheitslücke eingebaut, die es euch ermöglicht die Aufgabe zu erfüllen.
        Euer Ziel ist es, das Administrator-Passwort herauszufinden.
        Ein kleiner Hinweis noch: Der Benutzername ist <strong>admin</strong>.<br />
        Es gelten die normalen Regeln des Anstandes. Bitte geht nicht böswillig an diese Aufgabe heran. Achso. Es kann auch durchaus sein, dass ich hier irgendwo ein paar Tipps eingebaut habe :P
      </div>
      <div class="article">
        <h3>Technische Einleitung / Background</h3>
        Um euch den Spaß am rätseln (und finden des Hinweises, der hier versteckt ist) nicht zu nehmen, findet ihr den <a href="hint.php" target="_blank">Technischen Hintergrund hier</a>.
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
                '.htmlspecialchars($value['headLine']).'
              </div>
              <div class="commentName">
                von '.htmlspecialchars($value['name']).'
              </div>
              <div class="commentText">
                '.htmlspecialchars($value['text']).'
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
          <label for="name">Dein Name:</label><br />
          <input type="text" name="name" value="<?php if(isset($_POST['name'])) echo $_POST['name'];  ?>"/><br />
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

        <?php
          if (isset($_POST['searchSub'])){
            $servername = "localhost";
            $username = "root";
            $password = "";
            $mysqli = new mysqli($servername, $username, $password, "hackingchallenge");
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }

            $sql = "SELECT * FROM comments WHERE comment LIKE \"%".$_POST['search']."%\";";

            if (!$mysqli->multi_query($sql)) {
                //echo "Multi query failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }

            do {
                if ($res = $mysqli->store_result()) {
                    $response = $res->fetch_all(MYSQLI_ASSOC);
                    //var_dump($response);
                    echo "<br />";
                    foreach ($response as $resp) {
                      $data = array();
                      foreach ($resp as $value) {
                        $data[count($data)] = $value;
                      }

                        echo '
                        <div class="comment">
                          <div class="commentHeader">
                            '.htmlspecialchars($data[1]).'
                          </div>
                          <div class="commentName">
                            von '.htmlspecialchars($data[2]).'
                          </div>
                          <div class="commentText">
                            '.htmlspecialchars($data[3]).'
                          </div>
                        </div>
                        ';
                    }

                    $res->free();
                }
            } while ($mysqli->more_results() && $mysqli->next_result());
          }
        ?>

        <?php
          //SELECT * FROM comments WHERE comment LIKE "Wer"
         ?>
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
        <?php
          if (isset($_POST['adminSubmit'])){
            $servername = "localhost";
            $username = "root";
            $password = "";
            try {
                $conn = new PDO("mysql:host=$servername;dbname=hackingchallenge", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $quarry = "SELECT * FROM users WHERE username=\"".$_POST['us-name']."\" AND password=\"".$_POST['us-pw']."\"";
                $quarry = str_replace(";", "YOU ARE NOT ALLOWED TO USE AN <strong>;</strong>   ", $quarry);
                $quarry .= ";";
                $stmt = $conn->prepare($quarry);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $response = $stmt->fetchAll();
                if(count($response)>0){
                  echo "CTF{77354ba7-0567-478f-9086-8dd3307c5be7}";
                }else{
                  echo "CTF{Du-dachtest-so-einfach}";
                }
                $conn = null;
            }catch(PDOException $e){
                echo "Connection failed: " . str_replace("SQL", "<strong><u><i>SQL</i></u></strong>", $e->getMessage());
            }
          }
        ?>

      </div>
    </div>
    <div id="footer">
      © Shirkanesi 2019
    </div>
  </body>
</html>
