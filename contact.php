<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $name = htmlspecialchars($name);

    $email = trim($_POST["email"]);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    $subject = trim($_POST["subject"]);
    $subject = filter_var($subject, FILTER_SANITIZE_STRING);
    $subject = htmlspecialchars($subject);

    $message = trim($_POST["message"]);
    $message = filter_var($message, FILTER_SANITIZE_STRING);
    $message = htmlspecialchars($message);

    if (!empty($name) &&!empty($email) &&!empty($subject) &&!empty($message)) {
        // Set the recipient email address
        $recipient = "rishirajnachiketa@gmail.com";

        // Set the email subject
        $subject = "New contact from $name";

        // Build the email content
        $email_content = "Name: $name\n";
        $email_content.= "Email: $email\n\n";
        $email_content.= "Subject: $subject\n\n";
        $email_content.= "Message:\n$message\n";

        // Build the email headers
        $email_headers = "From: $name <$email>";

        // Send the email
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 OK status header
            http_response_code(200);
            echo "Thank you! Your message has been sent.";
        } else {
            // Set a 500 Internal Server Error status header
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }
    } else {
        // Set a 400 Bad Request status header
        http_response_code(400);
        echo "Please fill in all required fields.";
    }

} else {
    // Not a POST request, set a 403 Forbidden status header
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}