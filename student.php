<?php
include 'pdo.php';

//cancel new student
if (isset($_POST['cancel']) && isset($_GET['new'])) {
    $sqlDeleteNewStudent = "DELETE FROM students WHERE id = " . $_GET['id'] . "";
    $stmt = $pdo->prepare($sqlDeleteNewStudent);
    $stmt->execute();
    $stmt = null;
    header("Location:students.php");
}

//cancel
if (isset($_POST['cancel']) && !isset($_GET['new'])) {
    header("Location:students.php");
}



//get student
$sql = "SELECT S.id, S.first_name, S.last_name, S.birthday, S.email, S.phone FROM students S 
        WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$student) exit('No student');
$stmt = null;
if ($student['birthday'] != null) {
    $student['birthday'] = date("Y-m-d", strtotime($student['birthday']));
}

// get student courses
$sql = "SELECT DISTINCT C.id, C.title, C.description FROM courses C 
        join student_course SC on C.id=SC.course_id
        join students S on SC.student_id=S.id
        WHERE S.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$studentCourses = [];
while ($row = $stmt->fetch()){ 
    $studentCourses[] = $row; 
}

//get all courses
$sql = "SELECT C.id, C.title, C.description FROM courses C";
$stmt = $pdo->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch()){
    $row['studentCourse'] = false;   
    $allCourses[] = $row; 
}

//check student courses from all courses
foreach ($allCourses as $cKey => $course) {
    foreach ($studentCourses as $scKey => $studentCourse) {
        if ($course['title'] == $studentCourse['title']) {
            $allCourses[$cKey]['studentCourse'] = true; 
        }
    }
}

//UPDATE student
if(isset($_POST['save'])){
    if (!$_POST["birthday"]) {
        $_POST["birthday"] = null;
    };
    $row = [
        'id' => $_POST["id"],
        'first_name' => ucfirst($_POST["first_name"]), //ucfirst не работает????????!!!!!!!!?????????????
        'last_name' => ucfirst($_POST["last_name"]),
        'phone' => $_POST["phone"],
        'birthday' => $_POST["birthday"],
        'email' => $_POST["email"]
    ];
    $sql = "UPDATE students SET first_name = :first_name, last_name = :last_name, phone = :phone, birthday = :birthday, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql)->execute($row);
    $stmt = null;

    //check student courses from POST
    foreach ($allCourses as $cKey => $course) {
        $allCourses[$cKey]['studentCourse'] = false; 
        foreach ($_POST as $pKey => $value) {
            if (trim($pKey) == trim($course['title'])) {
                $allCourses[$cKey]['studentCourse'] = true; 
            }
        }
    }

    // UPDATE student_course
    foreach ($allCourses as $cKey => $course) {
        if ($course['studentCourse'] == 1) {
            if (empty($studentCourses)) {
                $sql = "INSERT student_course (student_id, course_id) values (" . $_POST['id'] . ", " . $course['id'] . ")";   
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
            }
            foreach ($studentCourses as $scKey => $studentCourse) {
                if ($studentCourses[$scKey]['id'] != $allCourses[$cKey]['id']) { // не работает???????????!!!!!!!!!!!
                    $sql = "INSERT student_course (student_id, course_id) values (" . $_POST['id'] . ", " . $course['id'] . ")";   
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                }
            }
        }
        else if ($course['studentCourse'] == 0) {
            print_r($course['title'] . ' to delete'. "\n");   
            $sql = "DELETE FROM student_course WHERE student_id = " . $_POST['id'] . " AND  course_id = " . $course['id'] . " ";   
            $stmt = $pdo->prepare($sql);
            $stmt->execute(); 
        }

    }
    header("Location:students.php");
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
            <form method="post">
            <div>
                <ul class="nav nav-pills nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" style="border-radius: 0px" href="index.php">Домой</a>
                    </li>
                </ul>
            </div>
            <hr>
            <h1>Данные студента:</h1>
                <div class="form-row">
                    <div class="col-md-1 mb-13">
                        <label for="id">id</label>
                        <input type="text" class="form-control" id="id" placeholder="id" value="<?php echo $student["id"]?>" name="id" readonly>
                    </div>
                    <div class="col-md-11 mb-3">
                        <label for="last_name">Фамилия</label>
                        <input type="text" class="form-control" id="last_name" placeholder="Last name" value="<?php echo $student["last_name"]?>" name="last_name" >
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="first_name">Имя</label>
                        <input type="text" class="form-control" id="first_name" placeholder="First name" value="<?php echo $student["first_name"]?>" name="first_name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="phone">Телефон</label>
                        <input type="phone" class="form-control" id="phone" placeholder="Phone" value="<?php echo $student["phone"]?>" name="phone">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="birthday">Дата рождения</label>
                        <input type="date" class="form-control" id="birthday" placeholder="Birthday" value="<?php echo $student["birthday"]?>" min="<?php echo (date("Y-m-d", strtotime("-70 year")));?>" max="<?php echo (date("Y-m-d", strtotime("-5 year")));?>" name="birthday" >
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $student["email"]?>" name="email">
                    </div>
                </div>
                <div>
                    <label>Курсы студента</label>
                </div>


        <?php 
        foreach ($allCourses as $course) {
            $checked = '';
            if ($course['studentCourse']) {
                $checked = 'checked';
            }
            echo "
                <div class='col-md-12'>
                <div class='custom-control custom-switch'>
                    <input class='custom-control-input' type='checkbox' id='" . $course['title'] . "' value='checked'"  . $checked. " name='" . $course['title'] . "'>
                    <label class='custom-control-label' for='" . $course['title'] ."'>" . $course['title'] . "</label>
                </div>
                </div>
                ";  
        }
        ?>
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
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>





