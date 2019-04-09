<?php
include 'pdo.php';

//cancel new lesson
if (isset($_POST['cancel']) && isset($_GET['new'])) {
    $sqlDeleteNewRoom = "DELETE FROM rooms WHERE id = " . $_GET['id'] . "";
    $stmt = $pdo->prepare($sqlDeleteNewRoom);
    $stmt->execute();
    $stmt = null;
    header("Location:rooms.php");
}

//cancel
if (isset($_POST['cancel']) && !isset($_GET['new'])) {
    header("Location:rooms.php");
}

//get room
$sql = "SELECT R.id, R.name FROM rooms R 
        WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$room) exit('No room');
$stmt = null;


 $stmt = null;

//UPDATE lesson
if(isset($_POST['save'])){
    $row = [
                'id' => $_POST["id"],
                'name' => $_POST["name"]
            ];
        $sql = "UPDATE rooms SET name = :name WHERE id = :id";
        $stmt = $pdo->prepare($sql)->execute($row);
        $stmt = null;
    header("Location:rooms.php");
}
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>A-Level courses management system</title>
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
            <h1>Комната</h1>
            <form method="post">
                <div class="col-md-12 mb-3">
                    <label for="id">id</label>
                    <input type="text" class="form-control" id="id" placeholder="id" value="<?php echo $room["id"]?>" name="id" readonly>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="name">Название комнаты</label>
                    <input type="text" class="form-control" id="name" placeholder="name" value="<?php echo $room["name"]?>" name="name">
                </div>
                
                <div class="row col-md-12 mb-3">
                    <div class="col-md-2 mb-3">
                        <button class="btn btn-danger" type="submit" name="cancel" formnovalidate>Отменить</button>
                    </div>
                    <div class="col-md-3" nowrap>
                        <button class="btn btn-primary" type="submit" name="save" nowrap>Сохранить данные</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>





