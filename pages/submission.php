<?php

error_reporting(0);
include_once '../database/value_pull.php';
include_once '../database/value_modify.php';

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['title'] == 'student') {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit(); // Stop executing the script
}
if (isset($_POST['assignmentId']) && $_POST['teacherCoursesId']){
    $assignmentId=$_POST['assignmentId'];
    $teacherCoursesId=$_POST['teacherCoursesId'];
} else {
    echo "Either assignmentId or teacherCoursesId not provided";
    exit();
}
$submissionResult = getSubmission($assignmentId,$teacherCoursesId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Submissions</title>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
    <?php include_once 'login_navbar.php'; ?>
    <div class="heading">
        <h1><a href="dashboard.php">My Courses</a>><a href="javascript:history.back()">My Assignments</a>>View Submissions</h1>
    </div> 
    <?php
        if ($submissionResult == false){
            echo "No submissions are provided for this question.";
            exit();
        } else {
    ?>
    <table class="submission-table" border="1">
        <tr>
            <th>S.N.</th>
            <th>Student's Name</th>
            <th>Action</th>
        </tr>
        <?php foreach ($submissionResult as $key => $submissionResult){ ?>
            <tr>
                <td><?php echo $key+1 ?></td>
                <td><?php echo $submissionResult['fname']. ' ' .$submissionResult['lname'] ?></td>
                <td>
                    <button type="button" onclick="previewFile('<?php echo $submissionResult['submission_file']; ?>')">Preview</button>
                    <button type="button" onclick="deleteSubmission('<?php echo $submissionResult['submission_id']; ?>')" >Delete</button>
                    <a href="#provide-feedback" data-modal="#provide-feedback" rel="modal:open" onclick="provideFeedback('<?php echo $submissionResult['submission_id']; ?>')"><button>Provide Feedback</button></a>
                </td>            
            </tr>
        <?php } ?>
    </table>

<script type="text/javascript" src="../js/script.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<!-- jQuery Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.css" />
</body>
</html>

<?php 
    include_once 'popup_modal.php';
    } ?>

