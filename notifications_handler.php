<?
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendEmailNotification($toEmail, $subject, $message) {
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.yourmailserver.com'; // Set the SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'youremail@example.com'; // SMTP username
        $mail->Password = 'yourpassword'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('youremail@example.com', 'Catering Lezat');
        $mail->addAddress($toEmail); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo 'Email has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}