<?php
    include('../db_connection/conn.php');

    if($_SERVER['REQUEST_METHOD'] == "POST"){
            $faculty_gmail = $_POST['faculty_gmail'];
            $faculty_password = $_POST['faculty_password'];

            if($faculty_gmail == "admin@gmail.com" || $faculty_password = "admin"){
                header("Location: ../admin/dashboard.php");
            }else{
              $sql = "SELECT * FROM users";
              $query = mysqli_query($conn,$sql);
              $status = 0;
  
          
                while($fetch = mysqli_fetch_assoc($query)){
                  if($faculty_gmail == $fetch['faculty_gmail']){
                      if($faculty_password == $fetch['faculty_password']){
                          header("Location: ../faculty/dashboard.php");
                          exit();
                      }else{
                          $status++;
                      }
                  }else{
                      $status++;
                  }
                }
  
                if($status > 0){
                  header("Location: ../auth/login.php?status=NoAccount");
                  exit();
                }   
            }       
    }
?>  