<?php
require 'sendmail.php';

$messageHTML = "<p>You have received a new message from your website contact form.</p><p>Here are the details:</p>Name: Marc<br>Email: marc@localhost.com<br>Phone: 5068589696<br>Message:Hey there";
$messageTEXT = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: Marc\n\nEmail: marc@localhost.com\n\nPhone: 5068589696\n\nMessage:\nHey there";

$mail = new sendMail('knowledge@programming.oultoncollege.com', 'kpower', 
        'Mail Subject', $messageHTML, $messageTEXT, 
        'knowledge@programming.oultoncollege.com', 
        'Knowledge Is Power', 'mwilliams@oultoncollege.com', 'Marc Williams');
//string $replyToEmail, string $replyToName,
//string $mailSubject, string $messageHTML, 
//string $messageTEXT, string $fromEmail,
//string $fromName,
// string $toEmail, string $toName
// 
//Send the email
$result = $mail->SendMail();
if($result){
   echo "Message has been sent"; 
}else{
    echo "Mailer Error: " . $mail->ErrorInfo;
}