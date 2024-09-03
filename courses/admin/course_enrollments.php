<?php 
 session_start();

if(!isset($_SESSION['email'])){
    header("Location: ../login.php");
    die();
}else{
    $email = $_SESSION['email'];
}

require_once '../config/db_connect.php';

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- CSS only -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
            integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
            crossorigin="anonymous" />
        <link rel="stylesheet" href="../assets/css/transactionstyles.css" />
        <!--css only-->


        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
            integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
            crossorigin="anonymous" />
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Enrollments</title>
        <script defer src="../assets/js/navjs.js"></script>

    </head>

    <body class="p-0 m-0 mx-auto offset-md-2">

        <nav class="m-0 mb-2">
            <button class="nav-btn menu"><i class="fas fa-bars"></i></button>
            <h3>Course Enrollments</h3>
            <a class="nav-btn back" href="dashboard.php"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>

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


            <div class="container-fluid mt-4">


                <div class="row">

                    <div class="table-responsive mx-2">

                        <table class="table  table-hover text-center mt-2" style="font-size: 15px">

                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">SI.No</th>
                                    <th scope="col">Course Title</th>
                                    <th scope="col">No. of Students</th>
                                    <th scope="col">Details</th>
                                </tr>
                            </thead>
                            <?php
                            $sql = "SELECT c.id, c.title, COUNT(*) AS total_students
                                    FROM course_list AS c
                                    INNER JOIN enrollment AS e
                                    ON e.course_id = c.id
                                    INNER JOIN student AS s
                                    ON e.student_id = s.id
                                    GROUP BY c.id
                                    ORDER by total_students DESC";

                            $result = mysqli_query($conn, $sql);

                            while(
                            $row = mysqli_fetch_assoc($result)){
                            $courseId = $row["id"];
                            $courseName = $row["title"];
                            $noOfStudents = $row["total_students"];
							echo("
                        
                            <tbody>

                                <tr class = 'text-center text-uppercase'>
                                    <td></td>
                                    <td scope='col'>".$courseName."</td>
                                    <td scope='col'>".$noOfStudents."</td>

                                    <td scope='col'>
                                    
                                                <a class='btn btn-primary btn-sm'
                                                href='course_enrollment_details.php?id=".$courseId."'
                                                 >Details </a>
                                     </td>
                                </tr>

                            </tbody>

                        ");

									}

                                    mysqli_free_result($result);
                                    mysqli_close($conn);
                                
                            ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </body>

</html>