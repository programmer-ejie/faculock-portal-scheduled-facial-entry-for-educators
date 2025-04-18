<?php
    include('../db_connection/conn.php');

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $faculty_name = $_POST['facultyName'];
        $faculty_gmail = $_POST['facultyGmail'];
        $faculty_password = $_POST['facultyPassoword'];

        $sql = "INSERT INTO `users` (faculty_name,faculty_gmail,faculty_password) VALUES ('$faculty_name','$faculty_gmail','$faculty_password')";
        if(mysqli_query($conn,$sql)){
            header("Location: ../auth/register.php?modelStatus=true");
            exit();            
        }else{
            header("Location: ../auth/register.php?modelStatus=false");
            exit();    

        }
    }
?>