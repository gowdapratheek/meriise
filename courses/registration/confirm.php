<?php 

if(!(array_key_exists( "p", $_GET ) && !empty(trim($_GET[ 'p'])))){
	die();
}

require_once '../config/db_connect.php';

$hash = mysqli_real_escape_string($conn, $_GET['p']);
$hash = htmlspecialchars(strip_tags($hash));


$transSql = "SELECT * FROM `transaction` WHERE signature = '$hash' LIMIT 1";

$res = mysqli_query($conn, $transSql);

$count = mysqli_num_rows($res);

if($count == 0 ){
	die();
}

$transRow = mysqli_fetch_assoc($res);

$name =$transRow["name"];
$email =$transRow["email"];
$totalAmount =$transRow["amount"];
$courseIds =$transRow["course_ids"];
$payId =$transRow["payment_id"];

$courseId_arr = explode (",", $courseIds); 
$courseArray =[];


foreach($courseId_arr as $cs) {
    
    //rechecking....
    $courseIdSql = "SELECT * FROM `course_list` WHERE id = '$cs' LIMIT 1";
    $res = mysqli_query($conn, $courseIdSql);
    $courseRow = mysqli_fetch_assoc($res);
    array_push($courseArray,$courseRow["title"]);
   }

?>

<html>

    <head>
        <title>Confirm</title>
        <link rel="stylesheet" type="text/css" href="../assets/css/verifystyles.css">
        <meta charset="utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
            integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
            crossorigin="anonymous" />
    </head>

    <body>

        <header>

            <div class="header-container">
                <div class="img-wrap">
                    <img src="../assets/img/mr_logo.png" class="logo1">
                </div>

                <div class="header-text">
                    <h3>MICRO-ENGINEERING CERTIFICATION PROGRAM</h3>
                    <p>DEPT. OF CSE & ME-RIISE, Malnad College of Engneering,Hassan</p>
                </div>
                <div class="img-wrap">
                    <img src="../assets/img/mce_logo.png" class="logo2">
                </div>
            </div>

        </header>

        <div class="container">
           
            <h3>Registration successful <i class="far fa-check-circle"></i></h3>

            <div class="details">
                <h4 class="name"><?php echo htmlspecialchars($name); ?></h4>
                <h5 class="email"><?php echo htmlspecialchars($email); ?></h5>
                <h4 class="registerd">Registred Course/s:</h4>
                <div class="courses">

                    <?php  foreach($courseArray as $crs){?>
                    <p><?php echo htmlspecialchars($crs); ?></p>
                    <?php } ?>

                </div>
                <p class="payid"><strong>Payment Id:&nbsp;</strong><span><?php echo($payId); ?></span></p>
                <p class="amount"><strong>Amount:&nbsp;
                        &#x20B9;</strong>&nbsp;<span><?php echo ($totalAmount); ?></span></p>
                <p class="notify">You will be notified with an email soon.</p>

            </div>
        </div>





    </body>

</html>