<?php
    include_once 'connect.php';
    include_once 'check_result.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    function getDetails($username){
        $connection = connectDatabase();
        
        if ($_SESSION['title'] == 'teacher'){
            $sql = "SELECT teacher_id, fname, lname FROM teachers WHERE username='$username';";
        }
        else if ($_SESSION['title'] == 'student'){
            $sql = "SELECT student_id, fname, lname, batch_year, semester_number FROM students INNER JOIN batch USING (batch_year) WHERE username='$username';";
        }

        $result = mysqli_query($connection,$sql);
        
        if (checkResult($result,$connection) !== true){
            exit();
        }
        $userDetails=[];
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($userDetails, $row);
       }
       //print_r($userDetails);
       return $userDetails;

    }

    function getCourse($value){
        $connection = connectDatabase();

        if ($_SESSION['title'] == 'teacher'){
            $sql = "SELECT course_code, course_title,semester_number FROM courses INNER JOIN teacher_courses USING (course_code) WHERE teacher_id=$value AND active_status=1;";
        }
        else if ($_SESSION['title'] == 'student'){
            $sql = "SELECT course_code, course_title FROM courses INNER JOIN batch USING (semester_number) WHERE semester_number='$value';";
        }

        $result = mysqli_query($connection,$sql);

        if (checkResult($result,$connection) !== true){
            exit();
        }

        $courseNames = [];
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($courseNames, $row);
       }
       return $courseNames;
    }

    //for showing name of teacher in student dashboard
    function getSubjectTeacher($course_code){
        $connection = connectDatabase();
        $sql = "SELECT fname, lname from teachers INNER JOIN teacher_courses USING (teacher_id) WHERE course_code='$course_code' AND teacher_courses.active_status=1";
        $result = mysqli_query($connection,$sql);
        if (checkResult($result,$connection) !== true){
            return false;
        }
        $teacherName = [];
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($teacherName, $row);
        }
        foreach ($teacherName as $name){
            $fullName = $name['fname'].' '.$name['lname'];
        }
        return $fullName;
    }
?>