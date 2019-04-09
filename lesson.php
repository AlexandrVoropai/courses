<?php
include 'pdo.php';

//cancel new lesson
if (isset($_POST['cancel']) && isset($_GET['new'])) {
    $sqlDeleteNewLesson = "DELETE FROM lessons WHERE id = " . $_GET['id'] . "";
    $stmt = $pdo->prepare($sqlDeleteNewLesson);
    $stmt->execute();
    $stmt = null;
    header("Location:lessons.php");
}

//cancel
if (isset($_POST['cancel']) && !isset($_GET['new'])) {
    header("Location:lessons.php");
}

//get lesson
$sql = "SELECT L.id, L.course_id, L.start, L.duration FROM lessons L 
        WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$lesson = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$lesson) exit('No lesson');
$stmt = null;
if ($lesson['start'] != null) {
    $lesson['dateStart'] = date("Y-m-d", strtotime($lesson['start']));
    $lesson['timeStart'] = date("H:i:s", strtotime($lesson['start']));
}

//get all rooms
$sql = "SELECT R.id, R.name FROM rooms R";
$stmt = $pdo->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch()){
    $allRooms[] = $row; 
}
$stmt = null;

// get lesson room(s)
$sql = "SELECT R.id, R.name FROM rooms R
        JOIN course_room CR on R.id = CR.room_id
        JOIN lessons L on CR.course_id = L.course_id
        WHERE L.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$lessonRooms = [];
while ($row = $stmt->fetch()){ 
    $lessonRooms[] = $row; 
}
$stmt = null;

//get all courses
$sql = "SELECT C.id, C.title, C.description FROM courses C";
$stmt = $pdo->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch()){
    $row['lessonCourse'] = false;   
    $allCourses[] = $row; 
}
$stmt = null;

// get lesson students
$sql = "SELECT DISTINCT S.id, S.first_name, S.last_name, S.email, S.phone FROM students S
        JOIN student_course SC on SC.student_id = S.id
        JOIN lessons L on SC.course_id = L.course_id 
        WHERE L.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$lessonStudents = [];
while ($row = $stmt->fetch()){ 
    $lessonStudents[] = $row; 
}
$stmt = null;

// get lesson teachers
$sql = "SELECT DISTINCT T.id, T.first_name, T.last_name, T.email, T.phone FROM teachers T
        JOIN teacher_course TC on TC.teacher_id = T.id
        JOIN lessons L on TC.course_id = L.course_id 
        WHERE L.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$lessonTeachers = [];
while ($row = $stmt->fetch()){ 
    $lessonTeachers[] = $row; 
}
$stmt = null;

