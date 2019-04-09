<?php 
include 'pdo.php';
//new student
if(isset($_POST['newStudent'])) {
    // echo 'xyu';exit
    $sqlMaxStudentsId = "SELECT id FROM students where id = (SELECT MAX(id) from students)";
    $maxStudentsId = $pdo->query($sqlMaxStudentsId)->fetch();
    $newStudentId[] = $maxStudentsId['id'] + 1;
    $sqlInsertNewStudent = "INSERT INTO students (id) values (" . $newStudentId[0] . ")";
    $stmt = $pdo->prepare($sqlInsertNewStudent);
    $stmt->execute();
    $stmt = null;
    header("Location:student.php?new&id=" . $newStudentId[0] . "");
}
//new teacher
if(isset($_POST['newTeacher'])) {
    $sqlMaxTeachersId = "SELECT id FROM teachers where id = (SELECT MAX(id) from teachers)";
    $maxTeachersId = $pdo->query($sqlMaxTeachersId)->fetch();
    $newTeacherId[] = $maxTeachersId['id'] + 1;
    $sqlInsertNewTeacher = "INSERT INTO teachers (id) values (" . $newTeacherId[0] . ")";
    $stmt = $pdo->prepare($sqlInsertNewTeacher);
    $stmt->execute();
    $stmt = null;
    header("Location:teacher.php?new&id=" . $newTeacherId[0] . "");
}

//new course
if(isset($_POST['newCourse'])) {
    $sqlMaxCoursesId = "SELECT id FROM courses where id = (SELECT MAX(id) from courses)";
    $maxCoursesId = $pdo->query($sqlMaxCoursesId)->fetch();
    $newCourseId[] = $maxCoursesId['id'] + 1;
    $sqlInsertNewCourse = "INSERT INTO courses (id) values (" . $newCourseId[0] . ")";
    $stmt = $pdo->prepare($sqlInsertNewCourse);
    $stmt->execute();
    $stmt = null;
    header("Location:course.php?new&id=" . $newCourseId[0] . "");
}

//new lesson
if(isset($_POST['newLesson'])) {
    $sqlMaxLessonsId = "SELECT id FROM lessons where id = (SELECT MAX(id) from lessons)";
    $maxLessonsId = $pdo->query($sqlMaxLessonsId)->fetch();
    $newLessonId[] = $maxLessonsId['id'] + 1;
    $sqlInsertNewLesson = "INSERT INTO lessons (id) values (" . $newLessonId[0] . ")";
    $stmt = $pdo->prepare($sqlInsertNewLesson);
    $stmt->execute();
    $stmt = null;
    header("Location:lesson.php?new&id=" . $newLessonId[0] . "");
}

//new room
if(isset($_POST['newRoom'])) {
    $sqlMaxRoomsId = "SELECT id FROM rooms where id = (SELECT MAX(id) from rooms)";
    $maxRoomsId = $pdo->query($sqlMaxRoomsId)->fetch();
    $newRoomId[] = $maxRoomsId['id'] + 1;
    $sqlInsertNewRoom = "INSERT INTO rooms (id) values (" . $newRoomId[0] . ")";
    $stmt = $pdo->prepare($sqlInsertNewRoom);
    $stmt->execute();
    $stmt = null;
    header("Location:room.php?new&id=" . $newRoomId[0] . "");
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
            <!-- <form > -->
                <form method="post">
                        <ul class="nav nav-pills nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" style="border-radius: 0px" href="index.php">Домой</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Студенты</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="students.php">Все студенты</a>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item" type="submit" name="newStudent">Новый студент</button>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Преподаватели</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="teachers.php">Все преподаватели</a>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item" type="submit" name="newTeacher">Новый преподаватель</button>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Курсы</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="courses.php">Все курсы</a>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item" type="submit" name="newCourse">Новый курс</button>
                                </div>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Уроки</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="lessons.php">Расписание</a>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item" type="submit" name="newLesson">Новый урок</button>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Комнаты</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="rooms.php">Комнаты</a>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item" type="submit" name="newRoom">Новая комната</button>
                                </div>
                            </li>
                        </ul>
                </form>
                <!-- </form> -->
            </div>
            <hr>
            <h1>A-Level courses management system</h1>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>