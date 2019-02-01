<?php
  //Получаем данные из формы
  $title = trim(filter_var($_POST['title'], FILTER_SANITIZE_STRING));
  $text = trim(filter_var($_POST['text'], FILTER_SANITIZE_STRING));

  //Проверяем их
  $error = '';
  if(strlen($title) == 0)
    $error = 'Введите название статьи';
  else if(strlen($text) == 0)
    $error = 'Введите текст статьи';

  if($error != '') {
    echo $error;
    exit;
  }

  //Добовляем запись в базу данных
  require_once '../mysql_connect.php';

  $sql = 'INSERT INTO articles(title, text) VALUES(?, ?)';
  $query = $pdo->prepare($sql);
  $query->execute([$title, $text]);

  $sql = 'SELECT * FROM `articles` WHERE `title` = :title';
  $query = $pdo->prepare($sql);
  $query->execute(['title' => $title]);
  $article = $query->fetch(PDO::FETCH_OBJ);

  $answer=array(
    'status' => 'Готово',
    'id' => $article->id,
  );
  echo json_encode($answer);
?>
