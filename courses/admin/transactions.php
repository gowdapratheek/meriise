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

        <title>Transactions</title>
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



        <nav class="m-0 mb-2">
            <button class="nav-btn menu"><i class="fas fa-bars"></i></button>
            <h3>Transactions</h3>
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
            <div class="row">

                <div class="table-responsive mx-2">

                    <table class="table table-hover text-center mt-2" style="font-size: 14px">

                        <thead class="thead-dark">
                            <tr>
                                 <th scope="col">SI.No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">College</th>
                                <th scope="col">Courses</th>
                                <th scope="col">Faculty/Student</th>
                                <th scope="col">Payment Id</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Payment Status</th>

                            </tr>
                        </thead>

                        <form method="post" action="">

                            <?php
    require_once '../config/db_connect.php';


    $limit = 10;        
    if (isset($_GET["page"])) {  
        $pn  = $_GET["page"];  
    }  
    else {  
        $pn=1;  
    };   

    $start_from = ($pn-1) * $limit; 

    $sql = "SELECT * FROM transaction ORDER BY row_key DESC LIMIT $start_from, $limit";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)){
        
        echo("
        
            <tbody>

                <tr>
                     <td></td>
                    <td scope='col'>".$row["name"]."</td>
                    <td scope='col'>".$row["email"]."</td>
                    <td scope='col'>".$row["phone"]."</td>
                    <td scope='col'>".$row["college"]."</td>
                    <td scope='col'>".$row["courses"]."</td>
                    <td scope='col'>".$row["understanding"]."</td>
                    <td scope='col'>".$row["payment_id"]."</td>
                    <td scope='col'>".$row["amount"]."</td>
                    <td scope='col'>".$row["payment_status"]."</td>

                    

                </tr>

            </tbody>

        ");
    }

?>

                        </form>

                    </table>

                    <ul class="pagination pagination-md justify-content-start mx-5">
                        <?php   

                            require_once '../config/db_connect.php';

                            $sql = "SELECT COUNT(*) FROM transaction";   
                            $rs_result = mysqli_query($conn, $sql);   
                            $row = mysqli_fetch_row($rs_result); 

                            $total_records = $row[0];   
                             
                            $total_pages = ceil($total_records / $limit);   
                            $pagLink = "";                         
                            for ($i=1; $i<=$total_pages; $i++) { 
                                if ($i==$pn) { 
                                    $pagLink .= "<li class='active page-item'><a class='page-link' href='transactions.php?page="
                                                                        .$i."'>".$i."</a></li>"; 
                                }             
                                else  { 
                                    $pagLink .= "<li class='page-item'><a class='page-link' href='transactions.php?page=".$i."'> 
                                                                        ".$i."</a></li>";   
                                } 
                            }   
                            echo $pagLink;   

                        ?>
                    </ul>
                    <span class="d-flex justify-content-center">
                        <a href='generateReport.php' class="btn btn-primary btn-md">Generate Report </a>
                    </span>
                </div>
            </div>



        </div>

    </body>

</html>