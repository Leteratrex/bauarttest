<?php
  //Подключение к базе данных
  $user = 'root';
  $password = '';
  $db = 'bauart_test';
  $host = 'localhost';

  $dsn = 'mysql:host='.$host.';dbname='.$db;
  $pdo = new PDO($dsn, $user, $password);
?>
