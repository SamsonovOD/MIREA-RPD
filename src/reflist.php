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
    <a href="index.php">Вернуться</a><br>
    <div class="php_box">
      <?php
        require 'form_functions.php';
      ?>
    </div>
    <h1>Институты</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("institute");
      ?>
    </div>
    <h1>Кафедры</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("department");
      ?>
    </div>
    <h1>Преподаватели</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("teacher");
      ?>
    </div>
    <!--
    <h1>Знания</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("knowledge");
      ?>
    </div>
    <h1>Умения</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("ability");
      ?>
    </div>
    <h1>Навыки</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("skill");
      ?>
    </div>
    <h1>Списки знаний</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("knowledge_list");
      ?>
    </div>
    <h1>Списки умений</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("ability_list");
      ?>
    </div>
    <h1>Списки навыков</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("skill_list");
      ?>
    </div>
    -->
    <h1>Компетенции</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("competence");
      ?>
    </div>
    <h1>Список компетенций</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("competence_list");
      ?>
    </div>
    <h1>Литератруа</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("textbook");
      ?>
    </div>
    <h1>Занятия</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("lesson");
      ?>
    </div>
    <h1>Список занятий</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("lesson_list");
      ?>
    </div>
    <h1>Специальности</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("speciality");
      ?>
    </div>
    <h1>Программы</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("profile");
      ?>
    </div>
    <h1>Дисциплины</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("discipline");
      ?>
    </div>
    <h1>РПД</h1>
    <button class="collapsible-button" onclick="collapse(this)">Свернуть</button>
    <div class="collapsible-content">
      <?php
        print_editable("rpd_main");
      ?>
    </div>
  </body>
  <?php
    mysqli_close($con);
  ?>
</html>