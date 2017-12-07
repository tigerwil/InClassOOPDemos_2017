<?php
// Check for empty fields
if(empty($_POST['fullname'])      ||
   empty($_POST['email'])     ||
   empty($_POST['phone'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
    //echo "No arguments Provided!";
    return false;
   }
$fullname = strip_tags(htmlspecialchars($_POST['fullname']));
$email_address = strip_tags(htmlspecialchars($_POST['email'])); 
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$email_subject = "Website inquiry from $fullname";
$message = strip_tags(htmlspecialchars($_POST['message']));


$messageHTML = "<p>You have received a new message from your website contact form.</p><p>Here are the details:</p>Name: $fullname<br>Email: $email_address<br>Phone: $phone<br>Message: $message";
$messageTEXT = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $fullname\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";

//Using PHPMailer (Gmail)
require 'sendmail.php';

$mail = new sendMail($email_address, $fullname, 
        $email_subject, $messageHTML, $messageTEXT, 
        'knowledge@programming.oultoncollege.com', 
        'Knowledge Is Power', 'mwilliams@oultoncollege.com', 'Marc Williams');
//Parameters:
//string $replyToEmail, string $replyToName,
//string $mailSubject, string $messageHTML, string $messageTEXT, 
//string $fromEmail,
//string $fromName,string $toEmail, string $toName

//Send the email
$result = $mail->SendMail();
if($result){
   //success
    //echo "success";
    return true;
}else{
    //fail
    //echo "fail";
    return false;
}
       