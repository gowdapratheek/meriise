<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- CSS only -->

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
            integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
            crossorigin="anonymous" />
        <link rel="stylesheet" href="../assets/css/dashboardstyles.css" />
        <!--css only-->

        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Dashboard</title>
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

    <body class="p-1 m-2 offset-md-2">
        <div class="container-fluid">
            <div class="flex2">
                <div class="display-4 text-center">Dashboard</div>
                <div class="line"></div>
                <div class="c-nav">
                    <div class="admin">

                        <h4 class="email admin-item"><?php echo ($email); ?></h4>

                        <a href='logout.php' class="btn btn-danger m-2 p-2 admin-item admin-item-btn">Logout</a>

                    </div>

                </div>

            </div>

            <div class="card-container">

                <div class="row">

                    <div class="col-sm-4 card-itm">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Manage Courses</h4>
                                <p class="card-text">Manage Course and prices.</p>
                                <a href="manage_courses.php" class="btn btn-primary float-right go-btn">GO</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 card-itm">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Transactions</h4>
                                <p class="card-text">View all transactions, generate report.</p>
                                <a href="transactions.php" class="btn btn-primary float-right go-btn">GO</a>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-4 card-itm">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Course Enrollments</h4>
                                <p class="card-text">View all course enrollments.</p>
                                <a href="course_enrollments.php" class="btn btn-primary float-right go-btn">GO</a>
                            </div>
                        </div>
                    </div>



                    <div class="col-sm-4 card-itm">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title ">Enrollee Details</h4>
                                <p class="card-text">View enrollee details.</p>
                                <a href="student_details.php" class="btn btn-primary float-right go-btn">GO</a>
                            </div>
                        </div>
                    </div>





                </div>
            </div>
        </div>
    </body>

</html>