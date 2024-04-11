<?php
    error_reporting();
    session_start();
    include_once '../database/value_pull.php';
    include_once '../database/value_push.php';
    include_once 'popup_modal.php';
    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        // Redirect the user to the login page if not logged in
        header("Location: login.php");
        exit(); // Stop executing the script
    }

    // Retrieve the name and title from the session variable
    $loggedInUsername = $_SESSION['username'];
    $title = $_SESSION['title'];

    //get the course code of whichever course is clicked
    if(isset($_GET['course_code'])) {
        $courseCode = $_GET['course_code'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Assignments</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include_once 'login_navbar.php'; ?>
    <div class="heading">
        <h1><a href="dashboard.php">My Courses</a>>My Assignments</h1>
    </div>
    <div class="assignment-container">
        <div class="left">
            <div class="left-titles">
                <?php
                    if ($title == 'teacher'){
                        $categoryNames = getCategory($_SESSION['teacher_id'],$courseCode);
                    } elseif ($title == 'student') {
                        $teacherId = getSubjectTeacher($courseCode);
                        foreach ($teacherId as $teacherId) {
                            $teacherId = $teacherId['teacher_id'];
                        }
                        $categoryNames = getCategory($teacherId,$courseCode);
                    }
                    if ($categoryNames == false){
                        echo 'No category created.';
                    }else {
                        foreach ($categoryNames as $name){
                ?>
                <div class="category-name" onclick="loadQuestion(<?php echo $name['assignment_category_id']; ?>)">
                    <span><?php echo $name['category_name']; ?></span>
                </div>
                <?php
                        }
                    }
                ?>
            </div>
            <?php
                if ($title == 'teacher'){
            ?>
            <div class="buttons">
                <a href="#create-category" rel="modal:open"><button>Create Category</button></a>
            </div>
            <?php
                }
            ?>
        </div>
        <div class="right">
            <!-- everything here comes from fetch_questions.php through loadQuestion(): ajax -->
        </div>
    </div>

    <script type="text/javascript" src="../js/script.js"></script>   

</body>
</html>