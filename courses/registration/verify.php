<?php

require_once('../config/db_connect.php');

require('../config/razor_pay_config.php');

session_start();

require('../razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

if(isset($_POST['email'])){
    
}else{
    exit("Forbidden");
}

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);



    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }

    
    
}

if ($success === true)
{
    $payId = $_POST['razorpay_payment_id'];
    $orderId = $_POST['razorpay_order_id'];
    $sigHash = $_POST['razorpay_signature'];

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $phone= mysqli_real_escape_string($conn,$_POST['phone']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $college=mysqli_real_escape_string($conn,$_POST['college']);
    // $totalAmount =mysqli_real_escape_string($conn, $_POST['total_amt']);
    // $courses = mysqli_real_escape_string($conn,$_POST['courses']);
    $understanding =mysqli_real_escape_string($conn, $_POST['understanding']);

    // $selectedIdArr =mysqli_real_escape_string($conn, $_POST['selectedCoursesId']);
    // $courses = htmlspecialchars(strip_tags($courses));
    $understanding = htmlspecialchars(strip_tags($understanding));

    $payStatus="success";

    $oId = $_SESSION['razorpay_order_id'];

    $tempSql = "SELECT * FROM `temp_selected_courses` WHERE orderId ='$oId' AND email = '$email' AND phone ='$phone' ORDER BY id DESC LIMIT 1;";

    $res2 = mysqli_query($conn, $tempSql);

    if(!$res2){
        exit("something went wrong");
    }

    $tempRow =  mysqli_fetch_assoc($res2);
    $totalAmount = $tempRow["total_amt"];
    $courses = $tempRow["selected_courses_str"];

    $selectedIdArr = $tempRow["selected_courses_id"];


    $sql = "INSERT INTO transaction(payment_id,order_id,signature,name,phone,email,college, amount, courses,course_ids,understanding,payment_status) VALUES('$payId','$orderId','$sigHash','$name','$phone','$email','$college','$totalAmount','$courses','$selectedIdArr','$understanding','$payStatus')";

    if(mysqli_query($conn, $sql)){
      
      } else {
        //avoiding refreh//
       
        exit("Please note pay ID:".$payId);
      }

    $studentIdSql = "SELECT * FROM `student` WHERE email = '$email' AND phone_no ='$phone' LIMIT 1";

    $res = mysqli_query($conn, $studentIdSql);

    $count = mysqli_num_rows($res);
   

    if($count == 0){
    //student table
     $sql2 = "INSERT INTO student(name,email,phone_no,college,understanding) VALUES('$name','$email','$phone','$college','$understanding')";
    
     
    if(mysqli_query($conn, $sql2)){
      
      } else {
        
        echo mysqli_error($conn);
        exit("Something went wrong!! Please note pay ID:".$payId);
      }
    }
    

    $studentIdSql = "SELECT * FROM `student` WHERE email = '$email' AND phone_no ='$phone' ORDER BY id DESC LIMIT 1";
    
    $res = mysqli_query($conn, $studentIdSql);
    $studentRow = mysqli_fetch_assoc($res);
    $sId = $studentRow["id"];

    $courseId_arr = explode (",", $selectedIdArr); 
    $courseArray =[];
    foreach($courseId_arr as $cs) {
    
    //rechecking....
    $courseIdSql = "SELECT * FROM `course_list` WHERE id = '$cs' LIMIT 1";
    $res = mysqli_query($conn, $courseIdSql);
    $count = mysqli_num_rows($res);
    $courseRow = mysqli_fetch_assoc($res);
    $cId = $courseRow["id"];

    array_push($courseArray,$courseRow["title"]);

    $enrollmentSql = "INSERT INTO `enrollment` (`course_id`, `student_id`) VALUES ('$cId', '$sId');
";
    $finalRes = mysqli_query($conn, $enrollmentSql);
    if(!$finalRes){
        // echo mysqli_error($conn);
        echo "Duplicate enrollment found!!";
        exit("\nSomething went wrong!! \nPlease note pay ID:".$payId);
        }
    }
    
 
    require("mail2.php");
    
    sendmail($email,$name,$courses,$totalAmount,$payId);

    //mail2 meriise
    $meriise = 'meriisehsn@gmail.com';
    $body = 'Me-riise new registration by: '.$name;
    sendmail($meriise,$body,$courses,$totalAmount,$payId);

    header("Location: confirm.php?p=".$sigHash);
}
else
{

    $payId = $_POST['razorpay_payment_id'];
    $orderId = $_POST['razorpay_order_id'];
    $sigHash = $_POST['razorpay_signature'];

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $phone= mysqli_real_escape_string($conn,$_POST['phone']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $college=mysqli_real_escape_string($conn,$_POST['college']);
    $understanding =mysqli_real_escape_string($conn, $_POST['understanding']);

    $payStatus="failed";

    $sql = "INSERT INTO transaction(payment_id,order_id,signature,name,phone,email,college, amount, courses,understanding,payment_status) VALUES('$payId','$orderId','$sigHash','$name','$phone','$email','$college','$totalAmount','$courses','$understanding','$payStatus')";

    if(mysqli_query($conn, $sql)){
      
      } else {
        
        echo mysqli_error($conn);
        exit();
      }

      header("Location: failed.php");

}
?>


