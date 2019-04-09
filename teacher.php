<?php
include 'pdo.php';

//cancel new teacher
if (isset($_POST['cancel']) && isset($_GET['new'])) {
    $sqlDeleteNewTeacher = "DELETE FROM teachers WHERE id = " . $_GET['id'] . "";
    $stmt = $pdo->prepare($sqlDeleteNewTeacher);
    $stmt->execute();
    $stmt = null;
    header("Location:teachers.php");
}

//cancel
if (isset($_POST['cancel']) && !isset($_GET['new'])) {
    header("Location:teachers.php");
}

//get user
$sql = "SELECT S.id, S.first_name, S.last_name, S.birthday, S.email, S.phone FROM teachers S 
        WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$teacher = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$teacher) exit('No teacher');
$stmt = null;
if ($teacher['birthday'] != null) {
    $teacher['birthday'] = date("Y-m-d", strtotime($teacher['birthday']));
}

// get teacher courses
$sql = "SELECT DISTINCT C.id, C.title, C.description FROM courses C 
        join teacher_course SC on C.id=SC.course_id
        join teachers S on SC.teacher_id=S.id
        WHERE S.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
$teacherCourses = [];
while ($row = $stmt->fetch()){ 
    $teacherCourses[] = $row; 
}

//get all courses
$sql = "SELECT C.id, C.title, C.description FROM courses C";
$stmt = $pdo->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch()){
    $row['teacherCourse'] = false;   
    $allCourses[] = $row; 
}

//check teacher courses from all courses
foreach ($allCourses as $cKey => $course) {
    foreach ($teacherCourses as $scKey => $teacherCourse) {
        if ($course['title'] == $teacherCourse['title']) {
            $allCourses[$cKey]['teacherCourse'] = true; 
        }
    }
}

//UPDATE teacher
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
    $sql = "UPDATE teachers SET first_name = :first_name, last_name = :last_name, phone = :phone, birthday = :birthday, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql)->execute($row);
    $stmt = null;

    //check teacher courses from POST
    foreach ($allCourses as $cKey => $course) {
        $allCourses[$cKey]['teacherCourse'] = false; 
        foreach ($_POST as $pKey => $value) {
            if (trim($pKey) == trim($course['title'])) {
                $allCourses[$cKey]['teacherCourse'] = true; 
            }
        }
    }

    // UPDATE teacher_course
    print_r($_POST);
    print_r($allCourses);
    print_r($teacherCourses);
    foreach ($allCourses as $cKey => $course) {
        if ($course['teacherCourse'] == 1) {
            if (empty($teacherCourses)) {
                print_r($course['title'] . ' to add with empty SC'. "\n"); 
                $sql = "INSERT teacher_course (teacher_id, course_id) values (" . $_POST['id'] . ", " . $course['id'] . ")";   
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
            }
            foreach ($teacherCourses as $scKey => $teacherCourse) {
                if ($teacherCourses[$scKey]['id'] != $allCourses[$cKey]['id']) { // не работает???????????!!!!!!!!!!!
                    print_r($course['title'] . ' to add'. "\n"); 
                    $sql = "INSERT teacher_course (teacher_id, course_id) values (" . $_POST['id'] . ", " . $course['id'] . ")";   
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                }
            }
        }
        else if ($course['teacherCourse'] == 0) {
            print_r($course['title'] . ' to delete'. "\n");   
            $sql = "DELETE FROM teacher_course WHERE teacher_id = " . $_POST['id'] . " AND  course_id = " . $course['id'] . " ";   
            $stmt = $pdo->prepare($sql);
            $stmt->execute(); 
        }

    }
    header("Location:teachers.php");
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
            <h1>Данные преподавателя:</h1>
            <form method="post">
                <div class="form-row">
                    <div class="col-md-1 mb-13">
                        <label for="id">id</label>
                        <input type="text" class="form-control" id="id" placeholder="id" value="<?php echo $teacher["id"]?>" name="id" readonly>
                    </div>
                    <div class="col-md-11 mb-3">
                        <label for="last_name">Фамилия</label>
                        <input type="text" class="form-control" id="last_name" placeholder="Last name" value="<?php echo $teacher["last_name"]?>" name="last_name" >
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="first_name">Имя</label>
                        <input type="text" class="form-control" id="first_name" placeholder="First name" value="<?php echo $teacher["first_name"]?>" name="first_name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="phone">Телефон</label>
                        <input type="phone" class="form-control" id="phone" placeholder="Phone" value="<?php echo $teacher["phone"]?>" name="phone">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="birthday">Дата рождения</label>
                        <input type="date" class="form-control" id="birthday" placeholder="Birthday" value="<?php echo $teacher["birthday"]?>" min="<?php echo (date("Y-m-d", strtotime("-70 year")));?>" max="<?php echo (date("Y-m-d", strtotime("-5 year")));?>" name="birthday" >
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $teacher["email"]?>" name="email">
                    </div>
                </div>
                <div>
                    <label>Курсы студента</label>
                </div>


        <?php 
        foreach ($allCourses as $course) {
            $checked = '';
            if ($course['teacherCourse']) {
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





