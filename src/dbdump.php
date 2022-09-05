<?php
  require 'connect.php';
  require 'db_functions.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <script src="scripts.js"></script>
    <a href="index.php">Вернуться</a>
    <div id="db_table">
      <?php print_cascade("rpd_main", false, -1); ?>
    </div>
    <script>
      cleanupTables();
    </script>
  </body>
  <?php
    mysqli_close($con);
  ?>
</html>