<?php
  $SERVER = "localhost";
  $USERNAME = "Amon";
  $PASSWORD = "QwaQwa33";

  $con = new mysqli($SERVER, $USERNAME, $PASSWORD, "rpd_db");
  if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: ".mysqli_connect_error();
  }
?>