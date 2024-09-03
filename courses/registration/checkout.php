<?php 
  require('../config/razor_pay_config.php');
  require('../razorpay-php/Razorpay.php');
  
  session_start();
  use Razorpay\Api\Api;

  require_once '../config/db_connect.php';


  if(isset($_POST['checkout'])){
    
    $sql = "SELECT id,title,price FROM `course_list`";
    $result = mysqli_query($conn, $sql);


    $allCourses = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $courseArr = [];
    $selectedIdArr = [];
    
    foreach($allCourses as $course){
      $courseArr[$course["title"]] = $course["price"];
      $selectedIdArr[$course["title"]] = $course["id"];
    }


    if( !((array_key_exists( "name", $_POST ) && !empty(trim($_POST[ 'name']))) &&
        (array_key_exists( "email", $_POST ) && !empty(trim($_POST[ 'email']))) &&
        (array_key_exists( "phone", $_POST ) && !empty(trim($_POST[ 'phone']))) &&
        (array_key_exists( "college", $_POST ) && !empty(trim($_POST[ 'college'])))
     )){
        http_response_code(400);
        exit("<h1>400 Bad Request</h1>");
    }


    $total_amount = 0;
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $college = mysqli_real_escape_string($conn, $_POST['college']);

    $name = htmlspecialchars(strip_tags($name));
    $email = htmlspecialchars(strip_tags($email));
    $phone = htmlspecialchars(strip_tags($phone));
    $college = htmlspecialchars(strip_tags($college));

    $selectedCourses =$_POST['selectedCourses'];
    $selectedUnderstanding =$_POST['selectedUnderstanding'];
    
    $selectedCoursesString="";
    $selectedCoursesIdString="";


    try{

        foreach ($selectedCourses as $selectedCourse) {
         $total_amount += $courseArr[$selectedCourse];
         $selectedCoursesString.= $selectedCourse . "," ;
            
        $selectedCoursesIdString .= $selectedIdArr[$selectedCourse];
        $selectedCoursesIdString .= ",";
        }
    }catch(Exception $e)
    {   //checking form manipulation..
        http_response_code(400);
        exit("Bad request!!");
    }


    //for transactions
    $selectedCoursesString = substr($selectedCoursesString, 0, -1);
    $selectedCoursesIdString = substr($selectedCoursesIdString, 0, -1);


   


    ///payment init//
      $api = new Api($keyId, $keySecret);

      $orderData = [
    'receipt'         => 123456,
    'amount'          => $total_amount * 100, //  rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];


$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];




 $tempSql = "INSERT INTO `temp_selected_courses` ( `phone`, `email`, `selected_courses_str`, `selected_courses_id`, `total_amt`, `orderId`) VALUES ('$phone', '$email', '$selectedCoursesString', '$selectedCoursesIdString', '$total_amount','$razorpayOrderId');";

    
    $res2 = mysqli_query($conn, $tempSql);

    if(!$res2){
        exit("Someting went wrong");
    }


if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$checkout = 'automatic';
$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => "MICRO-ENGINEERING CERTIFICATION PROGRAM",
    "description"       => $selectedCoursesString,
    "image"             => "../assets/img/mce_logo.png",
    "prefill"           => [
    "name"              => $name,
    "email"             => $email,
    "contact"           => "91" . $phone,
    ],
    "notes"             => [
    "address"           => "Adress...",
    "merchant_order_id" => "12312321",
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);




 }else{  
    http_response_code(400);
    exit("<h2>400 Bad Request</h2>");
  }

 ?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Checkout</title>
        <link rel="stylesheet" type="text/css" href="../assets/css/checkoutstyles.css">

        <!-- fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Barlow">

    </head>

    <body>
        <div class="container">
            <div class="card-container">

                <h2>Checkout</h2>
                <div class="line"></div>
                <h3 id="name" class="card-item"><?php echo $name ?></h3>
                <h6 id="email"><?php echo $email; ?></h6>
                <div id="selected-courses" class="card-item">

                    <?php foreach ($selectedCourses as $course){ ?>

                    <div class="course-wrapper">
                        <div class="course-name"><?php echo htmlspecialchars($course); ?></div>
                        <div class="course-amount"><?php echo "&#8377 " . htmlspecialchars($courseArr[$course]); ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="amount card-item">
                    <div id="billing-amount">
                        <div class="course-name">Total amount</div>
                        <div class="course-amount"><?php echo "&#8377 ".$total_amount; ?></div>
                    </div>
                </div>
                <div class="buttons card-item">

                    <button id="back" onclick="goBack()">Back</button>

                    <form action="verify.php" method="POST">

                        <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="<?php echo $data['key']?>"
                            data-amount="<?php echo $data['amount']?>" data-currency="INR"
                            data-name="<?php echo $data['name']?>" data-image="<?php echo $data['image']?>"
                            data-description="<?php echo $data['description']?>"
                            data-prefill.name="<?php echo $data['prefill']['name']?>"
                            data-prefill.email="<?php echo $data['prefill']['email']?>"
                            data-prefill.contact="<?php echo $data['prefill']['contact']?>"
                            data-notes.shopping_order_id="3456" data-order_id="<?php echo $data['order_id']?>"
                            <?php if ($displayCurrency !== 'INR') { ?>
                            data-display_amount="<?php echo $data['display_amount']?>" <?php } ?>
                            <?php if ($displayCurrency !== 'INR') { ?>
                            data-display_currency="<?php echo $data['display_currency']?>" <?php } ?>>
                        </script>
                        <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
                        <input type="hidden" name="name" value="<?php echo $name ?>">
                        <input type="hidden" name="phone" value="<?php echo $phone ?>">
                        <input type="hidden" name="email" value="<?php echo $email ?>">
                        <input type="hidden" name="college" value="<?php echo $college ?>">

                        <input type="hidden" name="understanding"
                            value="<?php echo htmlspecialchars($selectedUnderstanding) ?>">

                    </form>

                </div>
                
                <div class="info">
                    <hr>
                    <div class="dis">
                   <span id="spn"> Disclaimer:</span>
                    </div>
                    Please Don't <span id="spn">Refresh / Close</span> tabs or payment popup after payment. <br> You will be automatically redirected after successful payment.
                </div>

            </div>
        </div>
    </body>


    <script>
    function goBack() {
        window.history.back();
    }
    </script>

</html>