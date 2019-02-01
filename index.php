<!DOCTYPE html>
<html lang="ru">
<head>
  <?php
  $website_title = 'Bauart test';
  require 'blocks/head.php'
  ?>
</head>
<body>

  <!--
    Верхний блок страницы, с панелью навигации.
  -->
  <?php require 'blocks/header.php' ?>

  <!--
    Боковой блок со списком статей.
  -->
  <aside>
    <ul id="list">
      <?php
        //Выводим заголовки статей в левый блок
        require_once 'mysql_connect.php';

        $sql = 'SELECT * FROM `articles` ORDER BY `id` ASC';
        $query = $pdo->query($sql);
        while($row = $query->fetch(PDO::FETCH_OBJ)) {
          echo "<li><a href=\"#\" id=\"$row->id\">$row->title</a></li>";
        }
      ?>
    </ul>
  </aside>

  <!--
    Правый блок с формой регистрации и отображением статей
  -->
  <div id="right">
    <!--
      Форма добавления статей
    -->
    <h3 id="form-text">Добавление статьи</h3>
    <form action="" method="post">
      <label for="title">Название статьи:</label>
      <input type="text" id="title" name="title" required>

      <label for="text">Текст статьи:</label>
      <textarea name="text" id="text"></textarea>

      <button type="button" id="add_article">Добавить</button>
    </form>

    <div id="resultblock">

    </div>

    <!--
      Место отображения статей по клику из списка статей
    -->
    <div class="article">

    </div>

  <!--
    Нижний блок страницы
  -->
  <?php require 'blocks/footer.php' ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>
    //Добавляем обработчик на список, получаем id по клику, выводим статью
    document.querySelector('#list').addEventListener('click', function(e){
      var id = e.target.id;

      $.ajax({
        url: 'ajax/get_article.php',
        type: 'POST',
        cache: false,
        data: {'id' : id},
        dataType: 'html',
        success: function(data) {
          $(".article").html("");
          $(".article").append(data);
        }
      });
    });

    //Обрабатываем событие на кнопке формы
    $('#add_article').click(function(){
      var title = $('#title').val();
      var text = $('#text').val();

      $.ajax({
        url: 'ajax/add_article.php',
        type: 'POST',
        cache: false,
        data: {'title' : title, 'text' : text},
        dataType: 'json',
        success: function(result) {
          if(result['status'] == 'Готово') {
            $("#list").append("<li><a href=\"#\" id=\"" + result['id'] + "\">" + $('#title').val() + "</a></li>");

            var title = $('#title').val("");
            var text = $('#text').val("");

            //Отображение блока с результатом операции
            document.getElementById("resultblock").className = 'succes_block';
            $('#resultblock').show();
            $('#resultblock').text(result['status']);
          }
          else {
            document.getElementById("resultblock").className = 'error_block';
            $('#resultblock').show();
            $('#resultblock').text(result['status']);
          }
        }
      });
    });
  </script>
</body>
</html>
