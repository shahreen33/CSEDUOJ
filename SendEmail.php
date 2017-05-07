  <!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SendEmail
 *
 * @author ASUS
 */
class SendEmail {
    //put your code here
  
function sendVerificationBySwift($email,$name,$id)
{
    require_once 'lib/swift_required.php';
    $subject = 'CSEDUOJ Signup | Verification'; // Give the email a subject
    $address="http://csedu.cf/cseduoj/verify.php?email=".$email."&hash=".$id;
    $body = '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Name: '.$name.'
Email:'.$email.'
User Id:'.$id.'
------------------------
 
Please click this link to activate your account:.
 '.$address;

        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
            ->setUsername('cseduoj1@gmail.com')
            ->setPassword('2430_0033')
            ->setEncryption('ssl');
        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance($subject)
            ->setFrom(array('noreply@cseduoj.com' => 'CSEDUOJ'))
            ->setTo(array($email))
            ->setBody($body);
        $result = $mailer->send($message);
}


function sendPasswordBySwift($email,$name, $id)
{
    require_once 'lib/swift_required.php';

    $subject = 'CSEDUOJ | Password Modification'; // Give the email a subject
    $address="http://csedu.cf/cseduoj/passwordReset.php?email=".$email."&hash=".$id;;
    $body = '
 
Thanks for signing up!
Seems like you have forgotten your password and requested to reset your password. Here is your credentials.
 
------------------------
Name: '.$name.'<br>
Email:'.$email.'<br>
User Id:'.$id.'<br>
------------------------
 
Please click this link to reset your password:.
 '.$address;

        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
            ->setUsername('cseduoj1@gmail.com')
            ->setPassword('2430_0033')
            ->setEncryption('ssl');

        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance($subject)
            ->setFrom(array('noreply@cseduoj.com' => 'CSEDUOJ'))
            ->setTo(array($email))
            ->setBody($body);

        $result = $mailer->send($message);
}

}
        ?>
        
    </body>
</html>