//UPDATE lesson
if(isset($_POST['save'])){
    if ($_POST["dateStart"] || $_POST["timeStart"]) {
        $_POST["start"] = date("Y-m-d H:i:s",strtotime($_POST['dateStart'] . $_POST['timeStart']));
    }
    if (!$_POST["dateStart"] && !$_POST["timeStart"]) {
        $_POST["start"] = null;
    };
    if (!$_POST["duration"]) {
        $_POST["duration"] = null;
    };
    foreach ($allCourses as $cKey => $course) {
        foreach ($_POST as $pKey => $pValue) {
            if ($course['title'] == $pKey) {
                $_POST['courseId'] = $course['id'];
            }
        }
    }
    $row = [
        'id' => $_POST["id"],
        'start' => $_POST["start"], 
        'duration' => $_POST["duration"],
        'courseId' => $_POST["courseId"],
    ];
    $sql = "UPDATE lessons SET start = :start, duration = :duration, course_id = :courseId WHERE id = :id";
    $stmt = $pdo->prepare($sql)->execute($row);
    $stmt = null;

    header("Location:lessons.php");
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
            <h1>Уроки</h1>
            <form method="post">
                <div class="col-md-12 mb-3">
                    <label for="id">id</label>
                    <input type="text" class="form-control" id="id" placeholder="id" value="<?php echo $lesson["id"]?>" name="id" readonly>
                </div>

                <div class="col-md-12 mb-3">
                <label>Курсы</label>
                <?php 
                foreach ($allCourses as $course) {
                    $checked = '';
                    if ($course['id'] == $lesson['course_id']) {
                        $checked = 'checked';
                    }
                    echo "
                        <div class='col-md-12'>
                        <div class='custom-control custom-radio'>
                          <input type='radio' id='". $course['title'] . "' name='courseId' value='" . $course['id'] .  "' class='custom-control-input' " . $checked . ">
                          <label class='custom-control-label' for='" . $course['title'] . "'>" . $course['title'] . "</label>
                        </div>
                        </div>
                        ";  
                }
                ?>


                </div>
                <div class="col-md-12 mb-3">
                    <label for="start">Дата начала</label>
                    <input type="date" class="form-control" id="dateStart" placeholder="Start" value="<?php echo $lesson["dateStart"]?>" name="dateStart" >
                </div>

                <div class="col-md-12 mb-3">
                    <label for="duration">Время начала</label>
                    <input type="time" class="form-control" id="timeStart" placeholder="Time Start" value="<?php echo $lesson["timeStart"]?>" name="timeStart" >
                </div>

                <div class="col-md-12 mb-3">
                    <label for="duration">Продолжительность</label>
                    <input type="time" class="form-control" id="duration" placeholder="Duration" value="<?php echo $lesson["duration"]?>" name="duration" >
                </div>

                <?php 
                if (!isset($_GET['new']) && isset($lessonRooms[0])) {
                    echo "
                        <div class='col-md-12 mb-3'>
                            <label>Комната</label>
                            <input type='text' class='form-control' value='".$lessonRooms[0]['name']."' readonly>
                        </div>
                    ";
                }
              
                if (!isset($_GET['new'])) {
                    echo "
                    <div class='col-md-10 mb-3'>
                        <label>Студенты:</label>
                        <table class='table table-hover table-dark'>
                            <thead>
                                <tr>
                                    <th scope='col'>id</th>
                                    <th scope='col'>Фамилия</th>
                                    <th scope='col'>Имя</th>
                                    <th scope='col'>Email</th>
                                    <th scope='col'>Телефон</th>
                                </tr>
                            </thead>
                            <tbody>
                            ";
                            
                        foreach ($lessonStudents as $student) {
                            echo
                            '<tr>' .
                              '<td>' . '<a href="student.php?id='.$student["id"] .'">' . $student["id"] .  '</a>' . '</td>' .
                              '<td>' . $student["last_name"] .  '</td>' .
                              '<td>' . $student["first_name"] .  '</td>' .
                              '<td>' . $student["email"] .  '</td>' .
                              '<td>' . $student["phone"] .  '</td>' .
                            '</tr>';
                        }
                    echo "
                            </tbody>
                        </table>
                    </div>";

                    echo "
                    <div class='col-md-10 mb-3'>
                        <label>Преподаватели:</label>
                        <table class='table table-hover table-dark'>
                            <thead>
                                <tr>
                                    <th scope='col'>id</th>
                                    <th scope='col'>Фамилия</th>
                                    <th scope='col'>Имя</th>
                                    <th scope='col'>Email</th>
                                    <th scope='col'>Телефон</th>
                                </tr>
                            </thead>
                            <tbody>
                            ";
                            
                        foreach ($lessonTeachers as $teacher) {
                            echo
                            '<tr>' .
                              '<td>' . '<a href="teacher.php?id='.$teacher["id"] .'">' . $teacher["id"] .  '</a>' . '</td>' .
                              '<td>' . $teacher["last_name"] .  '</td>' .
                              '<td>' . $teacher["first_name"] .  '</td>' .
                              '<td>' . $teacher["email"] .  '</td>' .
                              '<td>' . $teacher["phone"] .  '</td>' .
                            '</tr>';
                        }
                    echo "
                            </tbody>
                        </table>
                    </div>";
                }
                ?>
                
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





