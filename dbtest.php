<form method="get" action="">
  <input type="text" placeholder="Statement" name="statement" value="<?php echo $_GET['statement']; ?>" />
  <input type="submit" value="Senden"/>
</form>

<?php
  $servername = "localhost";
  $username = "root";
  $password = "";


  //To load all Devices: SELECT DISTINCT arduino FROM temp

  try {
      $conn = new PDO("mysql:host=$servername;dbname=hackingchallenge", $username, $password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";


      $quarry = $_GET['statement'];

      $stmt = $conn->prepare($quarry);
      $stmt->execute();

       // set the resulting array to associative
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $response = $stmt->fetchAll();
      $response = array_reverse($response);
      for ($i=0; $i < sizeof($response); $i++) {
        echo "<br />";
        var_dump($response[$i]);
      }

      $conn = null;

      }
  catch(PDOException $e){
      echo "Connection failed: " . $e->getMessage();
  }
