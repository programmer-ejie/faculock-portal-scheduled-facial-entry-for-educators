<?php
    include('../db_connection/conn.php');

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $faculty_name = $_POST['facultyName'];
        $faculty_gmail = $_POST['facultyGmail'];
        $faculty_password = $_POST['facultyPassoword'];

        $sql = "INSERT INTO `users` (faculty_name,faculty_gmail,faculty_password,faculty_age,faculty_department,faculty_position,faculty_school,status) VALUES ('$faculty_name','$faculty_gmail','$faculty_password',0,'No Data','No Data','No Data','Pending')";
        if(mysqli_query($conn,$sql)){
            header("Location: ../auth/register.php?modelStatus=true");
            exit();            
        }else{
            header("Location: ../auth/register.php?modelStatus=false");
            exit();    

        }
    }
?>