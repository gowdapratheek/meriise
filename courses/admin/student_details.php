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

        <title>Student Details</title>
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
            <h3>Enrollee Details</h3>
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
                        <table class="table table-hover text-center mt-2" style="font-size: 15px">

                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">SI.No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">College</th>
                                    <th scope="col">Student/Faculty</th>
                                    <th scope="col">Selected Courses</th>
                                    <th scope="col">Total Amount</th>
                                    <th scope="col">Download PDF</th>


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

                                if(isset($_GET["id"])){
                                        $sId = $_GET["id"];
                                     $sql = "SELECT * FROM student WHERE id='$sId'";
                                }else{


                                $sql = "SELECT * FROM student ORDER BY id DESC LIMIT $start_from, $limit";
                                }

                                $result = mysqli_query($conn, $sql);

                                while($row = mysqli_fetch_assoc($result)){

                                    $sId = $row["id"];

                                    $courseSql = "SELECT c.title AS course_title, c.price AS course_price
                                                    FROM student AS s
                                                    INNER JOIN enrollment AS e
                                                    ON e.student_id = s.id
                                                    INNER JOIN course_list AS c
                                                    ON c.id =e.course_id
                                                    WHERE s.id = '$sId'";

                                    $courseRes =  mysqli_query($conn, $courseSql);

                                    if(!$courseRes){
                                        exit("somethig went wrong");
                                    }

                                    $selectedCourses="";
                                    $amount=0;

                                    while($courseRow = mysqli_fetch_assoc($courseRes)){
                                        $selectedCourses .= $courseRow["course_title"];

                                        $selectedCourses .= ", ";

                                        $amount += $courseRow["course_price"];
                                    }



                                   
                                    echo("
                                    
                                        <tbody>

                                            <tr>
                                                 <td></td>
                                                <td scope='col'>".$row["name"]."</td>
                                                <td scope='col'>".$row["email"]."</td>
                                                <td scope='col'>".$row["phone_no"]."</td>
                                                <td scope='col'>".$row["college"]."</td>
                                               <td scope='col'>".$row["understanding"]."</td>
                                               <td scope='col'>".$selectedCourses."</td>
                                               <td scope='col'>".$amount."</td>

                                               <td scope='col'><a class='btn btn-success btn-sm' href='makepdf.php?id=".$row["id"]."'>Download</a></td>
                                            </tr>

                                        </tbody>

                                    ");
                                }

                            ?>

                            </form>

                        </table>

                        <ul class="pagination pagination-md justify-content-start mx-5">
                            <?php   
                            if(isset($_GET["id"])){
                                return;
                            }
                            require_once '../config/db_connect.php';
                            $limit = 10;        

                            $sql = "SELECT COUNT(*) FROM student";   
                            $rs_result = mysqli_query($conn, $sql);   
                            $row = mysqli_fetch_row($rs_result); 

                            $total_records = $row[0];   
                             
                            $total_pages = ceil($total_records / $limit);   
                            $pagLink = "";                         
                            for ($i=1; $i<=$total_pages; $i++) { 
                                if ($i==$pn) { 
                                    $pagLink .= "<li class='active page-item'><a class='page-link' href='student_details.php?page="
                                                                        .$i."'>".$i."</a></li>"; 
                                }             
                                else  { 
                                    $pagLink .= "<li class='page-item'><a class='page-link' href='student_details.php?page=".$i."'> 
                                                                        ".$i."</a></li>";   
                                } 
                            }   
                            echo $pagLink;   

                        ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        </div>

    </body>

</html>