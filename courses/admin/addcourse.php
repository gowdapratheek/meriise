<?php 

session_start();

if(!isset($_SESSION['email'])){
    header("Location: ../login.php");
    die();
}

if(isset($_POST['title'])){
	require_once '../config/db_connect.php';
	$title = mysqli_real_escape_string($conn, $_POST['title']);
	$price = mysqli_real_escape_string($conn, $_POST['price']);

    $title = htmlspecialchars($title);
    $price = htmlspecialchars($price);

	$insertQuery  = " INSERT INTO `course_list` (`title`, `price`) VALUES ('$title', '$price'); ";

  $result = mysqli_query($conn, $insertQuery);
	if($result){
      mysqli_free_result($result);
      mysqli_close($conn);
			header("Location: manage_courses.php");

      } else {
        echo mysqli_error($conn);
        exit("Something went wrong!!");
      }

}

?>
<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
            integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
            crossorigin="anonymous" />
        <link rel="stylesheet" href="../assets/css/dashboardstyles.css" />
        <!--css only-->

        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
            integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
            crossorigin="anonymous" />
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="../assets/css/transactionstyles.css" />

        <title>Add Courses</title>
        <script defer src="../assets/js/navjs.js"></script>
    </head>

    <body class="p-0 m-0 mx-auto offset-md-2">

        <nav class="m-0 mb-2">
            <button class="nav-btn menu"><i class="fas fa-bars"></i></button>
            <h3>Add Course</h3>
            <a class="nav-btn back" href="manage_courses.php"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>

            <div id="myNav" class="overlay">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fa fa-times"></i></a>
                <div class="overlay-content">
                    <a href="dashboard.php">Dashboard</a>
                    <a href="transactions.php">Transactions</a>
                    <a href="course_enrollments.php">Course Enrollments</a>
                    <a href="addcourse.php">Add Course</a>
                    <a href="student_details.php">Student Details</a>
                    <a href="logout.php" id="logout-nav">Logout</a>
                </div>
            </div>
        </nav>
        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-4 offset-2 m-auto ">
                    <form action='addcourse.php' method='POST'>
                        <div class="form-group">

                            <label for='title' class="mt-5">Course Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="Enter course title" required>
                            <label for="price" class="mt-3">Course Price</label>
                            <input type="number" class="form-control" name="price" id="price" min='1'
                                placeholder="Enter course price" required>

                            <button class='btn btn-primary btn-md my-3 float-right' type='submit'>Add</button>
                        </div>
                    </form>
                </div>
            </div>
    </body>

</html>