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
        <title>A-Level courses management system. All lessons. </title>
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
            <h1>Уроки:</h1>
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Курс</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Начало</th>
                        <th scope="col">Продолжительность</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT L.id, L.start, L.duration, C.title
                        from lessons L
                        JOIN courses C on L.course_id = C.id
                        ORDER BY L.id";
                $stmt = $pdo->query($sql);
                while ($row = $stmt->fetch()) {
                    if ($row['start'] != null) {
                        $row['dateStart'] = date("Y-m-d", strtotime($row['start']));
                        $row['timeStart'] = date("H:i:s", strtotime($row['start']));
                    }
                    else if ($row['start'] == null) {
                        $row['dateStart'] = null;
                        $row['timeStart'] = null;
                    }
                    
                    echo
                        '<tr>' .
                          '<td>' . '<a href="lesson.php?id='.$row["id"] .'">' . $row["id"] .  '</a>' . '</td>' .
                          '<td>' . $row["title"] .  '</td>' .
                          '<td>' . $row["dateStart"] .  '</td>' .
                          '<td>' . $row["timeStart"] .  '</td>' .
                          '<td>' . $row["duration"] .  '</td>' .
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