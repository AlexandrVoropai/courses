<?php
include 'pdo.php';
//cancel new course
if (isset($_POST['cancel']) && isset($_GET['new'])) {
    print_r($newCourseId[0]);
    $sqlDeleteNewCourse = "DELETE FROM courses WHERE id = " . $_GET['id'] . "";
    $stmt = $pdo->prepare($sqlDeleteNewCourse);
    $stmt->execute();
    $stmt = null;
    header("Location:courses.php");
}
//cancel
if (isset($_POST['cancel']) && !isset($_GET['new'])) {
    header("Location:courses.php");
}
//get course
$sql = "SELECT C.id, C.title, C.description, C.date_start, C.date_finish, C.price, C.direction FROM courses C
WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$course) exit('No course');
$stmt = null;
if ($course['date_start'] != null) {
    $course['date_start'] = date("Y-m-d", strtotime($course['date_start']));
}
if ($course['date_finish'] != null) {
    $course['date_finish'] = date("Y-m-d", strtotime($course['date_finish']));
}
// get course student
$sql = "SELECT DISTINCT S.id, S.first_name, S.last_name FROM students S
join student_course SC on S.id=SC.student_id
join courses C on SC.course_id=C.id
WHERE C.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$courseStudents = [];
while ($row = $stmt->fetch()){
    $courseStudents[] = $row;
}
$stmt = null;
// get course teachers
$sql = "SELECT DISTINCT T.id, T.first_name, T.last_name FROM teachers T
join teacher_course TC on T.id=TC.teacher_id
join courses C on TC.course_id=C.id
WHERE C.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$courseTeachers = [];
while ($row = $stmt->fetch()){
    $courseTeachers[] = $row;
}
$stmt = null;
//get all students
$sql = "SELECT S.id, S.first_name, S.last_name FROM students S";
$stmt = $pdo->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch()){
    $row['courseStudent'] = false;
    $allStudents[] = $row;
}
$stmt = null;
//get all teachers
$sql = "SELECT T.id, T.first_name, T.last_name FROM teachers T";
$stmt = $pdo->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch()){
    $row['courseTeacher'] = false;
    $allTeachers[] = $row;
}
$stmt = null;
//check course students from all students
foreach ($allStudents as $sKey => $student) {
    foreach ($courseStudents as $csKey => $courseStudent) {
        if ($student['id'] == $courseStudent['id']) {
            $allStudents[$sKey]['courseStudent'] = true;
        }
    }
}
//check course teachers from all teachers
foreach ($allTeachers as $tKey => $teacher) {
    foreach ($courseTeachers as $ctKey => $courseTeacher) {
        if ($teacher['id'] == $courseTeacher['id']) {
            $allTeachers[$tKey]['courseTeacher'] = true;
        }
    }
}
//get all rooms
$sql = "SELECT * FROM rooms";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$allRooms = [];
while ($row = $stmt->fetch()){
    $allRooms[] = $row;
}
//get course room(s)
$sql = "SELECT R.id, R.name FROM rooms R
JOIN course_room CR on CR.room_id = R.id WHERE CR.course_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$courseRooms = [];
while ($row = $stmt->fetch()){
    $courseRooms[] = $row;
}
//check course room(s) from all rooms
foreach ($allRooms as $rKey => $room) {
    foreach ($courseRooms as $crKey => $courseRoom) {
        if ($room['id'] == $courseRoom['id']) { 
            $allRooms[$rKey]['courseRoom'] = true;
        }
    }
}

