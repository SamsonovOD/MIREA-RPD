<?php
  function get_fields($table){
    global $con;
    $columns = [];
    $get = mysqli_query($con, "DESCRIBE ".strval($table));
    while($param = mysqli_fetch_array($get)){
      array_push($columns, $param['Field']);
    }
    return $columns;
  }

  function get_types($table){
    global $con;
    $columns = [];
    $get = mysqli_query($con, "DESCRIBE ".strval($table));
    while($param = mysqli_fetch_array($get)){
      array_push($columns, $param['Type']);
    }
    return $columns;
  }
  
  function get_columncommnets($table){
    global $SERVER;
    global $USERNAME;
    global $PASSWORD;
    $admin = new mysqli($SERVER, $USERNAME, $PASSWORD, "information_schema");
    $sql = "SELECT COLUMN_COMMENT FROM COLUMNS WHERE TABLE_SCHEMA = 'rpd_db' AND TABLE_NAME = '".strval($table)."'";
    $get = mysqli_query($admin, $sql);
    $comments = [];
    while($row = mysqli_fetch_array($get)){
      array_push($comments, $row["COLUMN_COMMENT"]);
    }
    mysqli_close($admin);
    return $comments;
  }

  function get_primekey($table){
    global $SERVER;
    global $USERNAME;
    global $PASSWORD;
    $admin = new mysqli($SERVER, $USERNAME, $PASSWORD, "information_schema");
    $sql = "SELECT COLUMN_NAME FROM COLUMNS WHERE TABLE_SCHEMA = 'rpd_db' AND COLUMN_KEY = ('MUL') AND TABLE_NAME = '".strval($table)."'";
    $get = mysqli_query($admin, $sql);
    $line = mysqli_fetch_array($get);
    if ($line != NULL){
      $key = $line["COLUMN_NAME"];
    } else {
      $sql = "SELECT COLUMN_NAME FROM COLUMNS WHERE TABLE_SCHEMA = 'rpd_db' AND COLUMN_KEY = ('PRI') AND TABLE_NAME = '".strval($table)."'";
      $get = mysqli_query($admin, $sql);
      $key = mysqli_fetch_array($get)["COLUMN_NAME"];
    }
    mysqli_close($admin);
    return $key;
  }
  
  function find_related($table){
    global $SERVER;
    global $USERNAME;
    global $PASSWORD;
    $admin = new mysqli($SERVER, $USERNAME, $PASSWORD, "phpmyadmin");
    $get = mysqli_query($admin, "SELECT * FROM pma__relation");
    $related = []; //master_db.master_table.master_field, foreign_db.foreign_table.foreign_field
    while($relation = mysqli_fetch_array($get)){
      if ($relation['master_table'] == $table){
        array_push($related, $relation);
      }
    }
    mysqli_close($admin);
    return $related;
  }
  
  function print_table($table, $selectable, $id){
    if ($id != false){   
      global $con;  
      $cols = get_fields($table);
      if ($selectable == true) {
        $sql = "SELECT * FROM ".strval($table)." WHERE ".strval(get_primekey($table))." = ".strval($id);
      } else {        
        $sql = "SELECT * FROM ".strval($table);
      }
      $get = mysqli_query($con, $sql);
      echo "<div>";
      echo "<h1>".$table."</h1>";
      echo '<table id="table_'.strval($table).'">'; 
      echo "<thead>"; 
      foreach($cols as &$col){
        echo "<th>".$col."</th>";
      }
      echo "</thead>"; 
      echo "<tbody>";
      while($row = mysqli_fetch_array($get)){
        echo "<tr>";
        foreach($cols as &$col){
          echo "<td>".$row[$col]."</td>";
        }
        echo "</tr>";
      }
      echo "</tbody>"; 
      echo "</table>";
      echo "</div>";
    }
  }

  function set_input($table, $type_list, $number, $name, $value, $filled){
    global $con;
    $related = find_related($table);
    $list = False;
    foreach($related as &$r){
      if($name == $r['master_field']){
        $list = [$r['foreign_table'], $r['foreign_field']];
      }
    }
    if ($list == False){
      if ($type_list[$number] == "text"){
        $type = "text";
        $len = "65535";
      } elseif ($type_list[$number] == "date") {
        $type = $type_list[$number];
      } else {
        $type = explode('(', $type_list[$number])[0];
        $len = str_replace(')', '', explode('(', $type_list[$number])[1]);
      }
      if ($type == "varchar"){
        echo '<input type="text" maxlength="'.$len.'" ';
      } else if ($type == "int"){
        echo '<input type="number" min="1" max="'.pow(10, intval($len))-1 .'" ';
      } else if ($type == "text"){
        echo '<input type="text" maxlength="'.$len.'" ';
      } else if ($type == "year"){
        echo '<input type="number" min="1901" max="2155" ';
      } else if ($type == "date"){
        echo '<input type="date" min="1901-01-01" max="2155-01-01" ';
      }
      if ($filled == True){
        echo 'name="'.$name.'" value="'.$value.'" required>';
      } else {
        echo 'name="'.$name.'" placeholder="'.$value.'" required>';
      }
    } else {
      echo '<select name="'.$name.'">';
      $id = strval(get_primekey($list[0]));
      $sql = "SELECT * FROM ".$list[0];
      $options = mysqli_query($con, $sql);
      $i = 1;
      echo '<option value="0">N/A</option>';
      while($data = mysqli_fetch_array($options)){
        echo "<option value='".$data[$id]."'";
        if ($data[$id] == $value){
          echo " selected ";
        }
        if (in_array('name', array_keys($data))){
          echo ">".$data['name']."</option>";
        } else {
          echo ">".$data[$id]."</option>";
        }
        $i++;
      }
    }
  }

  function print_editable($table){
    global $con;
    $col_names = get_fields($table);
    $col_comments = get_columncommnets($table);
    $col_types = get_types($table);
    echo "<table name=table_".strval($table).">"; 
    echo "<thead>";
    for($col=0; $col<count($col_comments); $col++){
      if ($col_comments[$col] != ""){
        echo "<th>".$col_comments[$col]."</th>";
      } else {
        $col_comments[$col] = $col_names[$col];
        echo "<th>".$col_comments[$col]."</th>";
      }
    }
    echo "</thead>"; 
    echo "<tbody>"; 
    $sql = "SELECT * FROM ".strval($table);
    $get = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($get)){
      echo "<tr>";
      echo "<form method='POST'>";
      echo "<input type='hidden' name='table' value='".$table."'>";
      echo "<td>";
      echo "<input type='hidden' name='".$col_names[0]."' value='".$row[$col_names[0]]."'>";
      echo $row[$col_names[0]];
      echo "<button name='update'>Сохранить</button>";
      echo "<button name='delete'>Удалить</button>";
      echo "</td>";
      for($col=1; $col<count($col_names); $col++){
        echo "<td>";
        set_input($table, $col_types, $col, $col_names[$col], $row[$col_names[$col]], True);
        echo "</td>";
        }
      echo "</form>";
      echo "</tr>";
    }
    echo '<form method="POST">';
    echo '<input type="hidden" name="table" value="'.$table.'">';
    echo '<td><button type="submit" name="add">Добавить</button></td>';
    for($col=1; $col<count($col_names); $col++){
      echo "<td>";
      set_input($table, $col_types, $col, $col_names[$col], $col_comments[$col], False);
      echo "</td>";
    }
    echo '</form>';
    echo '</tbody>'; 
    echo '</table>';
  }
  
  function print_cascade($table, $selectable, $id){
    print_table($table, $selectable, $id);
    if ($id != null){
      $related = find_related($table);
      global $con;
      try {
        if ($selectable == true){
          $get = mysqli_query($con, "SELECT * FROM ".strval($table)." WHERE ".strval(get_primekey($table))." = ".strval($id));
        } else {
           $get = mysqli_query($con, "SELECT * FROM ".strval($table));
        }
        $relations = [];
        for($r=0; $r<count($related); $r++){
          array_push($relations, array("table" => $related[$r]['foreign_table'], "field" => $related[$r]['foreign_field']));
        }
        while($row = mysqli_fetch_array($get)){
          $cols = array_keys($row);
          foreach($cols as &$col){
            if (!is_numeric($col)){
              for($r=0; $r<count($related); $r++){
                if($relations[$r]["field"] == $col){
                  $table = $relations[$r]["table"];
                  $id = $row[$col];
                  print_cascade($table, $selectable, strval($id));
                }          
              }
            }
          }
        }
      } catch (TypeError $e){
        echo $e;
      }
    }
  }
?>