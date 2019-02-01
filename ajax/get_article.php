<?php
  $id = $_POST['id'];

  require_once '../mysql_connect.php';

  $sql = 'SELECT * FROM `articles` WHERE `id` = :id';
  $query = $pdo->prepare($sql);
  $query->execute(['id' => $id]);

  $article = $query->fetch(PDO::FETCH_OBJ);

  echo "
  <h3>$article->title</h3>
  <p>$article->text</p>
  ";

?>
