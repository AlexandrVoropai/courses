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
        <title>A-Level courses management system. All students. </title>
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
            <h1>Студенты:</h1>
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Фамилия</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Email</th>
                        <th scope="col">Телефон</th>
                    </tr>
                </thead>
                <tbody>
          
                <?php
                $sql = "SELECT S.id, S.last_name, S.first_name, S.birthday, S.email, S.phone
                from students S
                ORDER BY S.id";
                $stmt = $pdo->query($sql);
                while ($row = $stmt->fetch())
                {
                    if ($row['birthday'] != null) {
                    $row['birthday'] = date("Y-m-d", strtotime($row['birthday']));
                    }
                    echo
                    '<tr>' .
                      '<td>' . '<a href="student.php?id='.$row["id"] .'">' . $row["id"] .  '</a>' . '</td>' .
                      '<td>' . $row["last_name"] .  '</td>' .
                      '<td>' . $row["first_name"] .  '</td>' .
                      '<td>' . $row["email"] .  '</td>' .
                      '<td>' . $row["phone"] .  '</td>' .
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