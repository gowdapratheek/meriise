<?php

    session_start();

if(!isset($_SESSION['email'])){
        header("Location: ../login.php");
        die();
    }else{
        $email = $_SESSION['email'];
}

    require_once '../config/db_connect.php';

    $id = mysqli_real_escape_string($conn,$_GET['id']);

    $query = "SELECT * FROM student WHERE id='$id'";

    $res = mysqli_query($conn, $query);
 
    while ($row = mysqli_fetch_assoc($res)){

        $name = $row['name'];
        $email = $row["email"];
        $phone = $row["phone_no"];
        $college = $row["college"];
        $understanding = $row["understanding"];
        $courses = $row["courses"];
        $amount = $row["amount"];

    }



    $courseSql = "SELECT c.title AS course_title, c.price AS course_price
                                                    FROM student AS s
                                                    INNER JOIN enrollment AS e
                                                    ON e.student_id = s.id
                                                    INNER JOIN course_list AS c
                                                    ON c.id =e.course_id
                                                    WHERE s.id = '$id'";

    $courseRes =  mysqli_query($conn, $courseSql);

    if(!$courseRes){
        exit("somethig went wrong");
    }

    $courses="";
    $amount=0;

    while($courseRow = mysqli_fetch_assoc($courseRes)){
        $courses .= $courseRow["course_title"];

        $courses .= ", ";

        $amount += $courseRow["course_price"];
    }



    ini_set("pcre.backtrack_limit", "30000000");

    require_once '../vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf();
    $data = '';

    $data .= '<html lang="en">
                <head>
                    <style>
                    .details{
                        margin:20px;

                    }
                    .ele{
                            font-size:18px;
                            margin:15px;
                            border-left: 7px solid cyan;
                            padding-left: 3px;
                            font-family:"Verdana";

                    }
    
                    </style>
                </head>
                <body>
                        <div class = "container">
                            <div style = "">
                                <div><h1 style = "text-align:center; padding-top:2%; text-transform:uppercase;">
                                    Enrollment</h1>
                                </div>
                            </div>
                 <div class="details">
                                <div class ="ele"> Name: <strong> '.$name.'</strong>  </div>
                                <div class ="ele"> Email:<strong> '.$email.' </strong> </div>
                                <div class ="ele"> Phone: <strong>'.$phone.' </strong> </div>
                                <div class ="ele"> College: <strong> '.$college.' </strong> </div>
                                <div class ="ele"> Courses:<strong> '.$courses.' </strong> </div>
                                <div class ="ele"> Faculty/Student:<strong> '.$understanding.'</strong> </div>
                                
                                <div class ="ele"> Amount: Rs.<strong>'.$amount.'</strong>  </div>
                                
                            </div>    
                        </div>

                </body>
            </html>';
                    
    $mpdf->WriteHTML($data);
    $mpdf->Output($name.'.pdf','D');

?>