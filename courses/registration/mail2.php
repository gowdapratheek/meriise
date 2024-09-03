<?php 
    
    
    function sendmail($email,$name,$courses,$totalAmount,$payId){

    $from = 'certificationprogram@meriise.org';
    
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    $headers[] = 'From: ME-RIISE<certificationprogram@meriise.org>';
    $headers[] = 'Reply-To: certificationprogram@meriise.org';
    $headers[] = 'X-Mailer: PHP/'.phpversion();

    $subj="Registration  Successful";
    $message = '<html><body>';
    $message .= '<p>Dear '.$name.', <p/>';
    $message .= '<p>Your registration for: </p>';
    $message .= '<p>'.$courses.'</p>';
    $message .= '<p>was successful<p>';
    $message .= '<h4>Amount: '.$totalAmount.'</h4>';
    $message .= '<h4>Pay Id: '.$payId.'</h4>';
    $message .= "</body></html>";
    $mailRes = mail($email,$subj,$message,implode("\r\n", $headers));
    

   


}

 ?>