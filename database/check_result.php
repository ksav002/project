<?php
    //yo function le chai database bata kei value return garyo vane true natra false pathauxa
    function checkResult($result,$connection) {
        if($result && mysqli_num_rows($result)>0){
            mysqli_close($connection);
            return true; // User exists and credentials are correct
        } else {
            mysqli_close($connection);
            return false; // User does not exist or credentials are incorrect
        }
    }
?>