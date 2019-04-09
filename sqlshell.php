<?php
print_r($_GET);
print_r($_POST);

$host = '127.0.0.1';
$db   = 'cources';
$user = 'admin';
$pass = 'rhjirf';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,

    PDO::MYSQL_ATTR_FOUND_ROWS => true
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$sql = $_POST['sql'];

$stmt = $pdo->query($sql);
// $stmt->execute($sql);


?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>mysql shell</title>
  </head>
  <body>
    <form method="post">
    <div class="form-row">
      <div class="col-md-4 mb-3">
        <textarea name="sql" rows=10 style="width: 90%"></textarea></br>
      </div>
      <div class="col-md-2">
        <button class="btn btn-primary" type="submit" name="Run">Сохранить данные</button>
      </div>
    </form>
    <table class="table table-hover table-dark">
        <thead>
      <!--     <tr>
            <th scope="col">id</th>
            <th scope="col">Фамилия</th>
            <th scope="col">Имя</th>
            <th scope="col">Дата рождения</th>
            <th scope="col">Email</th>
            <th scope="col">Телефон</th>
          </tr> -->
        </thead>
        <tbody>
        <?php 


        while ($row = $stmt->fetch())
        {
      // print_r($row);
              echo '<tr>';
        foreach ($row as $key => $value) {
              // echo($key);
             echo '<td>' . $value . '<td>' ; 
            }
        echo '<tr>';
        
        }
        ?>


  </body>
</html>
