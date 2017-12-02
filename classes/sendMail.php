<?php

/**
 * Description of sendMail
 *
 * @author mwilliams
 */
//NOTE:  mwilliams:  check the path 
require_once __DIR__.'/../vendor/autoload.php';

//use PHPMailer;

class sendMail {
    //add properties to hold mailing attributes
    //protected can be accessed only within the class itself and by inherited classes.
    protected $toname; 
    protected $toemail;
    protected $fromname;
    protected $fromemail;
    protected $messagetext;
    protected $messagehtml;
    protected $mailsubject;
    protected $replytoname;
    protected $replytoemail;   
    
    //constructor
    /**
     * sendMail() Class
     * This class will send email using Gmail
     * @param string $replyToEmail
     * @param string $replyToName
     * @param string $mailSubject
     * @param string $messageHTML
     * @param string $messageTEXT
     * @param string $fromEmail
     * @param string $fromName
     * @param string $toEmail
     * @param string $toName
     */
    public function __construct(string $replyToEmail, string $replyToName,
                                string $mailSubject, string $messageHTML, 
                                string $messageTEXT, string $fromEmail,
                                string $fromName,
                                string $toEmail, string $toName) {
        
        $this->replytoemail=$replyToEmail;
        $this->replytoname=$replyToName;
        $this->mailsubject=$mailSubject;
        $this->messagehtml=$messageHTML;
        $this->messagetext=$messageTEXT;
        $this->fromemail = $fromEmail;
        $this->fromname=$fromName;
        $this->toemail=$toEmail;
        $this->toname=$toName;       
    }//end of constructor
    
    public function SendMail():bool   {
        
        //Instantiate the PHPMailer object
        $mail = new PHPMailer();
        
        //setup PHPMailer properties
        $mail->isSMTP();                        // Set mailer to use SMTP
        $mail->SMTPDebug = 0;                   // debugging 1=errors and messages, 2=messages only
        $mail->Host = 'smtp.gmail.com';         // Specify mail server
        $mail->Port = 465;                      // Gmail mail port  
        $mail->SMTPAuth = true;                                      // Enable SMTP authentication
        $mail->Username = 'knowledge@programming.oultoncollege.com'; // SMTP username
        $mail->Password = 'Oultons2011';                             // SMTP password
        $mail->SMTPSecure = 'ssl';                                   // Enable encryption, 'ssl', ,'tsl' also accepted

        $mail->From = $this->fromemail;                              //who mail is from
        $mail->FromName = $this->fromname;
        $mail->addAddress($this->toemail, $this->toname);            // Add a recipient


        if (!empty($this->replytoemail)) {
            $mail->addReplyTo($this->replytoemail, $this->replytoname);
        }
        $mail->isHTML(true);                            // Set email format to HTML
        $mail->Subject = $this->mailsubject;            //the email subject
        $mail->Body = $this->messagehtml;               //the HTML message body
        $mail->AltBody = $this->messagetext;            //Alternate message (text only version)
        
       
        //Send the Email
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
        
    }
    
}//end of class
