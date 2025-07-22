<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['email'], $data['amount'], $data['payment_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid data"]);
    exit;
}

$name = htmlspecialchars($data['name']);
$email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
$amount = intval($data['amount']);
$payment_id = htmlspecialchars($data['payment_id']);

if (!$email || $amount <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid email or amount"]);
    exit;
}

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = 'pratikshabide.comp.nbnstic@gmail.com'; // 🔁 Replace with your Gmail
    $mail->Password = 'ilyw weya prlu uitz';   // 🔁 Use your generated App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('pratikshabide.comp.nbnstic@gmail.com', 'AshaDeep Foundation');
    $mail->addAddress($email, $name); // 🔁 This sends to donor

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Thank you for your donation!';
    $mail->Body = "
        <h2>Dear $name,</h2>
        <p>Thank you for your generous donation of ₹$amount.</p>
        <p><strong>Payment ID:</strong> $payment_id</p>
        <p>We truly appreciate your support!</p>
        <br>
        <p>Warm regards,<br>AshaDeep Foundation Team</p>
    ";

    $mail->send();
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
}
?>
