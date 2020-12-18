<?php

// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../usersystem/login.php");
    exit;
}

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
// The message

// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70, "\r\n");
$to      = 'paujordanoliveras@gmail.com';
$subject = 'Hello from php';
$message = getUserIpAddr();
$headers = 'From: planner@paupro.ddns.net' . "\r\n" .
    'Reply-To: paujordanoliveras@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();


// Send
$sent = mail($to, $subject, $message, $headers);
if ($sent) {
	echo "yes done ".$message;
}
else{
	error_log("Hi Log!", 0);
	echo "not done ";
}

?>