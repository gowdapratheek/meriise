<?php  
  
require_once '../config/db_connect.php';


session_start();

if(!isset($_SESSION['email'])){
        header("Location: ../login.php");
        die();
    }else{
        $email = $_SESSION['email'];
}

$setSql = "SELECT 

name,
email,
phone,
college,
courses,
understanding,
payment_id,
amount,
payment_status
 from transaction";  

$setRec = mysqli_query($conn, $setSql);  
  
$columnHeader = '';  

$columnHeader = "Name"." \t".
                "Email"." \t".
                "Phone "." \t".
                "College "." \t".
                "Courses "." \t".
                "Faculty/Student "." \t".
                "Payment Id "." \t".
                "Amount"." \t".              
                "PaymentStatus";  
  
    $setData = '';  

    while ($rec = mysqli_fetch_row($setRec)) {  
        $rowData = '';  
        foreach ($rec as $value) {  
            $value = '"' . $value . '"' . "\t";  
            $rowData .= $value;  
        }  
        $setData .= trim($rowData) . "\n";  
    }  
        
        
    header("Content-type: application/octet-stream");  
    header('Content-Disposition: attachment;filename="StudentReport.xls"'); 
    header("Pragma: no-cache");  
    header("Expires: 0");  
        
    echo (ucwords($columnHeader) . "\n" . $setData . "\n");  
        
?>