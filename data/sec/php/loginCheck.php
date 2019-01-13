<?php
  session_start();
  if(!(isset($_SESSION['ACCESS']) && $_SESSION['ACCESS'] === "granted")){
    //var_dump($_SESSION);
    echo "ERR";
    //header("Location: /HackingChallenge/index.php?nologin");
    die();
  }else{ ?>
    <div id="logout">
      <a href="/HackingChallenge/logout.php">ABMELDEN</a>
    </div>
  <?php
}
 ?>