//UPDATE course
if(isset($_POST['save'])){
    //update rooms
    if (isset($_POST['roomId']) && isset($courseRooms[0])) {
        if ($_POST['roomId'] != $courseRooms[0]['id']) {
            $row = [
                'course_id' => $_GET["id"],
                'room_id' => $_POST["roomId"]
            ];
            $sql = "UPDATE course_room SET room_id = :room_id WHERE course_id = :course_id";
            $stmt = $pdo->prepare($sql)->execute($row);
            $stmt = null;
        }
    }
    if (isset($_POST['roomId']) && !isset($courseRooms[0])) {
        // if ($_POST['roomId'] != $courseRooms[0]['id']) {
            $row = [
                'course_id' => $_GET["id"],
                'room_id' => $_POST["roomId"]
            ];
            $sql = "INSERT INTO course_room (course_id, room_id) VALUES (:course_id, :room_id)";
            $stmt = $pdo->prepare($sql)->execute($row);
            $stmt = null;
        // }
    }


 
    //UPDATE course
    if (!$_POST["date_start"]) {
        $_POST["date_start"] = null;
    }
    if (!$_POST["date_finish"]) {
        $_POST["date_finish"] = null;
    }
    $row = [
            'id' => $_POST["id"],
            'title' => ucfirst($_POST["title"]), //ucfirst не работает????????!!!!!!!!?????????????
            'description' => ucfirst($_POST["description"]),
            'date_start' => $_POST["date_start"],
            'date_finish' => $_POST["date_finish"],
            'price' => intval($_POST["price"]),
            'direction' => $_POST["direction"]
        ];
    $sql = "UPDATE courses SET title = :title, description = :description, date_start = :date_start, date_finish = :date_finish, price = :price, direction=:direction WHERE id = :id";
    $stmt = $pdo->prepare($sql)->execute($row);
    $stmt = null;

    //check course students from POST
    foreach ($allStudents as $sKey => $student) {
        $allStudents[$sKey]['courseStudent'] = false;
        foreach ($_POST as $pKey => $value) {
            if (stristr($pKey, 'student')) {
                if (explode("student", $pKey)[1] == $student['id']) {
                    $allStudents[$sKey]['courseStudent'] = true;
                }
            }
        }
    }

    //check course teachers from POST
    foreach ($allTeachers as $tKey => $teacher) {
        $allTeachers[$tKey]['courseTeacher'] = false;
        foreach ($_POST as $pKey => $value) {
            if (stristr($pKey, 'teacher')) {
                if (explode("teacher", $pKey)[1] == $teacher['id']) {
                    $allTeachers[$tKey]['courseTeacher'] = true;
                }
            }
        }
    }

    // UPDATE student_course
    foreach ($allStudents as $sKey => $student) {
        if ($student['courseStudent'] == 1) {
            if (empty($courseStudents)) {
                print_r($course['title'] . ' to add with empty SC'. "\n");
                $sql = "INSERT student_course (course_id, student_id) values (" . $_POST['id'] . ", " . $student['id'] . ")";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
            }
            foreach ($courseStudents as $csKey => $courseStudent) {
                if ($courseStudents[$csKey]['id'] != $allStudents[$sKey]['id']) { // не работает???????????!!!!!!!!!!!
                    print_r($course['title'] . ' to add'. "\n");
                    $sql = "INSERT student_course (course_id, student_id) values (" . $_POST['id'] . ", " . $student['id'] . ")";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                }
            }
        }
        else if ($student['courseStudent'] == 0) {
            print_r($student['last_name'] . ' to delete'. "\n");
            $sql = "DELETE FROM student_course WHERE course_id = " . $_POST['id'] . " AND  student_id = " . $student['id'] . " ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }
    }
    // UPDATE teacher_course
    foreach ($allTeachers as $tKey => $teacher) {
        if ($teacher['courseTeacher'] == 1) {
            if (empty($courseTeachers)) {
                print_r($teacher['id']);
                print_r($course['title'] . ' to add with empty TC'. "\n");
                $sql = "INSERT teacher_course (course_id, teacher_id) values (" . $_POST['id'] . ", " . $teacher['id'] . ")";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
            }
            foreach ($courseTeachers as $ctKey => $courseTeacher) {
                if ($courseTeachers[$ctKey]['id'] != $allTeachers[$tKey]['id']) { // не работает???????????!!!!!!!!!!!
                    print_r($course['title'] . ' to add'. "\n");
                    $sql = "INSERT teacher_course (course_id, teacher_id) values (" . $_POST['id'] . ", " . $teacher['id'] . ")";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                }
            }
        }
        else if ($teacher['courseTeacher'] == 0) {
            print_r($teacher['last_name'] . ' to delete'. "\n");
            $sql = "DELETE FROM teacher_course WHERE course_id = " . $_POST['id'] . " AND  teacher_id = " . $teacher['id'] . " ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }
    }
    

    // exit;
    header("Location:courses.php");
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
            <h1>Данные курса:</h1>
            <form method="post">
                <div class="form-row">
                    <div class="col-md-1 mb-13">
                        <label for="id">id</label>
                        <input type="text" class="form-control" id="id" placeholder="id" value="<?php echo $course["id"]?>" name="id" readonly>
                    </div>
                    <div class="col-md-11 mb-3">
                        <label for="title">Название</label>
                        <input type="text" class="form-control" id="title" placeholder="Title" value="<?php echo $course["title"]?>" name="title" >
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="direction">Направление</label>
                        <input type="text" class="form-control" id="direction" placeholder="Direction" value="<?php echo $course["direction"]?>" name="direction" >
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description">Описание</label>
                        <input type="text" class="form-control" id="description" placeholder="Description" value="<?php echo $course["description"]?>" name="description" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="date_start">Дата начала</label>
                        <input type="date" class="form-control" id="date_start" placeholder="Date start" value="<?php echo $course["date_start"]?>" min="<?php echo (date("Y-m-d", strtotime("-1 year")));?>" max="<?php echo (date("Y-m-d", strtotime("+5 year")));?>" name="date_start" >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="date_finish">Дата окончания</label>
                        <input type="date" class="form-control" id="date_finish" placeholder="Date finish" value="<?php echo $course["date_finish"]?>" min="<?php echo (date("Y-m-d", strtotime("-1 year")));?>" max="<?php echo (date("Y-m-d", strtotime("+5 year")));?>" name="date_finish" >
                    </div>
                    <!-- <div class="col-md-12 mb-3">
                        <label for="date_finish">Дата окончания</label>
                        <input type="date" class="form-control" id="date_finish" placeholder="Date finish" value="<?php echo $course["date_finish"]?>" min="<?php echo (date("Y-m-d", strtotime("-1 year")));?>" max="<?php echo (date("Y-m-d", strtotime("+5 year")));?>" name="date_finish" >
                    </div> -->
                    <div class="col-md-12 mb-3">
                        <label for="price">Цена</label>
                        <input type="price" class="form-control" id="price" placeholder="Price" value="<?php echo $course["price"]?>" name="price">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label>Комната курса</label>
                        <?php
                            foreach ($allRooms as $rKey => $room) {
                                $checked = '';
                                if (isset($room['courseRoom'])) {
                                    $checked = 'checked';
                                }
                        echo "
                        <div class='col-md-12'>
                            <div class='custom-control custom-radio'>
                                <input type='radio' id='". $room['name'] . "' name='roomId' value='" . $room['id'] .  "' class='custom-control-input' " . $checked . ">
                                <label class='custom-control-label' for='" . $room['name'] . "'>" . $room['name'] . "</label>
                            </div>
                        </div>
                        ";
                        }
                        
                        ?>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label>Преподаватели курса</label>
                        <?php
                        foreach ($allTeachers as $teacher) {
                            $checkedTeacher = '';
                            if ($teacher['courseTeacher']) {
                                $checkedTeacher = 'checked';
                            }
                        echo "
                        <div class='col-md-12'>
                            <div class='custom-control custom-switch'>
                                <input class='custom-control-input' type='checkbox' id='teacher" . $teacher['id'] . "' value='checkedTeacher'"  . $checkedTeacher. " name='teacher" . $teacher['id'] . "'>
                                <label class='custom-control-label' for='teacher" . $teacher['id'] ."'>" . $teacher['last_name'] . ' ' . $teacher['first_name'] . "</label>
                            </div>
                        </div>
                        ";
                        }
                        ?>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label>Студенты курса</label>
                        <?php
                        foreach ($allStudents as $student) {
                        $checkedStudent = '';
                        if ($student['courseStudent']) {
                        $checkedStudent = 'checked';
                        }
                        echo "
                        <div class='col-md-12'>
                            <div class='custom-control custom-switch'>
                                <input class='custom-control-input' type='checkbox' id='student" . $student['id'] . "' value='checkedStudent'"  . $checkedStudent. " name='student" . $student['id'] . "'>
                                <label class='custom-control-label' for='student" . $student['id'] ."'>" . $student['last_name'] . ' ' . $student['first_name'] . "</label>
                            </div>
                        </div>
                        ";
                        }
                        ?>
                    </div>
                </div>
                <br>
                
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <button class="btn btn-danger" type="submit" name="cancel" formnovalidate>Отменить</button>
                    </div>
                    <div class="col-md-3 mb-3" nowrap>
                        <button class="btn btn-primary" type="submit" name="save" nowrap>Сохранить данные</button>
                    </div>
                </div>
            </form>
            <br>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>