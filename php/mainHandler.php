<?php

require '../../mail_config.php';

// Create the Transport
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
  ->setUsername($gmail_config['username'])
  ->setPassword($gmail_config['password']);

// Create the mailer
$mailer = Swift_Mailer::newInstance($transport);

if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"])
    && !empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["message"])) {

    $email = $_POST["email"];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $name = $_POST["name"];
        $message = $_POST["message"];
        $website = $_POST["website"];

        $br = "\n";
        $body = "Message from brainbowdevelopment.com" . $br;
        $body .= "Name: " . $name . $br;
        $body .= "Email: " . $email . $br;
        $body .= "Website: " . $website . $br;
        $body .= "Message: " . $message;

        // Create a message
        $message = Swift_Message::newInstance('Message from brainbowdevelopment.com')
            ->setFrom(array($email => $name))
            ->setTo(array('brainbowdevelopment@gmail.com' => 'brainbow development'))
            ->setBody($body);

        // Send the message
        $result = $mailer->send($message);

        $response = 'Message Sent';

    } else {
        $response = 'Not valid input.';
    }

} else {
    $response = "Sending Message Failed";
}

if (isset($response) && !empty($response) && !is_null($response)) {
    echo '{"ResponseData":' . json_encode($response) . '}';
}