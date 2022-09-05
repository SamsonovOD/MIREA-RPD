<?php
  if(isset($_POST['add'])){
    $sql = 'INSERT INTO '.$_POST['table'];
    $t1 = ' (';
    for($col=2; $col<count($_POST); $col++){
      $t1 = $t1.array_keys($_POST)[$col].', ';
    }
    $sql = $sql.substr($t1, 0, -2).')';
    $t1 = ' VALUES (';
    for($col=2; $col<count($_POST); $col++){
      $t1 = $t1.'"'.$_POST[array_keys($_POST)[$col]].'", ';
    }
    $sql = $sql.substr($t1, 0, -2).')';
    echo $sql;
    $act = mysqli_query($con, $sql);
    if ($act){
      echo " OK.";
    } else {
      echo mysqli_error($con);
    }
  }
  if(isset($_POST['delete'])){
    $sql = 'DELETE FROM '.$_POST['table'].' WHERE '.array_keys($_POST)[1].' = "'.$_POST[array_keys($_POST)[1]].'"';
    $act = mysqli_query($con, $sql);
    if ($act){
      echo " OK.";
    } else {
      echo mysqli_error($con);
    }
  }
  if(isset($_POST['update'])){
    $sql = 'UPDATE '.$_POST['table'].' SET ';
    for($col=3; $col<count($_POST); $col++){
      $sql = $sql.''.array_keys($_POST)[$col].' = "'.$_POST[array_keys($_POST)[$col]].'", ';
    }
    $sql = substr($sql, 0, -2).' WHERE '.array_keys($_POST)[1].' = "'.$_POST[array_keys($_POST)[1]].'"';
    echo $sql;
    $act = mysqli_query($con, $sql);
    if ($act){
      echo " OK.";
    } else {
      echo mysqli_error($con);
    }
  }
?>