<?php
include 'pdo.php';
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>A-Level courses management system. All courses. </title>
    </head>
    <body>
        <div class="container">
            <hr>
            <div>
                <ul class="nav nav-pills nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" style="border-radius: 0px" href="index.php">Домой</a>
                    </li>
                </ul>
            </div>
            <hr>
            <h1>Курсы:</h1>
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Направление</th>
                        <th scope="col">Название</th>
                        <!-- <th scope="col">Дата рождения</th> -->
                        <th scope="col">Описание</th>
                        <th scope="col">Начало</th>
                        <th scope="col">Окончание</th>
                        <th scope="col">Цена</th>
                        <!-- <th scope="col">Курс</th> -->
                    </tr>
                </thead>
                <tbody>
          
            <?php
            $sql = "SELECT C.id, C.title, C.description, C.date_start, C.date_finish, C.price, C.direction
            from courses C
            ORDER BY C.id";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch())
            {
                if ($row['date_start'] != null) {
                    $row['date_start'] = date("Y-m-d", strtotime($row['date_start']));
                }
                if ($row['date_finish'] != null) {
                    $row['date_finish'] = date("Y-m-d", strtotime($row['date_finish']));
                }
                echo
                    '<tr>' .
                      '<td>' . '<a href="course.php?id='.$row["id"] .'">' . $row["id"] .  '</a>' . '</td>' .
                      '<td>' . $row["direction"] .  '</td>' .
                      '<td>' . $row["title"] .  '</td>' .
                      '<td>' . $row["description"] .  '</td>' .
                      '<td>' . $row["date_start"] .  '</td>' .
                      '<td>' . $row["date_finish"] .  '</td>' .
                      '<td>' . $row["price"] .  '</td>' .
                    '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>