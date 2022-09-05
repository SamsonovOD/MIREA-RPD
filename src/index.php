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
    <script>
      //pick_rpd();
    </script>
    <div class="menu">
      <button onclick="switchTab('db_table')">Представление: Таблица</button>
      <button onclick="switchTab('db_form')">Представление: Форма</button>
      <button onclick="switchTab('db_doc')">Представление: Документ</button>
      <a href="reflist.php">Справочники</a>
      <a href="dbdump.php">Дамп БД</a>
    </div>
    <select id="select_rpd" onchange="pick_rpd(this)">
      <option index="0">- Выбор РПД -</option>
      <?php
        $rpds = mysqli_query($con, "SELECT document_ID, name FROM rpd_main, discipline WHERE rpd_main.discipline_ID=discipline.discipline_ID");
        $i = 1;
        while($data = mysqli_fetch_array($rpds)){
          echo "<option index=".$i." value='". $data['document_ID'] ."'>" .$data['name'] ."</option>";
          $i++;
        }
      ?>
    </select>
    <div class="tab_page" id="db_table">
      <?php
        print_cascade("rpd_main", true, $_COOKIE["rpd_id"]);
      ?>
    </div>
    <div class="tab_page" id="db_form">
      <form>
        <table border='1' style='width: 70%'>
        <tr>
          <td style='width: 20%'><label for='discipline'>Наименование дисциплины (модуля):</label></td>
          <td><input type='text' id='insert_discipline' name='discipline'></td>
        </tr>
        <tr>
          <td><label for='profile'>Профль подготовки:</label></td>
          <td><input type='text' id='insert_profile' name='profile'></td>
        </tr>
        <tr>
          <td><label for='institute'>Институт:</label></td>
          <td><input type='text' id='insert_institute' name='institute'></td>
        </tr>
        <tr>
          <td><label for='department'>Кафедра:</label></td>
          <td><input type='text' id='insert_department' name='department'></td>
        </tr>
        <tr>
          <td><label for='speciality'>Код направления (спец.):</label></td>
          <td><input type='text' id='insert_speciality' name='speciality'></td>
        </tr>
        <tr>
          <td><label for='lname'>Трудоемкость (в з.е.):</label></td>
          <td><input type='text' id='lname' name='lname'></td>
        </tr>
        <tr>
          <td><label for='lname'>Учебный план:</label></td>
          <td>
            <label for='lname'>Компетенции:</label>
            <table>
              <tr>
                <th style='width: 10%'>Код</th>
                <th>Описание</th>
              </tr>
              <tr>
                <td><input type='text' id='lname' name='lname'></td>
                <td><input type='text' id='lname' name='lname'></td>
              </tr>
              <tr>
                <td><input type='text' id='lname' name='lname'></td>
                <td><input type='text' id='lname' name='lname'></td>
              </tr>
              <tr>
                <td><input type='text' id='lname' name='lname'></td>
                <td><input type='text' id='lname' name='lname'></td>
              </tr>
            </table>
            <label for='lname'>Занятия:</label>            
            <table>
              <tr>
                <th style='width: 10%'>Вид занятий</th>
                <th>Преподаватель</th>
                <th style='width: 10%'>Кабинет</th>
                <th>Содержание</th>
              </tr>
              <tr>
                <td><input type='text' id='lname' name='lname'></td>
                <td><input type='text' id='lname' name='lname'></td>
                <td><input type='text' id='lname' name='lname'></td>
                <td><input type='text' id='lname' name='lname'></td>
              </tr>
              <tr>
                <td><input type='text' id='lname' name='lname'></td>
                <td><input type='text' id='lname' name='lname'></td>
                <td><input type='text' id='lname' name='lname'></td>
                <td><input type='text' id='lname' name='lname'></td>
              </tr>
              <tr>
                <td><input type='text' id='lname' name='lname'></td>
                <td><input type='text' id='lname' name='lname'></td>
                <td><input type='text' id='lname' name='lname'></td>
                <td><input type='text' id='lname' name='lname'></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>Утвержден:</td>
          <td>
            <label for='date'>Дата утверждения РПД:</label>
            <input type='text' id='insert_date' name='date'>
            <label for='protocol'>Номер протокола:</label>
            <input type='text' id='insert_protocol' name='protocol'>
            <label for='head'>Зав. кафедрой:</label>
            <input type='text' id='insert_head' name='head'>
          </td>
        </tr>
        <tr>
          <td><button>Сохранить</button></td>
          <td></td>
        </tr>
        </table>
      </form>
    </div>
    <div class="tab_page" id="db_doc">
      <div class="export">
        <img src="mirea_logo.png" width="100"><br>
        <span>МИНОБРНАУКИ РОССИИ</span><br>
        <span>Федеральное государственное</span><br>
        <span>бюджетное образовательное учреждение</span><br>
        <span>высшего образования</span><br>
        <span><b>«МИРЭА – Российский технологический университет»</b></span><br>
        <span><b>РТУ МИРЭА</b></span>
        <hr>
        <hr>
        <span>Инстутут <span id="insert_institute">%Институт%</span></span><br>
        <span>Кафедра <span id="insert_department">%Кафедра%</span></span><br>
        <br><br>
        <span><b>РАБОЧАЯ ПРОГРАММА ДИСЦИПЛИНЫ</b></span><br>
        <b>«<span id="insert_discipline">%профиль%</span>»</b>
        <br><br>
        <span>Направление подготовки</span><br>
        <b><span id="insert_speciality_code">%код%</span> «<span id="insert_speciality">%направление%</span>»</b>
        <br><br>
        <span>Профиль подготовки</span><br>
        <b>«<span id="insert_profile">%профиль%</span>»</b>
        <br><br>
        <span>Уровень образования</span><br>
        <b><span id="insert_degree">%степень%</span></b>
        <br><br>
        <span>Форма обучения</span><br>
        <b><span id="insert_from">%форма%</span></b>
        <br><br><br><br><br><br>
        <span id="insert_date">%год%</span>
        <hr>
        <p>Дисциплина «Философия науки и техники» имеет своей целью способствовать формированию у обучающихся общекультурных компетенций ОК-1, ОК-2 и ОК-3 в соответствии с требованиями ФГОС ВО по направлению подготовки магистров 09.04.03 «Прикладная информатика» с учетом специфики магистерской программы «Корпоративные информационные системы».</p>
        <p>Дисциплина «Философия науки и техники» является обязательной дисциплиной базовой части блока «Дисциплины» учебного плана направления подготовки магистров 09.04.03 «Прикладная информатика» магистерской программы «Корпоративные информационные системы».</p>
        <p>Общая трудоемкость дисциплины составляет 3 зачетные единицы (108 часов). Форма промежуточной аттестации – зачет.</p>
        <p>Процесс изучения дисциплины направлен на формирование следующих компетенций:</p>
        <li>ОК-1 — способностью к абстрактному мышлению, анализу, синтезу;</li>
        <li>ОК-2 — готовностью действовать в нестандартных ситуациях, нести социальную и этическую ответственность за принятые решения;</li>
        <li>ОК-3 — готовностью к саморазвитию, самореализации, использованию творческого потенциала.</li>
        <p>В результате изучения дисциплины обучающийся должен:</p>
        <p>знать:</p>
        <li>определение науки и научной рациональности, отличия науки от других сфер культуры;</li>
        <li>системную периодизацию истории науки и техники, основные направления развития их важнейших отраслей и проблем, интеллектуальные революции в культуре;</li>
        <li>общие закономерности современной науки и техники;</li>
        <li>социально-культурные и экологические последствия техники и технологий, принципы экологической философии;</li>
        <li>принципы творчества в науке и технике;</li>
        <li>формы научных дискуссий;</li>
        <p>уметь:</p>
        <li>использовать накопленный опыт научной деятельности;</li>
        <li>аналитически представлять важнейшие события в истории науки и техники, роль и значение учёных и инженеров;</li>
        <li>грамотно обсуждать социально-гуманитарные проблемы науки как составной части культуры;</li>
        <li>самостоятельно ставить проблемные вопросы по курсу, вести аналитическое исследование методологических и социальногуманитарных проблем науки и техники, аргументировано представлять и защищать свою точку зрения;</li>
        <p>владеть:</p>
        <li>приёмами проведения научных исследований.</li>
      </div>
    </div>
    <script>
      cleanupTables();
      autoselectTab();
      autoselectRpd();
      getvalues('#table_discipline', 'name', '#insert_discipline');
      getvalues('#table_profile', 'name', '#insert_profile');
      getvalues('#table_institute', 'name', '#insert_institute');
      getvalues('#table_department', 'name', '#insert_department');
      getvalues('#table_speciality', 'name', '#insert_speciality');
      getvalues('#table_speciality', 'code', '#insert_speciality_code');
      getvalues('#table_department', 'head', '#insert_head');
      getvalues('#table_rpd_main', 'signed_date', '#insert_date');
      getvalues('#table_speciality', 'degree', '#insert_degree');
      getvalues('#table_profile', 'study_form', '#insert_from');
      getvalues('#table_rpd_main', 'protocol', '#insert_protocol');
    </script>
  </body>
  <?php
    mysqli_close($con);
  ?>
</html>