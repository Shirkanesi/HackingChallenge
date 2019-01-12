<?php

function jsonRead($path){
  $file = fopen($path, "a+") or die("Unable to open file!");
  rewind($file);
  @$json = fread($file, filesize($path));
  $decode = json_decode($json, true);
  fclose($file);
  return $decode;
}

function jsonWrite($path, $data){
  $file = fopen($path, "w+");
  $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
  fwrite($file, $json);
  fclose($file);
}

 ?>
