<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $amount = htmlspecialchars($_POST["amount"]);

    $to = "your_email@example.com"; // Replace with your actual receiving email
    $subject = "New Donation from $name";
    $message = "Name: $name\nEmail: $email\nAmount: ₹$amount";
    $headers = "From: $email";

    if (mail($to, $subject, $message, $headers)) {
        echo "Thank you for your donation!";
    } else {
        echo "Error sending donation details.";
    }
}
?>
