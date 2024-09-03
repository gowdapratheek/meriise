<?php 

	session_start();

    if(!isset($_SESSION['email'])){
        header("Location: ../login.php");
        die();
    }else{
        $email = $_SESSION['email'];
    }

    
    require_once '../config/db_connect.php';

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $deleteQuery = "DELETE FROM `course_list` WHERE `course_list`.`id` = ".$id."";



    if(mysqli_query($conn, $deleteQuery)){
			header("Location: manage_courses.php");
            die();
      } else {
        echo mysqli_error($conn);
        exit("Something went wrong!!");
      }
 ?>