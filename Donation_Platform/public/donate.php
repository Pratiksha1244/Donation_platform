<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// load Composer's autoloader
require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donor_email = $_POST['email'] ?? '';
    $donor_name = $_POST['name'] ?? '';
    $donation_amount = $_POST['amount'] ?? '';
    $payment_id = $_POST['payment_id'] ?? '';


    if (empty($donor_email)) {
        echo "Error: donor email is empty.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP settings for Mailtrap
        $mail->isSMTP();
        $mail->Host       = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'c4ca1c567078bb';
        $mail->Password   = 'acb0f785532f55';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 2525;

        // sender & recipient
        $mail->setFrom('ashadeep@myngo.local', 'AshaDeep Foundation');
        $mail->addAddress($donor_email, $donor_name);

        // content
        $mail->isHTML(true);
        $mail->Subject = 'Thank you for your donation!';
        $mail->Body    = "
            <h2>Dear $donor_name,</h2>
            <p>Thank you for your generous donation of <strong>₹$donation_amount</strong>.</p>
            <p>Your support helps us continue our mission!</p>
            <br>
            <p>Warm regards,<br>Your NGO Team</p>
        ";

        $mail->send();
        echo "✅ Thank you, $donor_name! A receipt has been sent to your email (check Mailtrap inbox).";
    } catch (Exception $e) {
        echo "❌ Sorry, could not send receipt. Mailer Error: {$mail->ErrorInfo}";
    }

} else {
    echo "Please submit the form first.";
}
?>
