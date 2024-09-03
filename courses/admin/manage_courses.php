<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
            integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
            crossorigin="anonymous" />

        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
            integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
            crossorigin="anonymous" />

        <link rel="stylesheet" href="../assets/css/transactionstyles.css" />
        <!--css only-->

        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Manage Courses</title>
        <script defer src="../assets/js/navjs.js"></script>
    </head>
    <?php 

    session_start();

    if(!isset($_SESSION['email'])){
        header("Location: ../login.php");
        die();
    }else{
        $email = $_SESSION['email'];
    }
?>






    <body class="p-0 m-0 mx-auto offset-md-2">




        <nav class="m-0">
            <button class="nav-btn menu"><i class="fas fa-bars"></i></button>
            <h3>Manage Courses</h3>
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
            <div class="flex2">

                <div class="admin add-course">
                    <a href='addcourse.php' class="btn btn-info admin-item admin-item-btn add-course-btn ">Add
                        Course &nbsp &nbsp<i class="fas fa-plus"></i></a><br>

                </div>

            </div>

            <div class="row">

                <div class="table-responsive mx-1 mb-2">
                    <table class="table table-hover text-center" style="font-size: 15px">

                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Price(&#8377)</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>

                            </tr>
                        </thead>


                        <?php
    require_once '../config/db_connect.php';

    $sql = "SELECT * FROM course_list";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
    $id = $row["id"];
        echo("
        
            <tbody>

                <tr>
                
                    <td scope='col'>".$row["title"]."</td>
                    
                    <td scope='col'>".$row["price"]."</td>

                    <td scope='col'>

                    <a class='btn btn-primary btn-sm' href='editcourse.php?id=".$id."'> Edit <i class='fas fa-pencil'></i></a>
                    </td>

                    <td scope='col'>

                    <a class='btn btn-danger btn-sm' href='deletecourse.php?id=".$id."'> Delete <i class='fas fa-trash'></i></a>
                    </td>

                </tr>

            </tbody>

        ");
    }

?>
                    </table>
                </div>
            </div>
    </body>

</html>