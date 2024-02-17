<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Database connection parameters
$dbHost = 'localhost';
$dbName = 'birthday';
$dbUser = 'postgres';
$dbPassword = 'root';

// Image URL to be attached to the emails
$imageUrl = 'https://www.happybirthdaypics.org/wp-content/uploads/2017/12/Happy-Birthday-Pic-14.jpg'; // Replace with the actual image URL

// Establish a database connection
$pdo = connectToDatabase($dbHost, $dbName, $dbUser, $dbPassword);

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {

    // Get birthdays today (ignoring the year)
    $currentDate = date('m-d');
    $currentYear = date('Y');
    $sql_birthdays = "SELECT name, email FROM birthday_details WHERE TO_CHAR(dob, 'MM-DD') = :currentDate";
    $stmt = $pdo->prepare($sql_birthdays);
    $stmt->bindParam(':currentDate', $currentDate);
    $stmt->execute();

    if (!empty($stmt)) {
        // Fetch the results as an associative array
        $birthdays = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Email configuration
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'saisumanthallam@gmail.com';
        $mail->Password = 'norj mexh piju pqyg'; // Replace with your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('saisumanthallam@gmail.com', 'sumanth');
        $mail->addReplyTo('saisumanthallam@gmail.com', 'sumanth');

        $mail->isHTML(true);

        foreach ($birthdays as $birthdayPerson) {
            $name = $birthdayPerson['name'];
            $email = $birthdayPerson['email'];

            // Add recipient
            $mail->addAddress($email, $name);

            // Email content
            $mail->Subject = 'Happy Birthday!';
            $mail->Body = "Dear $name,\n\nHappy Birthday! Wishing you a fantastic day filled with joy and happiness.";

            // Attach image from URL
            $imageData = file_get_contents($imageUrl);
            $mail->addStringAttachment($imageData, 'birthday_image.jpg', 'base64', 'image/jpeg');

            // Send the email
            $mail->send();

            // Clear recipients and attachments for the next iteration
            $mail->clearAddresses();
            $mail->clearAttachments();
        }

        echo 'Birthday emails have been sent.';
        
        // JavaScript code for delayed redirect after 4 seconds
        echo '<script>';
        echo 'setTimeout(function() { window.location.href = "birthdaydashboard.php"; }, 1000);';
        echo '</script>';
    } else {
        echo 'No birthdays today.';
    }
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}";
}

// Function to establish a database connection
function connectToDatabase($host, $name, $user, $password)
{
    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$name", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        die();
    }
}
?>
